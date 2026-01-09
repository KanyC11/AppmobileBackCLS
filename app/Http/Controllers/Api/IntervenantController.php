<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Intervenant;
use Illuminate\Http\Request;

class IntervenantController extends Controller
{
    public function index()
    {
        return Intervenant::with('evenements')->get();
    }

    public function store(Request $request)
    {
        return Intervenant::create($request->all());
    }

    public function show($id)
    {
        return Intervenant::with('evenements')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $intervenant = Intervenant::findOrFail($id);
        $intervenant->update($request->all());
        return $intervenant;
    }

    public function destroy($id)
    {
        Intervenant::destroy($id);
        return response()->json(['message' => 'Supprimé']);
    }
}
