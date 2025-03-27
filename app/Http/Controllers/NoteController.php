<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::orderBy('updated_at', 'desc')->get();

        return response()->json($notes);
    }

    public function store(Request $request)
    {
        $note = Note::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'body' => $request->body
        ]);

        if ($note) {
            return response()->json(['message' => 'Poznámka bola vytvorená'],
                Response::HTTP_CREATED);
        } else {
            return response()->json(['message' => 'Poznámka nebola vytvorená'],
                Response::HTTP_FORBIDDEN);
        }
    }
    public function show($id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json(['message' => 'Poznámka nebola nájdená'],
                Response::HTTP_NOT_FOUND);
        }

        return response()->json($note);
    }

    public function update(Request $request, $id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json(['message' => 'Poznámka nebola nájdená'],
                Response::HTTP_NOT_FOUND);
        }

        $note->update([
            'title' => $request->title,
            'body' => $request->body
        ]);

        return response()->json([
            'message' => 'Poznámka bola aktualizovaná',
            'note' => $note
        ]);
    }

    public function destroy($id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json(['message' => 'Poznámka nebola nájdená'],
                Response::HTTP_NOT_FOUND);
        }

        $note->delete();

        return response()->json(['message' => 'Poznámka bola vymazaná']);
    }

    public function searchNotes(Request $request)
    {
        $query = $request->query('q');

        if (empty($query)) {
            return response()->json(['message' => 'Musíte zadať dopyt na vyhľadávanie'],
                Response::HTTP_BAD_REQUEST);
        }

        $notes = Note::searchByTitleOrBody($query);

        if ($notes->isEmpty()) {
            return response()->json(['message' => 'Žiadne poznámky sa nenašli'],
                Response::HTTP_NOT_FOUND);
        }

        return response()->json($notes);
    }
}