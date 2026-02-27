<?php

namespace App\Http\Controllers;

use App\Models\Ports;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PortSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ports::query();

        // new unified filter logic
        if ($request->filled('filter_type') && $request->filled('filter_value')) {
            $type = $request->filter_type;
            $value = $request->filter_value;

            if ($type === 'customs_authorized') {
                $query->where('customs_authorized', $value == '1');
            } elseif ($type === 'status') {
                $query->where('is_active', $value === 'active');
            } elseif ($type === 'country') {
                $query->where('country', 'like', '%' . $value . '%');
            } else {
                $query->where($type, $value);
            }
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');

        $ports = $query->orderBy('name')->paginate(10);

        return view('ports.index', compact('ports'));

    //    $ports = Port::query()
    //         ->when($request->country, fn($q) => $q->where('country', $request->country))
    //         ->when($request->port_type, fn($q) => $q->where('port_type', $request->port_type))
    //         ->when($request->has('customs_authorized'), fn($q) => $q->where('customs_authorized', $request->customs_authorized))
    //         ->orderBy('name')
    //         ->paginate(10);

    //     return view('ports.index', compact('ports'));

}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
            'required',
            'string',
            'max:255',
            Rule::unique('ports')->where(fn ($query) =>
                $query->where('country', $request->country)
                ),
            ],
            'country' => 'required|string|max:100',
            // We'll generate it, so no need to validate manually entered coordinates
            // 'coordinates' => ['required', 'regex:/^-?\d{1,3}\.\d+,\s?-?\d{1,3}\.\d+$/'],
            'port_type' => 'nullable|string|max:100',
            'docking_capacity' => 'nullable|integer|min:0',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-90,90',
            'depth' => 'nullable|numeric|min:0',
            'max_vessel_size' => 'nullable|numeric|min:0',
            'security_level' => 'nullable|string|max:50',
            'port_manager' => 'nullable|string|max:255',
            'port_contact_info' => 'nullable|string|max:255',
            'hours_per_day' => 'required|integer|min:1|max:24',
            'days_per_week' => 'required|integer|min:1|max:7',
        ]);

        $coordinates = $this->getCoordinatesFromNominatim($request->name, $request->country);

        if (!$coordinates) {
            return back()->withInput()->withErrors(['coordinates' => 'Coordinates could not be found. Please enter manually.']);
        }

        $validated['coordinates'] = $coordinates;
        $validated['operational_hours'] = $request->hours_per_day . '/' . $request->days_per_week;

        // Ensure customs_authorized is always set
        $validated['customs_authorized'] = $request->has('customs_authorized') ? 1 : 0;

        Ports::create($validated);

        return redirect()->route('ports.index')->with('success', 'Port created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $port = \App\Models\Ports::findOrFail($id);
        return view('ports.edit', compact('port'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Log::debug('Port update started.', ['id' => $id]);

        $ports = Ports::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('ports')->where(function ($query) use ($request) {
                    return $query->where('country', $request->country);
                })->ignore($ports->id),
            ],
            'country' => 'required|string|max:100',
            'port_type' => 'nullable|string|max:100',
            'depth' => 'nullable|numeric|min:0',
            'docking_capacity' => 'nullable|integer|min:0',
            'max_vessel_size' => 'nullable|numeric|min:0',
            'security_level' => 'nullable|string|max:50',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'is_active' => 'required|boolean',
            'hours_per_day' => 'required|integer|min:1|max:24',
            'days_per_week' => 'required|integer|min:1|max:7',
            'port_manager' => 'nullable|string|max:255',
            'port_contact_info' => 'nullable|string|max:255',
        ]);

        Log::debug('Validated input:', $validated);

        // Check if name or country changed
        if (
            $request->name !== $ports->name ||
            $request->country !== $ports->country
        ) {
            Log::debug('Port name or country changed. Fetching new coordinates.');
            $coordinates = $this->getCoordinatesFromNominatim($request->name, $request->country);

            if (!$coordinates) {
                Log::warning('Coordinates not found for port.', ['name' => $request->name, 'country' => $request->country]);
                return back()->withInput()->withErrors([
                    'coordinates' => 'Coordinates could not be found. Please enter manually.'
                ]);
            }

            [$lat, $lon] = explode(',', $coordinates);
            $validated['latitude'] = $lat;
            $validated['longitude'] = $lon;
        } else {
            Log::debug('Using existing coordinates.');
        }

        // Always compute and save combined coordinates field
        $validated['coordinates'] = $validated['latitude'] . ',' . $validated['longitude'];

        // Combine hrs and days
        $validated['operational_hours'] = $request->hours_per_day . '/' . $request->days_per_week;

        Log::debug('Final update data:', $validated);

        // Ensure customs_authorized is always set
        $validated['customs_authorized'] = $request->has('customs_authorized') ? 1 : 0;

        $ports->update($validated);

        Log::info('Port updated successfully.', ['id' => $id]);

        return redirect()->route('ports.index')->with('success', 'Port updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ports = Ports::findOrFail($id);
        $ports->is_active = false;
        $ports->save();

        return redirect()->route('ports.index')->with('success', 'Port archived successfully.');
    }

    /**
    * Attempt to auto-fetch coordinates using OpenStreetMap Nominatim.
    */
    private function getCoordinatesFromNominatim($name, $country)
    {
        $query = urlencode("{$name}, {$country}");

        $response = Http::withHeaders([
            'User-Agent' => 'NaviCargoApp/1.0 (youremail@example.com)' // update this to your real contact
        ])->get("https://nominatim.openstreetmap.org/search?format=json&q={$query}");

        if ($response->successful() && count($response->json()) > 0) {
            $location = $response->json()[0];
            return $location['lat'] . ',' . $location['lon'];
        }

        return null; // fallback if no coordinates found
    }

}
