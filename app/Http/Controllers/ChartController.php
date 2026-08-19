<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Jangbu;
use App\Models\Product;

class ChartController extends Controller
{
    public function index(Request $request)
    {
        $text1 = $request->input('text1');
        if (!$text1) $text1 = date("Y-m-d", strtotime("-1 month"));   // 한달 전

        $text2 = $request->input('text2');
        if (!$text2) $text2 = date("Y-m-d");                          // 오늘 날짜

        $data['text1'] = $text1;
        $data['text2'] = $text2;

        $list = $this->getlist($text1, $text2);
        $data['list'] = $list;

        /* ★★★ 차트에 필요한 문자열 생성 ★★★ */
        $str_label = "";
        $str_data  = "";

        foreach ($list as $row) {
            $str_label .= "'" . $row->gubun_name . "',";   // '음료','과일','과자',...
            $str_data  .= $row->cnumo . ",";               // 12,25,6,...
        }

        $data['str_label'] = $str_label;
        $data['str_data']  = $str_data;

        return view('chart.index', $data);  // ★ chart.index 로 이동
    }


    /* ★★★ 책 ④번 SELECT SQL 수정 그대로 ★★★ */
    public function getlist($text1, $text2)
    {
        $result = Jangbu::leftJoin('products', 'jangbus.products_id', '=', 'products.id')
            ->leftJoin('gubuns', 'products.gubuns_id', '=', 'gubuns.id')
            ->select(
                'gubuns.name as gubun_name',
                DB::raw('count(jangbus.numo) as cnumo')
            )
            ->wherebetween('jangbus.writeday', array($text1, $text2))
            ->where('jangbus.io', '=', 1)
            ->orderby('cnumo', 'desc')
            ->groupBy('gubuns.name')
            ->limit(14)                   // ★ 최대 14색
            ->paginate(14)                // ★ paginate도 14
            ->appends(['text1' => $text1, 'text2' => $text2]);

        return $result;
    }
}
