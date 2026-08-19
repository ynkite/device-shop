<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Jangbu;

class BestController extends Controller
{
    public function index(Request $request)
    {
        $text1 = $request->input('text1');
        if (!$text1) $text1 = date("Y-m-01", strtotime("-1 month"));

        $text2 = $request->input('text2');
        if (!$text2) $text2 = date("Y-m-d");

        $data['text1'] = $text1;
        $data['text2'] = $text2;

        // ★ text3 제거, 제품선택 콤보박스 삭제
        // ★ getlist 호출도 ($text1, $text2)만 전달
        $data['list'] = $this->getlist($text1, $text2);

        return view('best.index', $data);
    }

    // ★ 교재 내용 그대로 BEST 상품 SQL 적용
    public function getlist($text1, $text2)
    {
        $result = Jangbu::leftJoin('products', 'jangbus.products_id', '=', 'products.id')
            ->select('products.name as products_name',
                     DB::raw('count(jangbus.numo) as cnumo'))
            ->wherebetween('jangbus.writeday', array($text1, $text2))
            ->where('jangbus.io', '=', 1)
            ->groupBy('products.id', 'products.name')   // ★★ 핵심: 그룹바이 추가
            ->orderby('cnumo', 'desc')
            ->orderby('products.name')
            ->paginate(5)
            ->appends(['text1' => $text1, 'text2' => $text2]);
    
        return $result;
    }
    
}
