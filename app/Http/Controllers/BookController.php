<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Controllers\API\APIBaseController as APIBaseController;
use Illuminate\Http\Request;
use Validator;
use App\Tag;

class BookController extends APIBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::paginate(15);
        if (count($books) < 1) {
            return $this->sendMessage('Found 0 book');
        }
        return $this->sendData($books->toArray());
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
        if (Book::where('name', $request->name)->first()) {
            return $this->sendError('This book already exits, please enter another name !');
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'image' => 'required',
            'price' => 'required',
            'highlights' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'id_author' => 'required',
            'id_category' => 'required',
        ], [
            'name.required' => 'Please enter book name',
            'image.required' => 'Please enter book image',
            'price.required' => 'Please enter price',
            'highlights.required' => 'Please choose type highlights',
            'description.required' => 'Please enter book description',
            'quantity.required' => 'Please enter quantity this book',
            'id_author.required' => 'Please choose author',
            'id_category.required' => 'Please choose category',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $book = new Book;
        $book->name = $input['name'];
        $book->slug = str_slug($request->name);
        $book->price = $input['price'];
        $book->highlights = $input['highlights'];
        $book->description = $input['description'];
        $book->quantity = $input['quantity'];
        $book->id_author = $input['id_author'];
        $book->id_category = $input['id_category'];
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file->move('./images', $file->getClientOriginalName('image'));
            $image = $file->getClientOriginalName('image');
            $book->image = $image;
        }
        $book->save();
        // if($request->create_tag){
        //     $tag = new Tag;
        //     $tag->name = $request->tag_name;
        //     $tag->slug = str_slug($tag->name);
        //     $tag->save();
        // }
        $book->tags()->attach($request->id_tag);
        return $this->sendResponse($book->toArray(), 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);
        if (is_null($book)) {
            return $this->sendError('Book not found.');
        }
        return $this->sendData($book->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if (is_null($book)) {
            return $this->sendError('Book not found.');
        }
        if ($book->name !== $request->name) {
            if (Book::where('name', $request->name)->first()) {
                return $this->sendError('This book already exits, please enter another name !');
            }
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required',
            'highlights' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'id_author' => 'required',
            'id_category' => 'required',
        ], [
            'name.required' => 'Please enter book name',
            'price.required' => 'Please enter price',
            'highlights.required' => 'Please choose type highlights',
            'description.required' => 'Please enter book description',
            'quantity.required' => 'Please enter quantity this book',
            'id_author.required' => 'Please choose author',
            'id_category.required' => 'Please choose category',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $file->move('./images', $file->getClientOriginalName('image'));
            $image = $file->getClientOriginalName('image');
            $book->image = $image;
        }
        $book->name = $input['name'];
        $book->slug = str_slug($input['name']);
        $book->price = $input['price'];
        $book->highlights = $input['highlights'];
        $book->description = $input['description'];
        $book->quantity = $input['quantity'];
        $book->id_author = $input['id_author'];
        $book->id_category = $input['id_category'];
        $book->save();
        return $this->sendResponse($book->toArray(), 'Book updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        if (is_null($book)) {
            return $this->sendError('Book not found.');
        }
        $book->delete();
        return $this->sendResponse($id, 'Book deleted successfully');
    }

}
