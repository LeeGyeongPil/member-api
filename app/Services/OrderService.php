<?php
namespace App\Services;

use Exception;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;

class OrderService
{
    private $ordersModel;

    public function __construct(Orders $orders)
    {
        $this->ordersModel = $orders;
    }

    public function list($member_idx)
    {
        try {
            return $this->ordersModel->select([
                    'order_no',
                    'product_name',
                    'order_datetime',
                    'pay_datetime',
                ])
                ->where('member_idx', $member_idx)
                ->orderBy('order_datetime', 'DESC')
                ->get()
                ->toArray();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}