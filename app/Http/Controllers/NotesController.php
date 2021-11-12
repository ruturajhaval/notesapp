<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Notes;
use App\Models\NotesTags;

class NotesController extends Controller
{
    public function index(): JsonResponse
    {
        $notes = Notes::latest()->get();
        $idArray = array_column($notes->toArray(), 'id');
        $notestags = NotesTags::select("notes_tags.notes_id as id", "notes_tags.tags_id", "tags.tagname")->join('tags', 'notes_tags.tags_id', '=', 'tags.id')->whereIn('notes_tags.notes_id', $idArray)->get();
        // return $notestags;
        foreach ($notes as $key => $value) {
            $notes[$key]['tags_id'] = '';
            $notes[$key]['tagname'] = '';
            foreach ($notestags as $nvalue) {
                if ($value['id'] == $nvalue['id']) {
                    $notes[$key]['tags_id'] .= $nvalue['tags_id'].", ";
                    $notes[$key]['tagname'] .= $nvalue['tagname'].", ";
                }
            }
            $notes[$key]['tags_id'] = rtrim($notes[$key]['tags_id'], ", ");
            $notes[$key]['tagname'] = rtrim($notes[$key]['tagname'], ", ");
        }
        return response()->json($notes, 200);
    }

    public function show($id): JsonResponse
    {
        $notes[] = Notes::find($id)->toArray();
        $notestags = NotesTags::select("notes_tags.notes_id as id", "notes_tags.tags_id", "tags.tagname")->join('tags', 'notes_tags.tags_id', '=', 'tags.id')->where('notes_tags.notes_id', $id)->get();
        foreach ($notes as $key => $value) {
            $notes[$key]['tags_id'] = '';
            $notes[$key]['tagname'] = '';
            foreach ($notestags as $nvalue) {
                if ($value['id'] == $nvalue['id']) {
                    $notes[$key]['tags_id'] .= $nvalue['tags_id'].", ";
                    $notes[$key]['tagname'] .= $nvalue['tagname'].", ";
                } else {
                    $notes[$key]['tags_id'] = '';
                    $notes[$key]['tagname'] = '';
                }
            }
            $notes[$key]['tags_id'] = rtrim($notes[$key]['tags_id'], ", ");
            $notes[$key]['tagname'] = rtrim($notes[$key]['tagname'], ", ");
        }
        return response()->json($notes, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $checkData = Notes::where('title', $request->title)->first();
        if (empty($checkData)) {
            $notes[] = Notes::create($request->all());
            $tags = isset($request->tags) && !empty($request->tags) ? (strpos($request->tags, ",") !== false ? explode(",", $request->tags) : [$request->tags]) : array();
            $notesid = $notes[0]['id'];

            for ($i = 0; $i < count($tags); $i++) {
                NotesTags::create([
                    'notes_id' => $notesid,
                    'tags_id' => $tags[$i]
                ]);
            }

            return response()->json($notes, 201);
        } else {
            $result = array("status" => false,"ErrMessage" => "Entry with same title exists");
            return response()->json([$result], 200);
        }
    }

    /*public function update($id, Request $request): JsonResponse
    {
        $notes = Notes::where("id", $id)->update($request->all());

        if ($notes) {
            $notes = Notes::find($id);
            return response()->json($notes, 200);
        } else {
            $result = array("status" => false,"ErrMessage" => "Entry not updated");
            return response()->json($result, 200);
        }
    }*/

    public function delete($id): JsonResponse
    {
        $notes = Notes::where('id', $id)->delete();

        return response()->json($notes, 204);
    }
}
