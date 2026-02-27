<?php

namespace App\Http\Controllers;

use App\Models\Shipments;
use App\Models\Cargo;
use App\Models\Ships;
use App\Models\Ports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShipmentSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Shipments::with(['cargo', 'ships', 'originPort', 'destinationPort']);

        // Handle dynamic filters from dropdown
        if ($request->filled('filter_type') && $request->filled('filter_value')) {
                $filterField = $request->filter_type;
                $filterValue = $request->filter_value;

            // Allow only safe/expected fields
            $allowedFilters = ['status', 'origin_port_id', 'destination_port_id', 'ship_id', 'cargo_id'];

            if (in_array($filterField, $allowedFilters)) {
                $query->where($filterField, $filterValue);
            }
        }
         // Handle date range filter
        if (
            $request->filter_type === 'date_range' &&
            $request->filled('from_date') &&
            $request->filled('to_date')
        ) {
            $query->whereBetween('departure_date', [$request->from_date, $request->to_date]);
        }
        // Optional sorting (you can extend this in your UI later)
    if ($request->sort_by === 'departure_date') {
        $query->orderBy('departure_date');
    } elseif ($request->sort_by === 'arrival_estimate') {
        $query->orderBy('arrival_estimate');
    }

    $shipments = $query->paginate(10);

    // Always pass supporting data for the dynamic filter UI
    $ports = Ports::all();
    $ships = Ships::all();
    $cargo = Cargo::all();

    return view('shipments.index', compact('shipments', 'ports', 'ships', 'cargo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cargo_id' => 'required|exists:cargos,id',
            'ship_id' => 'required|exists:ships,id',
            'origin_port_id' => 'required|exists:ports,id',
            'destination_port_id' => 'required|exists:ports,id|different:origin_port_id',
            'departure_date' => 'required|date',
            'arrival_estimate' => 'required|date|after_or_equal:departure_date',
        ]);

        Shipments::create($validated);

        return redirect()->route('shipments.index')->with('success', 'Shipment created successfully.');
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
    public function edit(Shipments $shipments)
    {
        $cargo = Cargo::all();
        $ships = Ships::all();
        $ports = Ports::all();

        return view('shipments.edit', compact('shipments', 'cargo', 'ships', 'ports'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shipments $shipments)
    {
        $validated = $request->validate([
            'cargo_id' => 'required|exists:cargos,id',
            'ship_id' => 'required|exists:ships,id',
            'origin_port_id' => 'required|exists:ports,id',
            'destination_port_id' => 'required|exists:ports,id|different:origin_port_id',
            'departure_date' => 'required|date',
            'arrival_estimate' => 'required|date|after_or_equal:departure_date',
            'actual_arrival_date' => 'nullable|date|after_or_equal:departure_date',
            'status' => 'required|in:pending,in_transit,delivered,delayed,cancelled',
            'cancellation_reason' => 'nullable|required_if:status,cancelled|string|max:255',
        ]);

        // Optional status logic enforcement
        if ($request->status === 'delivered' && !$shipments->departure_date) {
            return back()->withErrors(['status' => 'Shipment cannot be marked as delivered before departure.']);
        }
        
        $shipments->update($validated);

        return redirect()->route('shipments.index')->with('success', 'Shipment updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipments $shipments)
    {
        $shipments->update([
            'status' => 'cancelled',
            'is_active' => false,
            'cancellation_reason' => 'Cancelled manually',
        ]);

        // Optional: notify client/crew via email/event

        return redirect()->route('shipments.index')->with('success', 'Shipment cancelled.');
    }
}
