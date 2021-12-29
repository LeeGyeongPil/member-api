<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Member 관리 모델
 * Class Member
 * @package App\Model\Member
 */
class Member extends Model
{
    protected $connection = 'mysql';
    protected $table = 'Member';
    protected $primaryKey = 'member_idx';

    public $timestamps = false;
}