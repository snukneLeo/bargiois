<?php

namespace App;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    /**
     * Get the comments for the blog post.
     */
    public function orders()
    {
        return $this->hasMany('App\Orders');
    }

    public static function createUserOrder($dataUser, $dataOrder)
    {
        // get phone from user_orders with phone request
        $user_phone = DB::table('user_orders')
            ->select('phone')
            ->where('phone',$dataUser['phone'])
            ->get()->first();

        // check if phone already exists
        if (!(is_null($user_phone)))
        {
            // get user id from phone request
            $user_id = DB::table('user_orders')
                ->select('id as userId')
                ->where('phone',$dataUser['phone'])->get()->first();

            // add user_id on structure
            $dataOrder += ['user_id' => $user_id->userId];

            // create Order
            DB::table('orders')
                ->insert($dataOrder);
        }
        else
        {
            // insert user because not exist
            DB::table('user_orders')
                ->insert($dataUser);

            // get user id from phone request
            $user_id = DB::table('user_orders')
                ->select('id as userId')
                ->where('phone',$dataUser['phone'])->get()->first();

            // add user_id on structure
            $dataOrder += ['user_id' => $user_id->userId];

            // create Order
            DB::table('orders')
                ->insert($dataOrder);
        }
    }

    // retrieve all userorder
    public static function getUserOrder()
    {
        /* $orders = Order::all(); */
        $orders = DB::table('orders')
            ->select('*')
            ->orderBy('time')->get();
        $dataUserOrder = [];
        $allDataUserOrder = [];
        foreach ($orders as $order)
        {
            $user_order = UserOrder::find($order->user_id);
            $dataUserOrder = [
                'name' => $user_order->name,
                'surname' => $user_order->surname,
                'phone' => $user_order->phone,
                'order' => $order->order,
                'time' => $order->time,
                'qt_pizza' => $order->qt_pizza,
                'user_id' => $user_order->id,
                'order_id' => $order->id
            ];
            $allDataUserOrder [] = $dataUserOrder;
        }
        return $allDataUserOrder;
    }

    // search live for user (call by ajax)
    public static function searchLive($key)
    {
        $search_word = "%$key%";

        return DB::table('user_orders')
            ->select('*')
            ->where('name', 'like', $search_word)
            ->get();

    }

    public static function getUserById($id)
    {
        return UserOrder::find($id);
    }
}
