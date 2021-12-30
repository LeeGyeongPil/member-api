<?php
namespace App\Http\Controllers;

use Exception;
use App\Libraries\Util;
use App\Http\Controllers\Controller;
use App\Services\MemberService;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    private $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    /*
     * POST::/api/login
     * 로그인
     * 
     * @PARAMETER
     *  id                      : 회원아이디
     *  password                : 회원비밀번호
     * 
     * @RETURN
     *  code                    : 응답코드
     *  message                 : 응답메세지
     *  data                    : 
     *      member_idx          : 식별자
     *      member_id           : 아이디
     *      member_name         : 이름
     *      member_nickname     : 닉네임
     *      last_login_datetime : 마지막로그인일자
     *      login_token         : 로그인토큰
     * 
     */
    public function login()
    {
        try {
            # 유효성 체크
            $validator = Validator::make(request()->all(), [
                'id'        => 'required|max:20',
                'password'  => 'required',
            ]);
            if ($validator->fails()) {
                return Util::responseJson(400, '1000', $validator->errors()->first(), []);
            }
            
            $data = $this->memberService->login(request());
            if (empty($data)) {
                return Util::responseJson(200, '2000', 'Login Fail');
            } elseif (is_string($data)) {
                return Util::responseJson(500, '9999', $data);
            } else {
                $data['login_token'] = $this->memberService->tokenRefresh($data);
                return Util::responseJson(200, '0000', 'Login Success', $data);
            }
        } catch (Exception $e) {
            return Util::responseJson(500, '9999', 'Internal Server Error :: ' . $e->getMessage(), []);
        }
    }

    /*
     * POST::/api/logout
     * 로그아웃
     * 
     * @PARAMETER
     *  member_idx  : 식별자
     *  token       : 로그인토큰
     * 
     * @RETURN
     *  code        : 응답코드
     *  message     : 응답메세지
     *  data        : 
     * 
     */
    public function logout()
    {
        try {
            # 유효성 체크
            $validator = Validator::make(request()->all(), [
                'member_idx'    => 'required',
                'login_token'   => 'required',
            ]);
            if ($validator->fails()) {
                return Util::responseJson(400, '1000', $validator->errors()->first(), []);
            }
            
            $result = $this->memberService->tokenValidation(request());
            if ($result === 0) {
                return Util::responseJson(200, '2000', 'Login Fail');
            } elseif (is_string($result)) {
                return Util::responseJson(500, '9999', $result);
            } else {
                $this->memberService->tokenDelete(request()->member_idx);
                return Util::responseJson(200, '0000', 'Logout Success');
            }
        } catch (Exception $e) {
            return Util::responseJson(500, '9999', 'Internal Server Error :: ' . $e->getMessage(), []);
        }
    }
}