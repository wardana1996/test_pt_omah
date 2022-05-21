<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\DetailRequest;
use App\Http\Requests\CheckOutRequest;
use App\Http\Requests\DetailRequestAll;

class userController extends Controller
{
    public function checkOut (CheckOutRequest $request) {

        DB::beginTransaction();

        $today = Carbon::now();
        $invoiceNumber = Order::max('order_id');
        $code = (int) substr($invoiceNumber, 3, 3);
        $code++;
        $char = "INV-";
        $invoice = $char . sprintf("%03s", $code);

        $user = User::where('id',$request->user_id)->where('is_active',true)->first();

        if (!$user) {
            DB::rollback();
            return response()->json(['message' => 'user not found  or user is nonactive !']);
        }

        $isOrderExist = Order::where('user_id', $user['id'])
                ->where('product_code', $request->product_code)
                ->where('status','not confirmed')
                ->first();
        
        if ($isOrderExist) {
            $order = Order::where('user_id', $user['id'])
                ->where('product_code', $request->product_code)
                ->update([
                    'qty'           => ($isOrderExist['qty'] + $request->qty),
                    'price'           => ($isOrderExist['price'] + $request->price),
                ]);
        } else {
            $order = new Order();
            $order->product_code = $request->product_code;
            $order->user_id = $user['id'];
            $order->invoice = $invoice;
            $order->qty = $request->qty;
            $order->price = $request->price;
            $order->date_order = Carbon::now();
            $order->address = $request->address;
            $order->status = 'not confirmed';
            $order->save();
        }

        if (!$order) {
            DB::rollback();
            return response()->json(['message' => 'create order failed']);
        }   

        DB::commit();
        return response()->json(['message' => 'order success']);
    }

    public function checkOutDetail (DetailRequest $request) {
        DB::beginTransaction();

        $user = User::where('id',$request->user_id)->where('is_active',true)->first();

        if (!$user) {
            DB::rollback();
            return response()->json(['message' => 'user not found  or user is nonactive !']);
        }

        $detailOrder = Order::where('invoice', $request->invoice)->where('user_id', $user['id'])->first();

        if (is_null($detailOrder)) {
            return response()->json(['message' => 'data not found']);
        }

        DB::commit();
        return response()->json(['data' => $detailOrder]);
    }

    public function checkOutDetailAll (DetailRequestAll $request) {
        DB::beginTransaction();

        $user = User::where('id',$request->user_id)->where('is_active',true)->first();

        if (!$user) {
            DB::rollback();
            return response()->json(['message' => 'user not found  or user is nonactive !']);
        }

        $detailOrderAll = Order::where('user_id', $user['id'])->get();

        if (is_null($detailOrderAll)) {
            return response()->json(['message' => 'data not found']);
        }

        DB::commit();
        return response()->json(['data' => $detailOrderAll]);
    }
}
