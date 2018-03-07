<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    use HandlesAuthorization;

    /**
     * Stores a comment on a Post
     * @param $postId
     * @param Request   $request
     */
    public function store($postId, Request $request)
    {
        $user = auth()->user();
        $post = Post::findOrFail($postId);

        $messages = [
            'body.required' => 'The comment body field is required.',
        ];

        $validator = Validator($request->all(), [
            'body' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return response([
                'error' => [
                    'message'    => 'validation error',
                    'attributes' => $validator->errors(),
                ],
            ]);
        }

        # Adding User_id to the request object and creating the comment.
        $request['user_id'] = $user->id;
        $comment            = $post->comments()->create($request->all());

        if ($comment) {
            $comment = Comment::where('id', $comment->id)->with('user')->first();
            return response([
                'data' => [
                    'message'    => 'comment created successfully',
                    'attributes' => Post::where('id', $comment->post_id)
                        ->first()
                        ->comments()
                        ->orderBy('created_at', 'desc')
                        ->with('user')
                        ->get(),
                ],
            ]);
        }

    }

    public function delete($id, Request $request)
    {
        $user = auth()->user();
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== $user->id) {
            $this->deny("You're not authorized to perform this action");
        }

        if ($comment) {
            if ($comment->destroy($id)) {
                return response([
                    'data' => [
                        'message' => 'deleted successfully',
                        'attributes' => Post::where('id', $comment->post_id)
                        ->first()
                        ->comments()
                        ->orderBy('created_at', 'desc')
                        ->with('user')
                        ->get()
                    ]
                ]);
            }
        }

        return abort(404);
    }

}
