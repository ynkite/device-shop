<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;    // DB Lib 사용
use App\Models\Product;               // eloquent 사용할 때 필요
use Intervention\Image\Laravel\Facades\Image;                            // ★ 사진에 나온 그대로

class PictureController extends Controller
{
    public function index(Request $request)
    {
        $text1 = request('text1');
        $data['text1'] = $text1;
        $data['list'] = $this->getlist($text1);

        return view('picture.index', $data);
    }

    public function getlist($text1)
    {
        $result = Product::where('name', 'like', '%' . $text1 . '%')
            ->orderby('name', 'asc')
            ->paginate(5)
            ->appends(['text1' => $text1]);

        return $result;
    }

    // ★★★ 사진 속 save_row 함수 구조 그대로 적용
    public function save_row(Request $request, $row)
    {
        $row->gubuns_id = $request->input('gubuns_id');
        $row->name      = $request->input('name');
        $row->price     = $request->input('price');
        $row->jaego     = $request->input('jaego');

        // ★ upload할 파일이 있는 경우 (사진 그대로)
        if ($request->hasFile('pic'))
        {
            $pic      = $request->file('pic');                 // 파일 객체
            $pic_name = $pic->getClientOriginalName();         // 원래 파일명
            $pic->storeAs('public/product_img', $pic_name);    // 파일저장

            // ★★★ 사진 속 코드 그대로
            $img = Image::make($pic)
                ->resize(null, 200, function($constraint) { 
                    $constraint->aspectRatio(); 
                })
                ->save('storage/product_img/thumb/' . $pic_name);

            $row->pic = $pic_name;       // DB 파일명 저장
        }

        $row->save();                    // ★ 사진과 동일
    }
}
