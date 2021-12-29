<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Orders 관리 모델
 * Class Orders
 * @package App\Model\Orders
 */
class Orders extends Model
{
    protected $connection = 'mysql';
    protected $table = 'Orders';
    protected $primaryKey = 'order_no';

    public $timestamps = false;
    public $incrementing = false;
}