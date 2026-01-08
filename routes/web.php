<?php
use App\Models\SnEvenement;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});    
   
Route::get('/test-db', function () {
    return SnEvenement::all();    
});

