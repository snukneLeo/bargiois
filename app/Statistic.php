<?php

namespace App;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Order;

class Statistic extends Model
{
    // added new qt_pizza, new order and new user on statistics table
    public static function statistic($qt_pizza)
    {
        //update qt_pizza, qt_user, qt_orders on statistic table
        $getQt_pizza = Statistic::find(1); // 1 because there is only one record (forever)

        // sum qt_pizza from form + qt_pizza on db
        $updateQt_pizza = ((Integer)$qt_pizza['qt_pizza'] + (Integer)$getQt_pizza->qt_pizza);

        // add +1 of order because an order is created
        $updateQt_orders = ((Integer)$getQt_pizza->qt_orders + (Integer)1);
        // add +1 of user because an order is created and one user is created
        $updateQt_user = ((Integer)$getQt_pizza->qt_user + (Integer)1);


        // create structure for updating on statistics table
        $statisticsStructure = [
            'qt_pizza' => $updateQt_pizza,
            'qt_user' => $updateQt_user,
            'qt_orders' => $updateQt_orders,
            'updated_at' => now()
        ];

        // update value on statistic table
        try
        {
            DB::table('statistics')
                ->update($statisticsStructure);
        }
        catch (Exception $e)
        {
            dd($e);
            throw $e;
        }
    }

    // update with remove order count on stastitic table
    public static function deletedOrderOnStatistic($order_id)
    {
        // get user from order_id
        $user = DB::table('orders as o')
            ->select(['qt_pizza'])
            ->join('user_orders as uo', 'uo.id','=','o.user_id')
            ->where('o.id',$order_id)->get()->first();

        //update qt_pizza, qt_user, qt_orders on statistic table
        $getQt_pizza = Statistic::find(1); // 1 because there is only one record (forever)

        // sum qt_pizza from form - qt_pizza on db
        $updateQt_pizza = ((Integer)$getQt_pizza->qt_pizza - (Integer)$user->qt_pizza);

        // remove 1 of order because an order is created
        $updateQt_orders = ((Integer)$getQt_pizza->qt_orders - (Integer)1);
        // remove 1 of user because an order is created and one user is created
        $updateQt_user = ((Integer)$getQt_pizza->qt_user - (Integer)1);


        // create structure for updating on statistics table
        $statisticsStructure = [
            'qt_pizza' => $updateQt_pizza,
            'qt_user' => $updateQt_user,
            'qt_orders' => $updateQt_orders,
            'updated_at' => now()
        ];

        // update value on statistic table
        try
        {
            DB::table('statistics')
                ->update($statisticsStructure);
        }
        catch (Exception $e)
        {
            dd($e);
            throw $e;
        }
    }

    // get statistics for dashboard and total pasta for ajax call
    public static function getStatistics()
    {
        return Statistic::all();
    }

    // save total pasta on statistics table
    public static function saveTotalPasta($qt_total_pasta)
    {
        try
        {
            DB::table('statistics')
            ->update(['total' => (Integer)$qt_total_pasta['qt_total_pasta']]);
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    // update qt_pizza when settings is pressed on statisics table
    public static function updateQt_pizza()
    {
        // sum qt_pizza for each order
        $sumQt_pizza = DB::table('orders')
            ->select('qt_pizza')
            ->sum('qt_pizza');
        try
        {
            // update qt_pizza on statistics
            DB::table('statistics')
                ->update(['qt_pizza' => $sumQt_pizza]);
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }
}
