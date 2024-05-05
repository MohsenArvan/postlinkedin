<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PostResource::collection(Post::all());
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        // dd($request->all());
        $post = auth()->user()->posts()->create([
            'title' => $request->title,
            'description' => $request->description,
            'image_url' => $request->image_url,
            
        ]);

        $post->tags()->attach($request->tags);

        $post->load('tags');
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        // dd($request->all());
        $post->update($request->all());
        $post->tags()->sync($request->tags);
        $post->load('tags');
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        $post->tags()->detach();
        return response()->json(['message' => 'Post deleted successfully']);
    }

    public function getPostTag($tag_id){
        $tag = Post::whereHas('tags', function($query) use ($tag_id){
            $query->where('id', $tag_id);
        })
        ->with('tags')
        ->get();

        return PostResource::collection($tag);

    }
}
