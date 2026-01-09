<?php

use Illuminate\Support\Facades\Route;
use App\Models\Intervenant;
use App\Models\Evenement;
use App\Models\Document;
use App\Models\Categorie;
use App\Models\Membre;
use App\Models\Podcast;

Route::get('/test-db', function () {

    //  Test Intervenant
    $intervenant = Intervenant::create([
        'prenom' => 'Elho',
        'nom' => 'Diop',
        'sexe' => 'M',
    ]);

    //  Test Evenement
    $evenement = Evenement::create([
        'libelle' => 'Conférence Tech',
        'description' => 'Test de l\'evenement',
        'lien' => 'https://example.com',
        'date_debut' => '2026-01-10 10:00:00',
        'date_fin' => '2026-01-10 12:00:00',
        'type' => 'Conférence',
        'lieu' => 'Salle A',
    ]);

    // Attacher l'intervenant à l'événement
    $evenement->intervenants()->attach($intervenant->id);

    //  Test Categorie
    $categorie = Categorie::create([
        'libelle' => 'Tech',
        'description' => 'Documents techniques',
    ]);

    //  Test Document
    $document = Document::create([
        'libelle' => 'Article lancement',
        'description' => 'Document de test',
        'fichier' => 'artiche',
        'categorie_id' => $categorie->id, // obligatoire
    ]);

    //  Test Membre
    $membre = Membre::create([
        'prenom' => 'Awa',
        'nom' => 'mballo',
        'sexe' => 'F',
        'email' => 'awa.mballo@example.com',
        'telephone' => '770000000',
        'fonction' => 'Developpeur',
        'structure' => 'CitizenLab',
    ]);

    //  Test Podcast
    $podcast = Podcast::create([
        'titre' => 'Podcast Tech',
        'libelle' => 'test podcast',
        'description' => 'Podcast sur les technologies',
        'membre_id' => $membre->id,
        'fichier'=> ' ijj',
        'categorie_id'=> $categorie->id,
        'lien_audio' => 'https://example.com/audio.mp3',
        'date_publication' => '2026-01-08',
    ]);

    //  Retourner  toutes les données insérées
    return response()->json([
        'intervenant' => $intervenant,
        'evenement' => $evenement,
        'document' => $document,
        'categorie' => $categorie,
        'membre' => $membre,
        'podcast' => $podcast,
    ]);
});
