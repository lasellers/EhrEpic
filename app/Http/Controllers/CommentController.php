<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Response;
use \Illuminate\Support\Facades\Response as FacadeResponse;
use \Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllComments(Request $request)
    {
        try {
            $comments = Comment::with(['patient', 'practitioner'])
                ->orderBy('id', 'desc')
                ->get();
            return response()->json($comments->toArray());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Comments lookup error ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComment($id)
    {
        try {
            $comment = Comment::with([ 'patient', 'practitioner'])->find($id);
            return response()->json($comment->toArray());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Comment lookup error' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createComment(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'practitioner_id' => 'required|numeric',
            'patient_id' => 'required|numeric',
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = [];
            foreach ($validator->errors()->getMessages() as $item) {
                $messages[] = $item;
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
            return response()->json([
                'message' => 'Comment create ' . $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }

    public function updateComment(Request $request, $id)
    {
        // todo
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
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
