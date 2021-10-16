<?php

namespace App\Http\Controllers;

use App\UserOrder;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    // get data from search
    public function searchUser()
    {
        if(request()->ajax())
        {
            $keyUp = request('keyText');
            return response()->json(['userFilter' => UserOrder::searchLive($keyUp)]);
        }
    }

    // get user from id
    public function getUser()
    {
        if(request()->ajax())
        {
            $user_id = request('user_id');
            return response()->json(['user' => UserOrder::getUserById($user_id)]);
        }
    }
}
