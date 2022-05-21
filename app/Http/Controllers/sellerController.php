<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\DetailRequestAll;

class sellerController extends Controller
{
    public function listOrder () {
        $listOrder = Order::orderBy('order_id','desc')->get();

        if (is_null($listOrder)) {
            return response()->json(['message' => 'data not found']);
        }

        return response()->json(['data' => $listOrder]);
    }

    public function confirmed (DetailRequestAll $request) {
        DB::beginTransaction();
        
        $user = User::where('id',$request->user_id)->where('is_active',true)->first();

        if (!$user) {
            DB::rollback();
            return response()->json(['message' => 'user not found  or user is nonactive !']);
        }

        $confirmedOrder = Order::where('user_id',$user['id'])->update([
            'status' => 'confirmed / process',
        ]);

        if (!$confirmedOrder) {
            DB::rollback();
            return response()->json(['message' => 'confirmed failed']);
        }   

        DB::commit();
        return response()->json(['message' => 'confirmation success']);
    }
}
