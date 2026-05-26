<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Display All Posts
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $posts = $query->latest()->get();

        return view('posts.index', compact('posts'));
    }

    /*
    |--------------------------------------------------------------------------
    | Show Create Form
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('posts.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Store Post
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published'
        ]);

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post Created Successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | Show Single Post (Slug)
    |--------------------------------------------------------------------------
    */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /*
    |--------------------------------------------------------------------------
    | Show Edit Form
    |--------------------------------------------------------------------------
    */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Post
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published'
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post Updated Successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | Toggle Status (Publish / Draft)
    |--------------------------------------------------------------------------
    */
    public function toggleStatus(Post $post)
    {
        $post->status = $post->status === 'draft' ? 'published' : 'draft';
        $post->save();

        return back()->with('success', 'Post status updated!');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Post
    |--------------------------------------------------------------------------
    */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post Deleted Successfully');
    }
}