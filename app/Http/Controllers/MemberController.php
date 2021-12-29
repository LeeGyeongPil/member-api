<?php
namespace App\Http\Controllers;

use Exception;
use App\Libraries\Util;
use App\Http\Controllers\Controller;
use App\Services\MemberService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    private $memberService;
    private $orderService;

    public function __construct(MemberService $memberService, OrderService $orderService)
    {
        $this->memberService = $memberService;
        $this->orderService = $orderService;
    }

    /*
     * POST::/api/join
     * 회원가입
     * 
     * @PARAMETER
     *  id          : 회원아이디 (영문 대문자 + 소문자 + 숫자)
     *  name        : 회원이름 (한글 + 영문 대문자 + 소문자)
     *  nick        : 회원별명 (영문 소문자만)
     *  password    : 회원비밀번호 (최소 10자, 영어 대문자/소문자/숫자/특수문자 각 1개 이상 포함)
     *  tel         : 전화번호 (최대 13자, 숫자만)
     *  email       : 이메일 (최대 100자)
     *  gender      : 성별 (M:남성, F:여성)
     * 
     * @RETURN
     *  code        : 응답코드
     *  message     : 응답메세지
     *  data        : 
     */
    public function join()
    {
        try {
            # 유효성 체크
            $validator = Validator::make(request()->all(), [
                'id'        => 'required|unique:Member,member_id|regex:/^[a-zA-Z0-9]*$/|max:20',
                'name'      => 'required|regex:/^[가-힣a-zA-Z]*$/|max:20',
                'nick'      => 'required|regex:/^[a-z]*$/|max:30',
                'password'  => 'required|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/|min:10',
                'tel'       => 'required|regex:/^[0-9]*$/|max:13',
                'email'     => 'required|email|max:100',
                'gender'    => 'nullable|in:M,F',
            ]);
            if ($validator->fails()) {
                return Util::responseJson(400, '1000', $validator->errors()->first(), []);
            }

            $result = $this->memberService->join(request());
            if ($result === true) {
                # 가입성공
                return Util::responseJson(201, '0000', 'Member Join Success');
            } else {
                # 가입실패
                return Util::responseJson(409, '9998', $result);
            }
        } catch (Exception $e) {
            return Util::responseJson(500, '9999', 'Internal Server Error :: ' . $e->getMessage(), []);
        }
    }

    /*
     * GET::/api/member/{member_idx}
     * 단일 회원 상세 정보 조회
     * 
     * @PARAMETER
     *  member_idx              : 회원식별자
     * 
     * @RETURN
     *  code                    : 응답코드
     *  message                 : 응답메세지
     *  data                    : 회원정보데이터
     *      member_idx          : 식별자
     *      member_id           : 아이디
     *      member_name         : 이름
     *      member_nickname     : 닉네임
     *      member_tel          : 전화번호
     *      member_email        : 이메일
     *      member_gender       : 성별 (M:남성, F:여성)
     *      join_datetime       : 회원가입일자
     *      last_login_datetime : 마지막로그인일자
     * 
     */
    public function memberDetail($member_idx)
    {
        try {
            $data = $this->memberService->show($member_idx);
            if (empty($data)) {
                return Util::responseJson(200, '9998', 'No Data');
            } elseif (is_array($data) === false) {
                return Util::responseJson(500, '9999', $data);
            } else {
                return Util::responseJson(200, '0000', 'Member Info Success', $data);
            }
        } catch (Exception $e) {
            return Util::responseJson(500, '9999', 'Internal Server Error :: ' . $e->getMessage(), []);
        }
    }

    /*
     * GET::/api/order/{member_idx}
     * 단일 회원의 주문 목록 조회
     * 
     * @PARAMETER
     *  member_idx          : 회원식별자
     * 
     * @RETURN
     *  code                : 응답코드
     *  message             : 응답메세지
     *  data                : 회원주문정보데이터
     *      order_no        : 주문번호
     *      product_name    : 상품명
     *      order_datetime  : 주문일시
     *      pay_datetime    : 결제일시
     * 
     */
    public function memberOrders($member_idx)
    {
        try {
            $data = $this->orderService->list($member_idx);
            if (empty($data)) {
                return Util::responseJson(200, '9998', 'No Data');
            } elseif (is_array($data) === false) {
                return Util::responseJson(500, '9999', $data);
            } else {
                return Util::responseJson(200, '0000', 'Member Order List Success', $data);
            }
        } catch (Exception $e) {
            return Util::responseJson(500, '9999', 'Internal Server Error :: ' . $e->getMessage(), []);
        }
    }

    /*
     * GET::/api/order/{member_idx}
     * 여러 회원 목록 조회
     * 
     * @PARAMETER
     *  page                    : 페이지번호
     *  id                      : 아이디
     *  email                   : 이메일
     * 
     * @RETURN
     *  code                    : 응답코드
     *  message                 : 응답메세지
     *  data                    : 회원리스트데이터 (Array)
     *      member_idx          : 식별자
     *      member_id           : 아이디
     *      member_name         : 이름
     *      member_nickname     : 닉네임
     *      member_tel          : 전화번호
     *      member_email        : 이메일
     *      member_gender       : 성별 (M:남성, F:여성)
     *      join_datetime       : 회원가입일자
     *      last_login_datetime : 마지막로그인일자
     *      last_order_datetime : 마지막주문일자
     * 
     */
    public function memberList()
    {
        try {
            $data = $this->memberService->list(request());
            if (empty($data)) {
                return Util::responseJson(200, '9998', 'No Data');
            } elseif (is_array($data) === false) {
                return Util::responseJson(500, '9999', $data);
            } else {
                return Util::responseJson(200, '0000', 'Member List Success', $data);
            }
        } catch (Exception $e) {
            return Util::responseJson(500, '9999', 'Internal Server Error :: ' . $e->getMessage(), []);
        }
    }
}