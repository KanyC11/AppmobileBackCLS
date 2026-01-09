<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    IntervenantController,
    EvenementController,
    CategorieController,
    DocumentController,
    MembreController,
    PodcastController
};

Route::apiResource('intervenants', IntervenantController::class);
Route::apiResource('evenements', EvenementController::class);
Route::apiResource('categories', CategorieController::class);
Route::apiResource('documents', DocumentController::class);
Route::apiResource('membres', MembreController::class);
Route::apiResource('podcasts', PodcastController::class);
Route::get('/dashboard', function () {
    return response()->json([
        'intervenants' => \App\Models\Intervenant::all(),
        'evenements'   => \App\Models\Evenement::all(),
        'categories'   => \App\Models\Categorie::all(),
        'documents'    => \App\Models\Document::all(),
        'membres'      => \App\Models\Membre::all(),
        'podcasts'     => \App\Models\Podcast::all(),
    ]);
});
