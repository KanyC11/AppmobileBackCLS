<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use Illuminate\Http\Request;

class PodcastController extends Controller
{
    public function index()
    {
        return Podcast::with(['categorie', 'membre'])->get();
    }

    public function store(Request $request)
    {
        return Podcast::create($request->all());
    }

    public function show($id)
    {
        return Podcast::with(['categorie', 'membre'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $podcast = Podcast::findOrFail($id);
        $podcast->update($request->all());
        return $podcast;
    }

    public function destroy($id)
    {
        Podcast::destroy($id);
        return response()->json(['message' => 'Supprimé']);
    }
}
