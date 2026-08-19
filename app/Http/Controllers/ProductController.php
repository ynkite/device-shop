<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;

use App\Models\Gubun;
use Intervention\Image\Laravel\Facades\Image;




class ProductController extends Controller
{
   public function jaego()
{
    DB::statement('drop table if exists temps;');
    DB::statement('create table temps (
        id int not null auto_increment,
        products_id int,
        jaego int default 0,
        primary key(id)
    );');
    
    DB::statement('update products set jaego=0;');
    DB::statement('insert into temps (products_id, jaego)
        select products_id, sum(numi)-sum(numo)
        from jangbus
        group by products_id;');
    DB::statement('update products join temps
        on products.id=temps.products_id
        set products.jaego=temps.jaego;');

    return redirect('product');
}




    public function getlist_gubun()
{
    $result = Gubun::orderby('name')->get();
    return $result;
}


    public function index()
    {
        $data['tmp'] = $this->qstring();

        $text1 =request('text1');
        $data['text1'] = $text1;
        $data['list'] =$this->getlist($text1);

        return view('product.index',$data);
    }

    

    public function getlist($text1)
    {
        $result = Product::leftJoin('gubuns', 'products.gubuns_id', '=', 'gubuns.id')
    ->select('products.*', 'gubuns.name as gubun_name')
    ->where('products.name', 'like', '%' . $text1 . '%')
    ->orderBy('products.name', 'asc')
    ->paginate(5)
    ->appends(['text1' => $text1]);


        return $result;
    }

    
    public function create()
    {
        $data['list'] = $this->getlist_gubun();


        $data['tmp'] = $this->qstring();
        return view('product.create',$data);
    }

   
    public function store(Request $request)
    {


        $row =  new Product;
        $this->save_row($request,$row);
    
        $tmp = $this->qstring();
        return redirect('product'.$tmp);
    }

    
    public function show($id)
    {
        $data['tmp'] = $this->qstring();
        $data['row'] = Product::leftJoin('gubuns', 'products.gubuns_id', '=', 'gubuns.id')
    ->select('products.*', 'gubuns.name as gubun_name')
    ->where('products.id', '=', $id)
    ->first();

        return view('product.show',$data);
    }

   
    public function edit($id)
    {
        $data['list']=$this->getlist_gubun();
        $data['tmp'] = $this->qstring();

        $data['row'] = Product::find($id);
        return view('product.edit',$data);
    }

   
    public function update(Request $request, $id)
    {
        $row = Product::find($id);
        $this->save_row($request,$row);
    
        $tmp = $this->qstring();
        return redirect('product'. $tmp);
    }

   
    public function destroy($id)
    {
       Product::find($id)->delete();

       $tmp = $this->qstring();
       return redirect('product'.$tmp);
    }

    public function save_row(Request $request, $row)
    {
        $request->validate([
            'gubuns_id' => 'required|numeric',
            'name'      => 'required|max:50',
            'price'     => 'required|numeric',
        ], [
            'gubuns_id.required' => '구분은 필수입력입니다.',
            'name.required'      => '이름은 필수입력입니다.',
            'price.required'     => '단가는 필수입력입니다.',
            'name.max'           => '50자 이내입니다.',
        ]);
    
        $row->gubuns_id = $request->input('gubuns_id');
        $row->name      = $request->input('name');
        $row->price     = $request->input('price');
        $row->jaego     = $request->input('jaego');
    
        if ($request->hasFile('pic')) {
            $pic = $request->file('pic');
            $pic_name = $pic->getClientOriginalName();
    
            // 1) 원본 저장
            $pic->storeAs('product_img', $pic_name, 'public');
    
            // 2) Intervention Image 3.x — 실제 경로 읽기
            $img = Image::read(
                storage_path('app/public/product_img/' . $pic_name)
            )
            ->resize(null, 200, function($constraint) {
                $constraint->aspectRatio();
            })
            ->save(
                public_path('storage/product_img/thumb/' . $pic_name)
            );
    
            // DB 저장
            $row->pic = $pic_name;
        }
    
        $row->save();
    }
    
    public function qstring()
    {
        $text1 = request("text1") ? request('text1') : "";
        $page = request('page') ? request('page') : "1";

        $tmp = $text1 ? "?text1=$text1&page=$page" : "?page=$page";

        return $tmp;
    }

}
