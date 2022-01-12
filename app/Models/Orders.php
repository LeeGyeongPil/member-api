<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'Orders';
    protected $primaryKey = 'order_no';

    public $timestamps = false;
    public $incrementing = false;

    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'member_idx', 'member_idx');
    }
}
