<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * CargoController handles the CRUD operations for Cargo.
 */
   class CargoController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $cargo= Cargo::all();

            return view('cargo.index', compact('cargo'));
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return view('cargo.create');
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'weight' => 'required|numeric|min:0',
                'destination' => 'required|string|max:255',
                'shipment_date' => 'required|date',
                'status' => 'required|string|in:pending,shipped,delivered,cancelled',
            ]);

            Cargo::create($validated);

            return redirect()->route('cargo.index')->with('success', 'Cargo created successfully.');
        }

        /**
         * Display the specified resource.
         */
        public function show(Cargo $cargo)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Cargo $cargo)
        {
            $cargo = Cargo::findOrFail($cargo->id);

            if (!$cargo) {
                return redirect()->route('cargo.index')->with('error', 'Cargo not found.');
            }

            // Return the edit view with the cargo data
            return view('cargo.edit', compact('cargo'));
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, Cargo $cargo)
        {
            $validated = $request->validate([
                'description' => 'required|string|max:255',
                'weight' => 'required|numeric|min:0',
                'volume' => 'required|numeric|min:0',
                'destination' => 'required|string|max:255',
                'client_id' => 'required|exists:clients,id', // Assuming you have a Clients model
                'cargo_type' => 'required|string|in:perishable,dangerous,general,other',
                'is_active' => 'boolean',
            ]);

            $cargo->update($validated);

            return redirect()->route('cargo.index')->with('success', 'Cargo updated successfully.');
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Cargo $cargo)
        {
            $cargo->delete();

            return redirect()->route('cargo.index')->with('success', 'Cargo deleted successfully.');
        }
    }
