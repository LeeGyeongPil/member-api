<?php
namespace App\Services;

use Exception;
use App\Models\Member;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;

class MemberService
{
    const PER_PAGE = 10;

    private $memberModel;

    public function __construct(Member $member)
    {
        $this->memberModel = $member;
    }

    # 회원가입
    public function join($request)
    {
        try {
            $this->memberModel->insert([
                'member_id'         => $request->id,
                'member_name'       => $request->name,
                'member_nickname'   => $request->nick,
                'member_password'   => hash('sha256', $request->password),
                'member_tel'        => $request->tel,
                'member_email'      => $request->email,
                'member_gender'     => $request->gender,
                'join_datetime'     => DB::raw('NOW()'),
            ]);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    # 회원상세
    public function show($member_idx)
    {
        try {
            return $this->memberModel
                ->select([
                    'Member.member_idx',
                    'Member.member_id',
                    'Member.member_name',
                    'Member.member_nickname',
                    'Member.member_tel',
                    'Member.member_email',
                    'Member.member_gender',
                    'Member.join_datetime',
                    'Member.last_login_datetime',
                ])
                ->where('Member.member_idx', $member_idx)
                ->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    # 회원목록
    public function list($request)
    {
        try {
            $query = $this->memberModel->select([
                    'Member.member_idx',
                    'Member.member_id',
                    'Member.member_name',
                    'Member.member_nickname',
                    'Member.member_tel',
                    'Member.member_email',
                    'Member.member_gender',
                    'Member.join_datetime',
                    'Member.last_login_datetime'
            ]);

            # 아이디 검색
            $query = $query->when($request->id, function($query, $role) {
                return $query->where('member_id', 'like', '%' . $role . '%');
            });

            # 이메일 검색
            $query = $query->when($request->email, function($query, $role) {
                return $query->where('member_email', 'like', '%' . $role . '%');
            });

            # 가장 최근 주문
            $query = $query->with('last_order');

            return $query->offset(self::PER_PAGE * ($request->input('page', 1) - 1))->limit(self::PER_PAGE)->get()->toArray();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    # 로그인
    public function login($request)
    {
        try {
            return $this->memberModel
                ->select([
                    'Member.member_idx',
                    'Member.member_id',
                    'Member.member_name',
                    'Member.member_nickname',
                    'Member.last_login_datetime',
                ])
                ->where([
                    ['Member.member_id', $request->id],
                    ['Member.member_password', hash('sha256', $request->password)],
                ])->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    # 로그인 토큰 갱신
    public function tokenRefresh($member)
    {
        try {
            $loginToken = hash('sha1', $member['member_id'] . time() . 'idus');
            $this->memberModel
                ->where('Member.member_idx', $member['member_idx'])
                ->update([
                    'login_token'           => $loginToken,
                    'last_login_datetime'   => DB::raw('NOW()'),
                ]);
            return $loginToken;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    # 로그인 토큰 체크
    public function tokenValidation($request)
    {
        try {
            return $this->memberModel
                ->where([
                    ['Member.member_idx', $request->member_idx],
                    ['Member.login_token', $request->login_token],
                ])->count();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    # 로그인 토큰 삭제
    public function tokenDelete($member_idx)
    {
        try {
            $this->memberModel
                ->where('Member.member_idx', $member_idx)
                ->update([
                    'login_token'   => '',
                ]);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}