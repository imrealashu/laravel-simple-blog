<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use HandlesAuthorization;

    /**
     * Create a Post
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Delete a post.
     *
     * @param string $slug
     */
    public function delete($slug)
    {
        $post = Post::where('slug', $slug)->first();

        # If resouce not found then throw the user to 404
        if (!$post) {
            abort(404);
        }

        # Handles Authoriztion for the resource.
        if (auth()->user()->id !== $post->user_id) {
            $this->deny("You're not authorized to perform this action");
        }

        if (Post::destroy($post->id)) {
            return response([
                'data' => [
                    'message' => 'deleted successfully',
                ],
            ]);
        }

    }

    /**
     * Edit Post
     * @param string                   $slug
     * @param \Illuminate\Http\Request $request
     */
    public function edit($slug, Request $request)
    {
        $post = Post::where('slug', $slug)
            ->with(['comments' => function ($query) {
                $query->orderBy('created_at', 'desc');
                $query->with('user');
            },
            ])->first();

        # Send 404, if resouce not found.
        if (!$post) {
            abort(404);
        }

        # handles Authorization.
        if ($post->user_id !== $request->user()->id) {
            $this->deny("You're not authorized to perform this action");
        }

        return view('post.create', compact('post'));
    }

    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->with('user')->paginate(10);
        return view('home', compact('posts'));
    }

    /**
     * Search
     * @param Request $request
     */
    public function search(Request $request)
    {
        $query     = $request->get('q');

        $messages = [
            'q.required' => 'Please enter keyword to search',
        ];
        $validator = Validator::make($request->all(), [
            'q' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        # Search is being done on `title` and `description` only
        if ($query) {
            $posts = Post::where('title', 'LIKE', '%' . $query . '%')
                ->orWhere('description', 'LIKE', '%' . $query . '%')
                ->with('user')->paginate(10);
            return view('home', compact('posts'));
        }

        return redirect('/');
    }

    /**
     * Show a Post
     *
     * @param string $slug
     * @param \Illuminate\Http\Request $request
     */
    public function show($slug, Request $request)
    {
        $post = Post::where('slug', $slug)
            ->with(['comments' => function ($query) {
                $query->orderBy('created_at', 'desc');
                $query->with('user');
            },
            ])->first();
        return view('post.show', compact('post'));
    }

    /**
     * Store a post
     * @param Request $request
     */
    public function store(Request $request)
    {
        $user      = auth()->user();
        $validator = Validator::make($request->all(), [
            'title'       => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'error' => [
                    'message'    => 'validation error',
                    'attributes' => $validator->errors(),
                ],
            ]);
        }

        $request['is_published'] = true;
        $request['user_id']      = $user->id;
        $post                    = Post::create($request->all());

        if ($post) {
            return response([
                'data' => [
                    'message'    => 'post created successfully',
                    'attributes' => $post,
                ],
            ]);
        }

    }

    /**
     * @param $slug
     * @param Request $request
     */
    public function update($slug, Request $request)
    {
        $user      = auth()->user();
        $post = Post::where('slug', $slug);

        if (!$post) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'title'       => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'error' => [
                    'message'    => 'validation error',
                    'attributes' => $validator->errors(),
                ],
            ]);
        }

        # Authorization check
        if ($post->first()->user_id !== $request->user()->id) {
            $this->deny("You're not authorized to perform this action");
        }

        if ($post->update($request->all())) {
            return response([
                'data' => [
                    'message'    => 'post created successfully',
                    'attributes' => [
                        'post' => $post,
                        'url' => url()->previous()
                    ]
                ],
            ]);
        }

    }

}
