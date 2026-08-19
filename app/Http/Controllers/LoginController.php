<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;     // DB Lib 사용
use App\Models\Member;                 // eloquent 사용할 때 필요

class LoginController extends Controller
{
    public function check()
    {
        $uid = request('uid');          // 입력한 아이디
        $pwd = request('pwd');          // 입력한 암호

        // 입력한 아이디, 암호와 일치하는 직원정보 조사
        $row = Member::where('uid', '=', $uid)
                     ->where('pwd', '=', $pwd)
                     ->first();

        if ($row)                       // 있는 경우
        {
            session()->put('uid', $row->uid);     // 세션 저장
            session()->put('rank', $row->rank);
        }

        return view('main');
    }

    // ★ 교재 그림 그대로 logout 함수 추가
    public function logout()
    {
        session()->forget('uid');
        session()->forget('rank');

        return view('main');
    }
}
