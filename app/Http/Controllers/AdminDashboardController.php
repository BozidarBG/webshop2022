<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function dashboard(){

        $start = Carbon::today()->startOfMonth()->subMonthsNoOverflow()->toDateString();
        $end = Carbon::today()->subMonthsNoOverflow()->endOfMonth()->toDateString();
        $todays_orders=Order::whereDate('created_at', today())->get();
        $yesterdays_orders=Order::whereDate('created_at', today()->subDays(1))->get();
        $orders_from_last_month=Order::whereBetween('created_at', [$start, $end])->get();
        $orders_from_this_month=Order::whereBetween('created_at', [Carbon::today()->startOfMonth(), Carbon::now()])->get();//???

            return view('admin.dashboard', [
                'page'=>'Dashboard',
                'order_count_today'=>$this->returnCount($todays_orders),
                'order_total_today'=>$this->returnTotal($todays_orders),
                'order_count_yesterday'=>$this->returnCount($yesterdays_orders),
                'order_total_yesterday'=>$this->returnTotal($yesterdays_orders),
                'order_count_this_month'=>$this->returnCount($orders_from_this_month),
                'order_total_this_month'=>$this->returnTotal($orders_from_this_month),
                'order_count_last_month'=>$this->returnCount($orders_from_last_month),
                'order_total_last_month'=>$this->returnTotal($orders_from_last_month),
                ]);
        }




    public function getChartData(){
            $orders_from_last_year=DB::table('orders')->select(
                DB::raw('count(id) as order_count'),
                DB::raw('sum(total) as total'),
                DB::raw("DATE_FORMAT(created_at, '%M') as month")
            )
            ->whereBetween('created_at', [
                Carbon::create('2021', '01', '01', '0', '0','0'), Carbon::create('2022', '01', '01', '0', '0','0')])
            ->groupBy('month')
            ->orderBy('created_at', 'ASC')
            ->get();

            return response()->json([
              'data'=>$orders_from_last_year
            ]);

    }

    protected function returnCount($orders){
        return $orders->count();
    }

    protected function returnTotal($orders){
        $total=0;
        foreach($orders as $order){
            $total +=$order->total;
        }
        return $total;
    }
}
