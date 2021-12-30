<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

# API 라우터
Route::middleware('auth.api')->group(function () {
    # 회원가입
    Route::post('/join', [MemberController::class, 'join']);
    # 회원 로그인(인증)
    Route::post('/login', [LoginController::class, 'login']);
    # 회원 로그아웃
    Route::post('/logout', [LoginController::class, 'logout']);
    # 단일 회원 상세 정보 조회
    Route::get('/member/{member_idx}', [MemberController::class, 'memberDetail']);
    # 단일 회원의 주문 목록 조회
    Route::get('/order/{member_idx}', [MemberController::class, 'memberOrders']);
    # 여러 회원 목록 조회
    Route::get('/member', [MemberController::class, 'memberList']);
});