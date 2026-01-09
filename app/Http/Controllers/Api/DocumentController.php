<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        return Document::with('categorie')->get();
    }

    public function store(Request $request)
    {
        return Document::create($request->all());
    }

    public function show($id)
    {
        return Document::with('categorie')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $doc = Document::findOrFail($id);
        $doc->update($request->all());
        return $doc;
    }

    public function destroy($id)
    {
        Document::destroy($id);
        return response()->json(['message' => 'Supprimé']);
    }
}
