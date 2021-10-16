<?php

namespace App\Http\Controllers;
use App\Order;
use App\Statistic;
use App\UserOrder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // retrieve all order (call user_order model)
        $user_orders = UserOrder::getUserOrder();

        // get count order
        $count_order = Order::getOrderCount();

        // retrieve all statistics on statistics table
        // the getStatistics method return a collection (the collection is obtained by all() method from model)
        // the first method is applied on collection and get the first record
        $statistics = Statistic::getStatistics()->first();

        return view('home',[
                'user_orders' => $user_orders,
                'order_count' => $count_order,
                'statistics' => $statistics
            ]);
    }
}
