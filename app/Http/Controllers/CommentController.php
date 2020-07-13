<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Response;
use \Illuminate\Support\Facades\Response as FacadeResponse;
use \Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\ResponseObject;

class CommentController extends Controller
{
    public function getAllComments(Request $request)
    {
        try {
            return response()->json(Comment::orderBy('id', 'desc')->get()->toArray());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Comments lookup error', Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function createComment(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'practitionerId' => 'required|max:80',
            'patientId' => 'required|max:80',
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = [];
            foreach ($validator->errors()->getMessages() as $item) {
                array_push($messages, $item);
            }
            return response()->json([
                'errors' => $messages,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'request' => $data
            ]);
        }

        try {
            $comment = Comment::create($data);
            $comment->save();
            return $comment->toArray();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Comment create ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
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
