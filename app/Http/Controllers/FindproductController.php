<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;       // DB LIB 사용
use App\Models\Product;                 // Eloquent 모델
use App\Models\Gubun;                   // 구분명 모델

class FindproductController extends Controller
{
    /**
     * index 함수
     */
    public function index(Request $request)
    {
        $text1 = $request->input('text1');     // 검색어
        $data['text1'] = $text1;
        $data['list'] = $this->getlist($text1);

        return view('findproduct.index', $data);
    }

    /**
     * getlist : 제품명 + 구분명 join 조회
     */
    public function getlist($text1)
    {
        $result = Product::leftJoin('gubuns', 'products.gubuns_id', '=', 'gubuns.id')
            ->select('products.*', 'gubuns.name as gubun_name')
            ->where('products.name', 'like', '%' . $text1 . '%')
            ->orderby('products.name', 'asc')
            ->paginate(5)
            ->appends(['text1' => $text1]);

        return $result;
    }
}
