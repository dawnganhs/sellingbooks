<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\API\APIBaseController as APIBaseController;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends APIBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(10);
        if (count($categories) < 1) {
            return $this->sendMessage('Found 0 categories');
        }
        return $this->sendData($categories->toArray());
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
        $db_cate = Category::get();
        foreach ($db_cate as $result) {
            if ($request->slug == $result->slug) {
                return $this->sendError('This category already exits, please enter another name & slug !');
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
        $category = Category::create($input);
        $category->save();
        return $this->sendResponse($category->toArray(), 'Category created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return $this->sendError('Category not found.');
        }
        return $this->sendData($category->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return $this->sendError('Category not found.');
        }
        if($category->slug !== $request->slug){
            $db_cate = Category::get();
            foreach($db_cate as $result){
                if($request->slug == $result->slug){
                    return $this->sendError('This category already exits, please enter another name & slug !');
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
        $category->name = $input['name'];
        $category->slug = $input['slug'];
        $category->description = $input['description'];
        $category->save();
        return $this->sendResponse($category->toArray(), 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return $this->sendError('Category not found.');
        }
        $category->delete();
        return $this->sendResponse($id, 'Category deleted successfully');
    }

    public function categorywithcountbooks()
    {
        $countbook = Category::withCount('books')->paginate(10);
        return $this->sendData($countbook->toArray());
    }
}