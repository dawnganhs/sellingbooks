<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Category;
use App\History;
use App\Order;
use App\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\APIBaseController as APIBaseController;

class PageController extends APIBaseController
{
    public function GetHighligtsBook()
    {
        $books = Book::where('highlights', 1)->paginate(15);
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
                ])->paginate(15);
                return $this->sendData($books->toArray());
            } elseif ($request->select == 'author') {
                $authors = Author::paginate(15);
                $books = Book::where('id_author', $request->id_author)->where([
                    ['name', 'LIKE', '%' . $request->name . '%'],
                ])->paginate(15);
                return $this->sendData(['authors' => $authors, 'books' => $books]);
            } elseif ($request->select == 'category') {
                $categories = Category::paginate(15);
                $books = Book::where('id_category', $request->id_category)->where([
                    ['name', 'LIKE', '%' . $request->name . '%'],
                ])->paginate(15);
                return $this->sendData(['categories' => $categories, 'books' => $books]);
            }
        } else {
            $books = Book::paginate(15);
            return $this->sendData($books->toArray());
        }
    }

    public function checkout(Request $request)
    {
        $order = new Order;
        $order->total = $request->total;
        $order->status = null;
        $order->id_user = Auth::guard('api')->id();
        $order->save();

        foreach ($items as $key => $value) {
            $history = new History;
            $history->status = 'out';
            $history->quantity = $item->quantity;
            $history->id_book = $key;
            $history->save();
        }

        foreach ($items as $key => $value) {
            $order_detail = new OrderDetail;
            $order_detail->id_order = $order->id;
            $order_detail->id_book = $key;
            $order_detail->quantity = $value['qty'];
            $order_detail->price = ($value['price'] / $value['qty']);

            $order_detail->save();
        }

        return $this->sendMessage('Order successfully !');
    }
}
