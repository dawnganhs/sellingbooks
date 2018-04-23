<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\APIBaseController as APIBaseController;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends APIBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate(20);
        if (is_null($orders)) {
            return $this->Error('Found 0 orders !');
        }
        return $this->sendData($orders->toArray());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = new Order;
        $order->total = $request->total;
        $order->status = $request->status;
        $order->id_user = Auth::guard('api')->id();
        $order->save();
        return $this->sendResponse($order, 'Ordered successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        if (is_null($order)) {
            return $this->sendError('Order not found !');
        } else {
            return $this->sendData($order->toArray());
        }
    }

    public function showOrderUser()
    {
        $orders = Order::where('id_user', Auth::guard('api')->id())->get();
        if (is_null($orders)) {
            return $this->sendError('You are have 0 !');
        } else {
            return $this->sendData($orders->toArray());
        }
    }

    public function deleteOrderUser($id)
    {
        $user = User::where('id', Auth::guard('api')->id())->first();
        $order = Order::find($id);
        if (is_null($order)) {
            return $this->sendError('Order not found !');
        }
        if ($order->status !== 'accept') {
            if ($user->id == $order->id_user) {
                $order->delete();
                return $this->sendResponse($id, 'Just deleted your order !');
            } else {
                return $this->sendError('Cannot delete order of another user !');
            }
        } elseif ($order->status == 'accept') {
            return $this->sendMessage('Your order has been approved ! You cannot cancel this order !');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (is_null($order)) {
            return $this->sendError('Order not found.');
        }
        $order->status = $request->status;
        $order->id_user = Auth::guard('api')->id();
        $order->save();
        return $this->sendResponse($order->toArray(), 'Order updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if (is_null($order)) {
            return $this->sendError('Order not found !');
        } else {
            $order->delete();
            return $this->sendResponse($id, 'Deleted successfully !');
        }
    }
}
