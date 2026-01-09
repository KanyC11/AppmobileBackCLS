<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Membre;
use Illuminate\Http\Request;

class MembreController extends Controller
{
    public function index()
    {
        return Membre::all();
    }

    public function store(Request $request)
    {
        return Membre::create($request->all());
    }

    public function show($id)
    {
        return Membre::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $membre = Membre::findOrFail($id);
        $membre->update($request->all());
        return $membre;
    }

    public function destroy($id)
    {
        Membre::destroy($id);
        return response()->json(['message' => 'Supprimé']);
    }
}
