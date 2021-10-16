<?php

namespace App\Http\Controllers;

use App\Order;
use App\Statistic;
use App\UserOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    /**
     * Store a new blog post.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // validate input from form
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'order' => 'required',
            'surname' => 'max:255',
            'phone' => 'required|min:10|max:10', //|unique:user_orders if phone exists, not inserted on table (beacuse is a unique key)
            'qt_pizza' => 'required|',
            'time' => 'required'
        ]);

        // there is at least error
        if ($validator->fails()) {
            return redirect('/home')
                ->withErrors($validator)
                ->withInput();
        }

        // Store the order...
        $this->createOrder($request);


        return redirect()->back();
    }

    // create order and user_order
    public function createOrder($request)
    {
        // get data from form (only for user)
        $getDataForUser = $request->only('name', 'surname', 'phone');

        // get data from form (only order)
        $getDataForOrder = $request->only('order', 'time', 'qt_pizza');

        // get only qt_pizza for statistics
        $getQt_pizza = $request->only('qt_pizza');

        // create User
        UserOrder::createUserOrder($getDataForUser, $getDataForOrder);

        // insert qt_pizza, order and user
        Statistic::statistic($getQt_pizza);
    }

    // retrieve info of the order from ajax call
    public static function getOrderById()
    {
        if (request()->ajax()) {
            $order_id = request()->order_id;
            return response()->json(['info_order' => Order::getOrder($order_id)]);
        }
    }

    // delete order from ajax call
    public static function deleteOrder()
    {
        if (request()->ajax()) {
            $order_id = request()->order_id;

            // call remove order and update statistics
            Statistic::deletedOrderOnStatistic($order_id);

            // get status order
            return response()->json(['delete_order' => Order::deleteOrder($order_id)]);
        }
    }

    // settings order from ajax cal
    public static function changeOrder()
    {
        if(request()->ajax())
        {
            $order_id = request()->order_id;
            return response()->json(['settings' => Order::getOrder($order_id)]);
        }
    }

    // update order and user information from form
    public static function updateOrder()
    {
        // validate input from form
        $validator = Validator::make(request()->all(), [
            'name' => 'required|max:255',
            'order' => 'required',
            'surname' => 'max:255',
            'phone' => 'required|min:10|max:10', /* phone unique is removed because now is updating
                                                    information and not inserting */
            'qt_pizza' => 'required|',
            'time' => 'required'
        ]);

        // there is at least error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Order::updateOrderUser(request()->all());
        return redirect()->back();
    }

    public static function notifyOrder()
    {
        if(request()->ajax())
        {
            return response()->json(['notify' => Order::notify()]);
        }
    }
}
