<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateGalleryRequest;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Models\Gallery;
use App\Models\Image;
use App\Models\User;
use App\Models\Comment;

class GalleriesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $galleries = Gallery::all();

        // return response()->json($galleries); 

    $results = Gallery::with('user', 'images', 'comments');
    $galleries = $results->get();

    return response()->json($galleries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGalleryRequest $request)
    {
        $data = $request->validated();
        $user = User::findOrFail($request['id']);
        $user_id = $user->id;
        $gallery= Gallery::create([
            "name"=>$data['name'],
            "description"=>$data['description'],
            'user_id' => $user_id
        ]);
        foreach($data['listOfSource'] as $source) {
            $gallery->addImages($source, $gallery['id']);
        }
        
        return response()->json($gallery);
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

        $gallery = Gallery::findOrFail($id);
        $images = $gallery->images;
        $comments = $gallery->comments;
        $user = $gallery->user;
        $results= [
            'id' => $gallery->id,
            'name'=>$gallery->name,
            'description'=>$gallery->description,
            'created_at'=>$gallery->created_at,
            'updated_at'=>$gallery->updated_at,
            'images'=>$images,
            'user'=>$user,
            'comments'=>$comments
        ];

        return response()->json($results);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->comments()->delete();
        $gallery->images()->delete();
        $gallery->delete();
        return $gallery;
    }
}
