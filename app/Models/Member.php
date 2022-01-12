<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Member extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'Member';
    protected $primaryKey = 'member_idx';

    public $timestamps = false;

    public function orders()
    {
        return $this->hasMany('App\Models\Orders', 'member_idx', 'member_idx');
    }

    public function last_order()
    {
        return $this->orders()->select([
            'order_no',
            'member_idx',
            'product_name',
            'order_price',
            'order_datetime',
            'pay_datetime',
            'isLast' => function ($query) {
                $query->select(DB::raw('IF((SELECT MAX(order_datetime) FROM Orders AS o WHERE o.member_idx = Orders.member_idx)=order_datetime, 1, 0)'));
            },
        ])->having('isLast', 1);
    }
}
