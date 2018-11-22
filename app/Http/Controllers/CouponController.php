<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Auth;

class CouponController extends Controller
{
    public function store(Coupon $coupon,Request $request)
    {
        $coupon = Coupon::query()->where('user_id',Auth::user()->id)->where('topic_id',$request->topic_id)->get();
        if($coupon) {
            return redirect()->to($coupon->topic->link());
        }
        $coupon->user_id = Auth::user()->id;
        $coupon->topic_id = $request->topic_id;
        $coupon->save();

        return redirect()->to($coupon->topic->link());
    }
}
