<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function getAllComments(Request $request)
    {
        try {
            return response()->json(Comment::all()->toArray());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Comments lookup error', Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function createComment(Request $request)
    {
        // todo
    }

    public function getComment($id)
    {
        try {
            return response()->json(Comment::find($id)->toArray());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Comment lookup error', Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function updateComment(Request $request, $id)
    {
        // todo
    }

    public function deleteComment($id)
    {
        try {
            $result = Comment::find($id)->delete();
            return response()->json(['result' => $result]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Comment lookup error', Response::HTTP_INTERNAL_SERVER_ERROR]);
        }

    }
}
