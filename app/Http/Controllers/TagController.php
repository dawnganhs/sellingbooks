<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\APIBaseController as APIBaseController;
use App\Tag;
use Illuminate\Http\Request;
use Validator;

class TagController extends APIBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::paginate(15);
        if (count($tags) < 1) {
            return $this->sendMessage('Found 0 tags');
        }
        return $this->sendData($tags->toArray());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $db_tags = Tag::get();
        foreach ($db_tags as $result) {
            if ($result->slug == $request->slug) {
                return $this->sendError('This tag already exits !');
            }
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
        ], [
            'name.required' => 'Please enter name',
            'slug.required' => 'Please enter slug',
            'description.required' => 'Please enter description',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $tag = new Tag;
        $tag->name = $input['name'];
        $tag->slug = $input['slug'];
        $tag->description = $input['description'];
        $tag->save();
        return $this->sendResponse($tag->toArray(), 'Tag created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = Tag::find($id);
        if (is_null($tag)) {
            return $this->sendError('Tag not found.');
        }
        return $this->sendData($tag->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);
        if (is_null($tag)) {
            return $this->sendError('Tag not found.');
        }
        if ($tag->slug !== $request->slug) {
            $db_tags = Tag::get();
            foreach ($db_tags as $result) {
                if ($result->slug == $request->slug) {
                    return $this->sendError('This tag already exits !');
                }
            }
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
        ], [
            'name.required' => 'Please enter name',
            'slug.required' => 'Please enter slug',
            'description.required' => 'Please enter description',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $tag->update($input);
        return $this->sendResponse($tag->toArray(), 'Tag updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::find($id);
        if (is_null($tag)) {
            return $this->sendError('Tag not found.');
        }
        $tag->delete();
        return $this->sendResponse($id, 'Tag deleted successfully');
    }
}
