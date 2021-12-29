<?php
namespace App\Services;

use Exception;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class MemberService
{
    const PER_PAGE = 10;

    private $memberModel;

    public function __construct(Member $member)
    {
        $this->memberModel = $member;
    }

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
                    'Member.last_login_datetime',
            ]);

            # 아이디 검색
            if (empty($request->id) === false) {
                $query = $query->where('member_id', 'like', '%' . $request->id . '%');
            }

            # 이메일 검색
            if (empty($request->email) === false) {
                $query = $query->where('member_email', 'like', '%' . $request->email . '%');
            }

            return $query->offset(self::PER_PAGE * ($request->input('page', 1) - 1))->limit(self::PER_PAGE)->get()->toArray();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}