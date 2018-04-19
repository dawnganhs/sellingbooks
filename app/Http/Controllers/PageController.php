<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function GetHighligtsBook()
    {
        return Book::where('highlights', 1)->get();
    }

    public function GetNewBook()
    {
        return Book::whereDay('created_at', '<', '31')->get();
    }

    public function FindEveryThing(Request $request)
    {
        if ($request->name) {
            if ($request->select == 'book') {
                return Book::where([
                    ['name', 'LIKE', '%' . $request->name . '%'],
                ])->get();
            } elseif ($request->select == 'author'){
                return Author::where([
                    ['name', 'LIKE', '%' . $request->name . '%'],
                ]);
                
            }
        }
        //     elseif ($request->select == 'author') {
        //         $author = Author::find($request->name);
        //         $books = $author->books()->get();
        //     } elseif ($request->select == 'category') {
        //         $books = Category::where([
        //             ['name', 'LIKE', '%' . $request->select . '%'],
        //         ])->with('books')->get();
        //     }
        // } else {
        //     $book = Book::where([
        //         ['name', 'LIKE', '%' . $request->name . '%'],
        //     ])->get();
        // }
        // $select = null;
        // $books = Book::when($select, function ($query) use ($select) {
        //             return $query->where('id_author')->orWhere('id_category');
        //         }, function ($query) {
        //             return $query->orderBy('name');
        //         })
        //         ->get();

    }
}
