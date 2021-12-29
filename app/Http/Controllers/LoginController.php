<?php
namespace App\Http\Controllers;

use Exception;
use App\Libraries\Util;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class LoginController extends Controller
{
    public function __construct()
    {
    }

    public function login()
    {
        try {
            # 유효성 체크
            
            return Util::responseJson(200, '0000', 'Member Join Success', []);
        } catch (Exception $e) {
            return Util::responseJson(500, '9999', 'Internal Server Error :: ' . $e->getMessage(), []);
        }
    }

    public function logout()
    {
        try {
            
            return Util::responseJson(200, '0000', 'Member Join Success', []);
        } catch (Exception $e) {
            return Util::responseJson(500, '9999', 'Internal Server Error :: ' . $e->getMessage(), []);
        }
    }
}