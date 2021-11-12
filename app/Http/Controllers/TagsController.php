<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;

class TagsController extends Controller
{
    public function index()
    {
        $tags = Tags::latest()->get();
        return response()->json($tags, 200);
    }

    public function show($id)
    {
        $tags = Tags::find($id);
        return response()->json($tags, 200);
    }

    public function store(Request $request)
    {
        $checkData = Tags::where('tagname', $request->tagname)->first();

        if (empty($checkData)) {
            $tags = Tags::create($request->all());

            return response()->json([$tags], 201);
        } else {
            $result = array("status" => false,"ErrMessage" => "Tag already exists");
            return response()->json([$result], 200);
        }
    }

    /*public function update($id, Request $request)
    {
        $tags = Tags::where("id", $id)->update($request->all());

        if ($tags) {
            $tags = Tags::find($id);
            return response()->json($tags, 200);
        } else {
            $result = array("status" => false,"ErrMessage" => "Entry not updated");
            return response()->json($result, 200);
        }
    }*/

    public function delete($id)
    {
        $tags = Tags::find($id);
        if (!empty($tags)) {
            $tags = Tags::where('id', $id)->delete();
            $result = array("status" => true,"Message" => "Entry Deleted");
            return response()->json($result, 200);
        } else {
            $result = array("status" => false,"ErrMessage" => "Entry Does not exist");
            return response()->json($result, 200);
        }
    }
}
