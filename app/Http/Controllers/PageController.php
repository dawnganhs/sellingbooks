<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Category;
use App\Http\Controllers\API\APIBaseController as APIBaseController;
use Illuminate\Http\Request;

class PageController extends APIBaseController
{
    public function GetHighligtsBook()
    {
        $books = Book::where('highlights', 1)->get();
        if (count($books) < 1) {
            return $this->sendMessage('Found 0 highlights book.');
        }
        return $this->sendData($books->toArray());
    }

    public function GetNewBook(Request $request)
    {
        $books = Book::whereBetween('created_at', [$request->startday, $request->finishday])->paginate(15);
        if (count($books) < 1) {
            return $this->sendMessage('Found 0 new book.');
        }
        return $this->sendData($books->toArray());
    }

    public function index(Request $request)
    {
        if ($request->name) {
            if ($request->select == 'book') {
                $books = Book::where([
                    ['name', 'LIKE', '%' . $request->name . '%'],
                ])->paginate(20);
                return $this->sendData($books->toArray());
            } elseif ($request->select == 'author') {
                $authors = Author::get();
                $books = Book::where('id_author', $request->id_author)->where([
                    ['name', 'LIKE', '%' . $request->name . '%'],
                ])->paginate(20);
                return $this->sendData(['authors' => $authors, 'books' => $books]);
            } elseif ($request->select == 'category') {
                $categories = Category::get();
                $books = Book::where('id_category', $request->id_category)->where([
                    ['name', 'LIKE', '%' . $request->name . '%'],
                ])->paginate(20);
                return $this->sendData(['categories' => $categories, 'books' => $books]);
            }
        } else {
            $books = Book::paginate(20);
            return $this->sendData($books->toArray());
        }
    }
}
