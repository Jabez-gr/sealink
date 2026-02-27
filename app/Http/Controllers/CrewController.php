<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use Illuminate\Http\Request;

class CrewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $crew = Crew::all();

        return view('crew.index', compact('crew'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('crew.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'role' => 'required|string|max:100',
            'phone_number' => 'required|string|max:50|unique:crews,phone_number,',
            'nationality' => 'nullable|string|max:100',
            'ship_id' => 'nullable|exists:ships,id',
        ]);

        Crew::create($validated);

        return redirect()->route('crew.index')->with('success', 'Crew member created successfully.');   
    }

    /**
     * Display the specified resource.
     */
    public function show(Crew $crew)
    {
        $crew = Crew::findOrFail($crew->id);
        return view('crew.show', compact('crew'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Crew $crew)
    {
        return view('crew.edit', compact('crew'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Crew $crew)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'role' => 'required|string|max:100',
            'phone_number' => 'required|string|max:50|unique:crews,phone_number,',
            'nationality' => 'nullable|string|max:100',
            'ship_id' => 'nullable|exists:ships,id',
            'is_active' => 'nullable|boolean',
        ]);

        $crew->update($validated);

        return redirect()->route('crew.index')->with('success', 'Crew member updated successfully.');   

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Crew $crew)
    {
        $crew->delete();

        return redirect()->route('crew.index')->with('success', 'Crew member deleted successfully.');   
    }
}
