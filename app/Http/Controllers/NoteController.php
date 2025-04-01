<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with(['user', 'categories'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json($notes);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'title' => 'required|string|min:5|max:255',
                'body' => 'required|string|min:10',
                'categories' => 'sometimes|array|max:3',
                'categories.*' => 'exists:categories,id'
            ]);

            $note = Note::create([
                'user_id' => $validated['user_id'],
                'title' => $validated['title'],
                'body' => $validated['body']
            ]);

            if (!empty($validated['categories'])) {
                $note->categories()->sync($validated['categories']);
            }

            $note->load(['user', 'categories']);

            return response()->json([
                'message' => 'Poznámka bola vytvorená',
                'note' => $note
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Chyba pri vytváraní poznámky',
                'errors' => method_exists($e, 'errors') ? $e->errors() : [$e->getMessage()]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
    public function show($id)
    {
        $note = Note::with(['user', 'categories'])->find($id);

        if (!$note) {
            return response()->json([
                'message' => 'Poznámka nebola nájdená'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json($note);
    }

    public function update(Request $request, $id)
    {
        try {
            $note = Note::find($id);

            if (!$note) {
                return response()->json([
                    'message' => 'Poznámka nebola nájdená'
                ], Response::HTTP_NOT_FOUND);
            }

            $validated = $request->validate([
                'title' => 'required|string|min:5|max:255',
                'body' => 'required|string|min:10',
                'categories' => 'sometimes|array|max:3',
                'categories.*' => 'exists:categories,id'
            ]);

            $note->update([
                'title' => $validated['title'],
                'body' => $validated['body']
            ]);

            if (isset($validated['categories'])) {
                $note->categories()->sync($validated['categories']);
            }

            $note->load(['user', 'categories']);

            return response()->json([
                'message' => 'Poznámka bola aktualizovaná',
                'note' => $note
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Chyba pri aktualizácii poznámky',
                'errors' => method_exists($e, 'errors') ? $e->errors() : [$e->getMessage()]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
    public function destroy($id)
    {
        try {
            $note = Note::find($id);

            if (!$note) {
                return response()->json([
                    'message' => 'Poznámka nebola nájdená'
                ], Response::HTTP_NOT_FOUND);
            }

            $note->categories()->detach();

            $note->delete();

            return response()->json([
                'message' => 'Poznámka bola vymazaná'
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Chyba pri mazaní poznámky',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function searchNotes(Request $request)
    {
        try {
            $validated = $request->validate([
                'q' => 'required|string|min:2|max:100'
            ]);

            $query = $validated['q'];

            $notes = Note::with(['user', 'categories'])
                ->searchByTitleOrBody($query);

            if ($notes->isEmpty()) {
                return response()->json([
                    'message' => 'Žiadne poznámky sa nenašli'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json($notes);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Chyba pri vyhľadávaní poznámok',
                'errors' => method_exists($e, 'errors') ? $e->errors() : [$e->getMessage()]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function getNotesByUser($userId)
    {
        try {
            $validated = validator(['user_id' => $userId], [
                'user_id' => 'required|exists:users,id'
            ])->validate();

            $notes = Note::with(['categories'])
                ->where('user_id', $userId)
                ->orderBy('updated_at', 'desc')
                ->get();

            if ($notes->isEmpty()) {
                return response()->json([
                    'message' => 'Používateľ nemá žiadne poznámky'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json($notes);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Chyba pri získavaní poznámok používateľa',
                'errors' => method_exists($e, 'errors') ? $e->errors() : [$e->getMessage()]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
    public function getNotesByCategory($categoryId)
    {
        try {
            $validated = validator(['category_id' => $categoryId], [
                'category_id' => 'required|exists:categories,id'
            ])->validate();

            $notes = Note::with(['user', 'categories'])
                ->whereHas('categories', function($query) use ($categoryId) {
                    $query->where('categories.id', $categoryId);
                })
                ->orderBy('updated_at', 'desc')
                ->get();

            if ($notes->isEmpty()) {
                return response()->json([
                    'message' => 'V tejto kategórii nie sú žiadne poznámky'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json($notes);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Chyba pri získavaní poznámok z kategórie',
                'errors' => method_exists($e, 'errors') ? $e->errors() : [$e->getMessage()]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}