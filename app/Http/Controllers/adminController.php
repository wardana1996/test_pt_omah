<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\DetailRequestAll;

class adminController extends Controller
{
    public function listOrder () {
        $listOrder = Order::orderBy('order_id','desc')->get();

        if (is_null($listOrder)) {
            return response()->json(['message' => 'data not found']);
        }

        return response()->json(['data' => $listOrder]);
    }

    public function nonactiveUser (DetailRequestAll $request) {
        DB::beginTransaction();

        $user = User::where('id',$request->user_id)->first();

        if (!$user) {
            DB::rollback();
            return response()->json(['message' => 'user not found !']);
        }

        $nonactiveUser = User::where('id',$user['id'])->update([
            'is_active' => false,
        ]);

        if (!$nonactiveUser) {
            DB::rollback();
            return response()->json(['message' => 'nonactive failed']);
        }   

        DB::commit();
        return response()->json(['message' => 'nonactive success']);
    }

    public function deleteOrder (DetailRequestAll $request) {
        DB::beginTransaction();
        
        $user = User::where('id',$request->user_id)->first();

        if (!$user) {
            DB::rollback();
            return response()->json(['message' => 'user not found or user is nonactive !']);
        }

        $deleteOrder = Order::where('user_id',$user['id'])->delete();

        if (!$deleteOrder) {
            DB::rollback();
            return response()->json(['message' => 'delete failed']);
        }   

        DB::commit();
        return response()->json(['message' => 'delete success']);
    }
}
