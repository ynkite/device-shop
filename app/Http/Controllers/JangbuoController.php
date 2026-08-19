<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   // DB 클래스
use App\Models\Product;              // 제품 모델
use App\Models\Jangbu;               // 장부 모델 추가

class JangbuoController extends Controller
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

        return view('jangbuo.index', $data);     // ★ 수정 (jangbu → jangbuo)
    }

    /**
     * getlist 함수
     */
    public function getlist($text1)
    {
        $result = Jangbu::leftJoin('products', 'jangbus.products_id', '=', 'products.id')
            ->select('jangbus.*', 'products.name as product_name')
            ->where('jangbus.io', '=', 1)          // ★ 매출조건 (io=1)
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

        return view('jangbuo.create', $data);    // 이미 올바름
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
        return redirect('jangbuo' . $tmp);
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

        $row->io        = 1;                               // ★ 매출
        $row->writeday  = $request->input('writeday');
        $row->products_id = $request->input('products_id');
        $row->price     = $request->input('price');
        $row->numi      = 0;                               // ★ 매출은 numi = 0
        $row->numo      = $request->input('numo');         // ★ 매출은 numo 사용
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

        return view('jangbuo.show', $data);
    }


    public function edit($id)
    {
        $data['list'] = $this->getlist_product();   // ★ 사진 그대로 추가

        $data['tmp'] = $this->qstring();
        $data['row'] = Jangbu::find($id);

        return view('jangbuo.edit', $data);         // ★ 사진 그대로
    }

    public function update(Request $request, $id)
    {
        $row = Jangbu::find($id);
        $this->save_row($request, $row);

        $tmp = $this->qstring();
        return redirect('jangbuo' . $tmp);       // 이미 정상
    }

    public function destroy($id)
    {
        Jangbu::find($id)->delete();

        $tmp = $this->qstring();
        return redirect('jangbuo' . $tmp);       // 이미 정상
    }

    public function qstring()
    {
        $text1 = request('text1') ? request('text1') : "";
        $page  = request('page')  ? request('page')  : "1";

        $tmp = $text1 ? "?text1=$text1&page=$page" : "?page=$page";
        return $tmp;
    }
}
