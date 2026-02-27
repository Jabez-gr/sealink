<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Clients::paginate(10); // Pagination
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'email_address'   => 'required|email|unique:clients,email_address',
            'phone_number'    => 'nullable|string|max:20',
            'address'         => 'nullable|string|max:255',
            'address_details' => 'nullable|string',
        ]);

        if (!empty($validated['phone_number'])) {
            $validated['phone_number'] = preg_replace('/\D/', '', $validated['phone_number']);
        }

        Clients::create($validated);

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $clients = Clients::findOrFail($id);
        return view('clients.edit', compact('clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $clients = Clients::findOrFail($id);

        $validated = $request->validate([
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'email_address'   => 'required|email|unique:clients,email_address,' . $clients->id,
            'phone_number'    => 'nullable|string|max:20',
            'address'         => 'nullable|string|max:255',
            'address_details' => 'nullable|string',
        ]);

        if (!empty($validated['phone_number'])) {
            $validated['phone_number'] = preg_replace('/\D/', '', $validated['phone_number']);
        }

        $clients->update($validated);

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $clients = Clients::findOrFail($id);
        $clients->update(['is_active' => false]);

        return redirect()->route('clients.index')->with('success', 'Client deactivated.');
    }
}