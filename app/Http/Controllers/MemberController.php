<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class MemberController extends Controller
{
    public function __construct()
    {
    }

    public function join()
    {
        $result = [
            'code'      => '0000',
            'message'   => '',
        ];
        return response()->json(
            $result,
            200,
            [
                'Content-Type' => 'application/json;charset=UTF-8',
                'Charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE
        );
    }

    public function memberDetail(int $member_idx)
    {
    }

    public function memberOrders(int $member_idx)
    {
    }

    public function memberDememberListtail()
    {
    }
}