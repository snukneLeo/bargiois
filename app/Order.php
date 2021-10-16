<?php

namespace App;

use Exception;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public static function getOrders()
    {
        return Order::all();
    }

    /**
     * Get the order that owns the user.
     */
    public function userOrder()
    {
        return $this->belongsTo('App\UserOrder');
    }

    public static function getOrder($id)
    {
        return DB::table('orders as o')
            ->select(['o.order', 'o.time', 'o.qt_pizza', 'u.name', 'u.surname', 'u.phone'])
            ->join('user_orders as u', 'u.id', '=', 'o.user_id')
            ->where('o.id', $id)->get()->first();
    }

    public static function deleteOrder($id)
    {
        try {
            DB::table('orders')->where('id', $id)->delete();
            return true;
        } catch (Exception $e) {
            return false;
            throw $e;
        }
    }

    public static function getOrderCount()
    {
        // get count of order
        $count_order = DB::table('orders')
                        ->select('*')
                        ->count();
        // set count order on session()
        session()->put('count_order',$count_order);
        session()->save();

        return $count_order;
    }

    // update order and user information
    public static function updateOrderUser($request)
    {
        // get user_id from order_id
        $user_id = DB::table('orders')
            ->select('user_id')
            ->where('id', $request['order_id'])
            ->get()->first();

        // get phone from user_orders with phone request
        $user_phone = DB::table('user_orders')
            ->select('phone')
            ->where('phone',$request['phone'])
            ->get()->first();

        // order, time, qt_pizza, user_id
        $update_order = [
            'order' => $request['order'],
            'time' => $request['time'],
            'qt_pizza' => $request['qt_pizza'],
            'user_id' => $user_id->user_id
        ];

        // check if phone already exists
        if (!(is_null($user_phone)))
        {
            // name, surname (user already exists and phone is unique)
            $update_user = [
                'name' => $request['name'],
                'surname' => $request['surname']
            ];
        }

        else
        {
            // name, surname, phone
            $update_user = [
                'name' => $request['name'],
                'surname' => $request['surname'],
                'phone' => $request['phone']
            ];
        }


        try {
            // update order and user information
            DB::table('orders')
                ->where('id',$request['order_id'])
                ->update($update_order);

            DB::table('user_orders')
                ->where('id',$user_id->user_id)
                ->update($update_user);
        } catch (Exception $e) {
            throw $e;
        }

        // then update qt_pizza on statistics table
        Statistic::updateQt_pizza();
    }

    // show notify of changeble
    public static function notify()
    {
        // get count order
        $count_order = session()->get('count_order');
        $count_order_db = DB::table('orders')
            ->count('*');

        if($count_order_db > $count_order) // added order
        {
            // update session value
            session()->put('count_order',$count_order_db);
            session()->save();
            return 'added';
        }
        else if( $count_order_db < $count_order) // deleted order
        {
            // update session value
            session()->put('count_order',$count_order_db);
            session()->save();
            return 'deleted';
        }
        return false; // no notify
    }
}
