<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class AddressController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Addresses/Index', [
            'addresses' => auth()->user()->addresses
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'name' => 'nullable|string|max:255',
            'is_default' => 'boolean'
        ]);

        if ($validated['is_default']) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        auth()->user()->addresses()->create($validated);

        return redirect()->back()->with('success', 'Adresse ajoutée avec succès');
    }

    public function update(Request $request, Address $address): RedirectResponse
    {
        $validated = $request->validate([
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'name' => 'nullable|string|max:255',
            'is_default' => 'boolean'
        ]);

        if ($validated['is_default']) {
            auth()->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->back()->with('success', 'Adresse mise à jour avec succès');
    }

    public function destroy(Address $address): RedirectResponse
    {
        $address->delete();
        return redirect()->back()->with('success', 'Adresse supprimée avec succès');
    }

    public function setDefault(Address $address): RedirectResponse
    {
        auth()->user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);
        
        return redirect()->back()->with('success', 'Adresse par défaut mise à jour');
    }
} 