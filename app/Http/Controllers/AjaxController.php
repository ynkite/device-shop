<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;      // DB Lib 사용할 때
use App\Models\Gubun;                  // Eloquent ORM 모델
use Response;                          // ★ 교재 추가

class AjaxController extends Controller
{
    // 목록
    public function index(Request $request)
    {
        $text1 = $request->input('text1');
        $data['text1'] = $text1;

        $data['list'] = $this->getlist($text1);
        $data['tmp']  = $this->qstring();

        return view('ajax.index', $data);
    }


    // 목록 데이터
    public function getlist($text1)
    {
        return Gubun::where('name', 'like', '%' . $text1 . '%')
            ->orderby('name', 'asc')
            ->paginate(5)
            ->appends(['text1' => $text1]);
    }


    // ★★★ Ajax 저장 함수 (교재 100% 동일)
    public function store(Request $request)
    {
        $row = new Gubun;
        $this->save_row($request, $row);

        // ★ redirect 하지 않고 JSON으로 반환
        return response()->json($row);
    }

public function update(Request $request, $id)
{
    $row = Gubun::find($id);
    $this->save_row($request, $row);
}

    // 공통 저장 로직
    public function save_row(Request $request, $row)
    {
        $request->validate(
            [
                'name' => 'required|max:20'
            ],
            [
                'name.required' => '이름은 필수입력입니다.',
                'name.max'      => '20자 이내입니다.'
            ]
        );

        $row->name = $request->input('name');
        $row->save();
    }


    public function destroy($id)
    {
        Gubun::find($id)->delete();
    }
    


    // QueryString 처리
    public function qstring()
    {
        $text1 = request('text1') ? request('text1') : "";
        $page  = request('page')  ? request('page')  : "1";

        return $text1 ?
            "?text1=$text1&page=$page" :
            "?page=$page";
    }
}
