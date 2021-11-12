<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notes;
use App\Models\NotesTags;

class NotesController extends Controller
{
    public function index()
    {
        $notes = Notes::latest()->get();
        $idArray = array_column($notes->toArray(), 'id');
        $notestags = NotesTags::select("notes_tags.fk_notes_id as id", "notes_tags.fk_tags_id", "tags.uk_tagname")->join('tags', 'notes_tags.fk_tags_id', '=', 'tags.id')->whereIn('notes_tags.fk_notes_id', $idArray)->get();
        // return $notestags;
        foreach ($notes as $key => $value) {
            $notes[$key]['fk_tags_id'] = '';
            $notes[$key]['uk_tagname'] = '';
            foreach ($notestags as $nvalue) {
                if ($value['id'] == $nvalue['id']) {
                    $notes[$key]['fk_tags_id'] .= $nvalue['fk_tags_id'].", ";
                    $notes[$key]['uk_tagname'] .= $nvalue['uk_tagname'].", ";
                }
            }
            $notes[$key]['fk_tags_id'] = rtrim($notes[$key]['fk_tags_id'], ", ");
            $notes[$key]['uk_tagname'] = rtrim($notes[$key]['uk_tagname'], ", ");
        }
        return response()->json($notes, 200);
    }

    public function show($id): json
    {
        $notes[] = Notes::find($id)->toArray();
        $notestags = NotesTags::select("notes_tags.fk_notes_id as id", "notes_tags.fk_tags_id", "tags.uk_tagname")->join('tags', 'notes_tags.fk_tags_id', '=', 'tags.id')->where('notes_tags.fk_notes_id', $id)->get();
        foreach ($notes as $key => $value) {
            $notes[$key]['fk_tags_id'] = '';
            $notes[$key]['uk_tagname'] = '';
            foreach ($notestags as $nvalue) {
                if ($value['id'] == $nvalue['id']) {
                    $notes[$key]['fk_tags_id'] .= $nvalue['fk_tags_id'].", ";
                    $notes[$key]['uk_tagname'] .= $nvalue['uk_tagname'].", ";
                } else {
                    $notes[$key]['fk_tags_id'] = '';
                    $notes[$key]['uk_tagname'] = '';
                }
            }
            $notes[$key]['fk_tags_id'] = rtrim($notes[$key]['fk_tags_id'], ", ");
            $notes[$key]['uk_tagname'] = rtrim($notes[$key]['uk_tagname'], ", ");
        }
        return response()->json($notes, 200);
    }

    public function store(Request $request)
    {
        $checkData = Notes::where('uk_title', $request->uk_title)->first();
        if (empty($checkData)) {
            $notes[] = Notes::create($request->all());
            $tags = isset($request->tags) && !empty($request->tags) ? explode(",", $request->tags) : array();
            $notesid = $notes[0]['id'];

            for ($i = 0; $i < count($tags); $i++) {
                NotesTags::create([
                    'fk_notes_id' => $notesid,
                    'fk_tags_id' => $tags[$i]
                ]);
            }

            return response()->json($notes, 201);
        } else {
            $result = array("status" => false,"ErrMessage" => "Entry with same title exists");
            return response()->json([$result], 200);
        }
    }

    /*public function update($id, Request $request)
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

    public function delete($id)
    {
        $notes = Notes::where('id', $id)->delete();

        return response()->json($notes, 204);
    }
}
