<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CancelPendingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tự động hủy đơn hàng ở trạng thái Pending sau 8 giờ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Lấy thời điểm 8 giờ trước từ thời điểm hiện tại
        $eightHoursAgo = Carbon::now()->subHours(8);

        $orders = Order::where('STATUS','Pending')
                        ->where('OrderDate', '<=', $eightHoursAgo)
                        ->get();
        
        $count = 0;
        foreach($orders as $order){
            $order->STATUS = 'Cancelled';
            $order->CancelReason = 'Đơn hàng không được cửa hàng duyệt trong vòng 8 giờ sau khi đặt hàng';
            $order->save();
            $count++;

            Log::info("Đơn hàng #{$order->OrderID} đã tự động hủy do quá 8 giờ không được xử lý!");
        }



        $this->info("Đã hủy {$count} đơn hàng pending quá 8 giờ");
    }
}



