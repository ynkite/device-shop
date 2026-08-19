<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;

class TestController extends Controller
{
    public function index()
    {
        $data['tmp'] = $this->qstring();
        $text1 = request('text1');
        $data['text1'] = $text1;
        $data['list'] = $this->getlist($text1);

        $data['a_cokind'] = array("신탁", "대기업", "중소기업", "벤처", "개인");
        return view('test.index', $data);
    }

    public function getlist($text1)
    {
        $result = Test::where('coname', 'like', '%' . $text1 . '%')
                      ->orderBy('coname', 'asc')
                      ->paginate(5)
                      ->appends(['text1' => $text1]);
        return $result;
    }

    public function create()
    {
        $data['tmp'] = $this->qstring();
        $data['a_cokind'] = array("신탁", "대기업", "중소기업", "벤처", "개인");
        return view('test.create', $data);
    }

    public function store(Request $request)
    {
        $row = new Test;
        $this->save_row($request, $row);
        $tmp = $this->qstring();
        return redirect('test' . $tmp);
    }

    public function show($id)
    {
        $data['tmp'] = $this->qstring();
        $data['row'] = Test::find($id);
        $data['a_cokind'] = array("신탁", "대기업", "중소기업", "벤처", "개인");
        return view('test.show', $data);
    }

    public function edit($id)
    {
        $data['tmp'] = $this->qstring();
        $data['row'] = Test::find($id);
        $data['a_cokind'] = array("신탁", "대기업", "중소기업", "벤처", "개인");
        return view('test.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $row = Test::find($id);
        $this->save_row($request, $row);
        $tmp = $this->qstring();
        return redirect('test' . $tmp);
    }

    public function destroy($id)
    {
        Test::find($id)->delete();
        $tmp = $this->qstring();
        return redirect('test' . $tmp);
    }

    private function save_row(Request $request, Test $row)
    {
        $request->validate([
            'coname'   => 'required|max:20',
            'startday' => 'required|date',
            'cokind'   => 'required|integer',
        ]);
    
        // 전화번호 3칸 합치기
        $tel1 = $request->input('tel1');
        $tel2 = $request->input('tel2');
        $tel3 = $request->input('tel3');
        $cotel = $tel1 . $tel2 . $tel3;
    
        $row->coname   = $request->input('coname');
        $row->cotel    = $cotel;
        $row->startday = $request->input('startday');
        $row->cokind   = $request->input('cokind');
        $row->save();
    }

    public function qstring()
    {
        $text1 = request('text1') ? request('text1') : "";
        $page  = request('page')  ? request('page')  : "1";

        $tmp = $text1 ? "?text1=$text1&page=$page" : "?page=$page";

        return $tmp;
    }
}
