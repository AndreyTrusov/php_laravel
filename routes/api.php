<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

//Route::get('/funguje', [TestController::class, 'testAction']);
//Route::get('/form', [TestController::class, 'viewForm']);
//Route::post('/submit', [TestController::class, 'submitForm']);
//Route::post('/book/{id}', TestController::class);

Route::apiResource('/notes', NoteController::class);

Route::get('/notes-with-users', [NoteController::class, 'notesWithUsers']);
Route::get('/users-with-note-count', [NoteController::class, 'usersWithNoteCount']);
Route::get('/search-notes', [NoteController::class, 'searchNotes']);

Route::get('/users-with-notes-count', [NoteController::class, 'usersWithNotesCount']);
Route::get('/longest-and-shortest-note', [NoteController::class, 'longestAndShortestNote']);
Route::get('/notes-last-week', [NoteController::class, 'notesLastWeek']);
