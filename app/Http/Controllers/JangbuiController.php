<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   // DB 클래스
use App\Models\Product;              // 제품 모델
use App\Models\Jangbu;               // 장부 모델 추가

class JangbuiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['tmp'] = $this->qstring();

        $text1 = request('text1');
        if (!$text1) $text1 = date("Y-m-d");

        $data['text1'] = $text1;
        $data['list'] = $this->getlist($text1);

        return view('jangbui.index', $data);     // ★ 수정 (jangbu → jangbui)
    }

    /**
     * getlist 함수
     */
    public function getlist($text1)
    {
        $result = Jangbu::leftJoin('products', 'jangbus.products_id', '=', 'products.id')
            ->select('jangbus.*', 'products.name as product_name')
            ->where('jangbus.io', '=', 0)
            ->where('jangbus.writeday', '=', $text1)
            ->orderby('jangbus.id', 'desc')
            ->paginate(5)
            ->appends(['text1' => $text1]);

        return $result;
    }

    /**
     * create 함수
     */
    public function create()
    {
        $data['tmp'] = $this->qstring();
        $data['list'] = $this->getlist_product();

        return view('jangbui.create', $data);    // 이미 올바름
    }

    public function getlist_product()
    {
        return Product::orderby('name')->get();
    }

    /**
     * store 함수
     */
    public function store(Request $request)
    {
        $row = new Jangbu;
        $this->save_row($request, $row);

        $tmp = $this->qstring();
        return redirect('jangbui' . $tmp);
    }

    public function save_row(Request $request, $row)
    {
        $request->validate([
            'writeday'      => 'required|date',
            'products_id'   => 'required'
        ], [
            'writeday.required'     => '날짜는 필수입력입니다.',
            'products_id.required'  => '제품명은 필수입력입니다.',
            'writeday.date'         => '날짜형식이 잘못되었습니다.'
        ]);

        $row->io        = 0;
        $row->writeday  = $request->input('writeday');
        $row->products_id = $request->input('products_id');
        $row->price     = $request->input('price');
        $row->numi      = $request->input('numi');
        $row->numo      = 0;
        $row->prices    = $request->input('prices');
        $row->bigo      = $request->input('bigo');

        $row->save();
    }

    public function show($id)
    {
        $data['tmp'] = $this->qstring();

        $data['row'] = Jangbu::leftjoin('products', 'jangbus.products_id', '=', 'products.id')
            ->select('jangbus.*', 'products.name as product_name')
            ->where('jangbus.id', '=', $id)
            ->first();

        return view('jangbui.show', $data);
    }


    public function edit($id)
    {
        $data['list'] = $this->getlist_product();   // ★ 사진 그대로 추가

        $data['tmp'] = $this->qstring();
        $data['row'] = Jangbu::find($id);

        return view('jangbui.edit', $data);         // ★ 사진 그대로
    }

    public function update(Request $request, $id)
    {
        $row = Jangbu::find($id);
        $this->save_row($request, $row);

        $tmp = $this->qstring();
        return redirect('jangbui' . $tmp);       // 이미 정상
    }

    public function destroy($id)
    {
        Jangbu::find($id)->delete();

        $tmp = $this->qstring();
        return redirect('jangbui' . $tmp);       // 이미 정상
    }

    public function qstring()
    {
        $text1 = request('text1') ? request('text1') : "";
        $page  = request('page')  ? request('page')  : "1";

        $tmp = $text1 ? "?text1=$text1&page=$page" : "?page=$page";
        return $tmp;
    }
}
