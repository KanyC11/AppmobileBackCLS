<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Evenement;
use Illuminate\Http\Request;

class EvenementController extends Controller
{
    public function index()
    {
        return Evenement::with('intervenants')->get();
    }

    public function store(Request $request)
    {
        $evenement = Evenement::create($request->all());

        if ($request->intervenants) {
            $evenement->intervenants()->attach($request->intervenants);
        }

        return $evenement;
    }

    public function show($id)
    {
        return Evenement::with('intervenants')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $evenement = Evenement::findOrFail($id);
        $evenement->update($request->all());

        if ($request->intervenants) {
            $evenement->intervenants()->sync($request->intervenants);
        }

        return $evenement;
    }

    public function destroy($id)
    {
        Evenement::destroy($id);
        return response()->json(['message' => 'Supprimé']);
    }
}
