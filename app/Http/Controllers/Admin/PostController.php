<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title'=>'required|max:250',
            'content' => 'required',
        ]);

        $postData = $request->all();
        $newPost = new Post;
        $newPost->fill($postData);
        $slug = Str::slug($newPost->title);
        $alternativeSlug = $slug;

        $postFound = Post::where('slug', $slug)->first();

        $counter = 1;
        while ($postFound){
            $alternativeSlug = $slug . '_' . $counter;
            $counter++;
            $postFound = Post::where('slug', $alternativeSlug)->first();
        }

        $newPost->slug = $alternativeSlug;
        $newPost->save();
        return redirect()->route('admin.posts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'title'=>'required|max:250',
            'content' => 'required',
        ]);

        $postData = $request->all();
        $editedPost = Post::findOrFail($id);
        $editedPost->fill($postData);
        $slug = Str::slug($editedPost->title);
        $alternativeSlug = $slug;

        $postFound = Post::where('slug', $slug)->first();

        $counter = 1;
        while ($postFound){
            $alternativeSlug = $slug . '_' . $counter;
            $counter++;
            $postFound = Post::where('slug', $alternativeSlug)->first();
        }

        $editedPost->slug = $alternativeSlug;
        $editedPost->update();
        return redirect()->route('admin.posts.show', compact('editedPost'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
