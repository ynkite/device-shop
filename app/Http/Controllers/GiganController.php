<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Jangbu;

// ★★★ 책 그대로 추가 (vendor autoload + PhpSpreadsheet)
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class GiganController extends Controller
{
    public function index(Request $request)
    {
        $text1 = $request->input('text1');
        if (!$text1) $text1 = date("Y-m-01", strtotime("-1 month"));

        $text2 = $request->input('text2');
        if (!$text2) $text2 = date("Y-m-d");

        $text3 = $request->input('text3');
        if (!$text3) $text3 = 0;

        $data['text1'] = $text1;
        $data['text2'] = $text2;
        $data['text3'] = $text3;

        $data['list'] = $this->getlist($text1, $text2, $text3);
        $data['list_product'] = $this->getlist_product();

        return view('gigan.index', $data);
    }

    public function getlist($text1, $text2, $text3)
    {
        if ($text3 == 0)
        {
            $result = Jangbu::leftJoin('products', 'jangbus.products_id', '=', 'products.id')
                ->select('jangbus.*', 'products.name as product_name')
                ->wherebetween('jangbus.writeday', array($text1, $text2))
                ->orderby('jangbus.id', 'desc')
                ->paginate(5)
                ->appends(['text1'=>$text1, 'text2'=>$text2, 'text3'=>$text3]);
        }
        else
        {
            $result = Jangbu::leftJoin('products', 'jangbus.products_id', '=', 'products.id')
                ->select('jangbus.*', 'products.name as product_name')
                ->wherebetween('jangbus.writeday', array($text1, $text2))
                ->where('jangbus.products_id', '=', $text3)
                ->orderby('jangbus.id', 'desc')
                ->paginate(5)
                ->appends(['text1'=>$text1, 'text2'=>$text2, 'text3'=>$text3]);
        }

        return $result;
    }

    public function getlist_product()
    {
        return Product::orderby('name')->get();
    }

    // ★★★ STEP 02 – 책에 있는 getlist_all 함수 그대로 추가
    public function getlist_all($text1, $text2, $text3)
    {
        if ($text3 == 0)   // 제품이 전체인 경우
        {
            $result = Jangbu::leftJoin('products', 'jangbus.products_id', '=', 'products.id')
                ->select('jangbus.*', 'products.name as products_name')
                ->wherebetween('jangbus.writeday', array($text1, $text2))
                ->orderby('jangbus.id', 'desc')
                ->get();
        }
        else
        {
            $result = Jangbu::leftJoin('products', 'jangbus.products_id', '=', 'products.id')
                ->select('jangbus.*', 'products.name as products_name')
                ->wherebetween('jangbus.writeday', array($text1, $text2))
                ->where('jangbus.products_id', '=', $text3)
                ->orderby('jangbus.id', 'desc')
                ->get();
        }

        return $result;
    }

    // ★★★ STEP 03~06 – excel() 함수 전체 (책 내용 그대로)
    public function excel()
    {
        $text1 = request('text1');
        $text2 = request('text2');
        $text3 = request('text3');

        $list = $this->getlist_all($text1, $text2, $text3);

        $sheet = new Spreadsheet();

        // 각 열의 너비, 정렬
        $sheet->getActiveSheet()->getColumnDimension("A")->setWidth(12);
        $sheet->getActiveSheet()->getColumnDimension("B")->setWidth(25);
        $sheet->getActiveSheet()->getColumnDimension("C")->setWidth(12);
        $sheet->getActiveSheet()->getColumnDimension("D")->setWidth(12);
        $sheet->getActiveSheet()->getColumnDimension("E")->setWidth(12);
        $sheet->getActiveSheet()->getColumnDimension("F")->setWidth(12);
        $sheet->getActiveSheet()->getColumnDimension("G")->setWidth(12);

        $sheet->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal("center");
        $sheet->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal("left");
        $sheet->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal("right");
        $sheet->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal("right");
        $sheet->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal("right");
        $sheet->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal("right");
        $sheet->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal("left");

        // 제목 (글자크기, 굵게)
        $sheet->setActiveSheetIndex(0)->setCellValue("A1", "매출입장");
        $sheet->getActiveSheet()->getStyle("A1")->getFont()->setSize(13);
        $sheet->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);

        // 기간 표시
        $sheet->setActiveSheetIndex(0)->setCellValue("G1", "기간: $text1 - $text2");
        $sheet->getActiveSheet()->getStyle("G1")->getAlignment()->setHorizontal("right");

        // 헤더 정렬, 배경색
        $sheet->getActiveSheet()->getStyle("A2:G2")->getAlignment()->setHorizontal("center");
        $sheet->getActiveSheet()->getStyle("A2:G2")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB("FFCCCCCC");

        $sheet->setActiveSheetIndex(0)
            ->setCellValue("A2","날짜")
            ->setCellValue("B2","제품명")
            ->setCellValue("C2","단가")
            ->setCellValue("D2","수량")
            ->setCellValue("E2","매출액")
            ->setCellValue("F2","매입수량")
            ->setCellValue("G2","비고");

        $i = 3;
        foreach ( $list as $row )
        {
            $sheet->setActiveSheetIndex(0)
                ->setCellValue("A$i", $row->writeday)
                ->setCellValue("B$i", $row->products_name)
                ->setCellValue("C$i", $row->price ? $row->price : "")
                ->setCellValue("D$i", $row->num1 ? $row->num1 : "")
                ->setCellValue("E$i", $row->prices ? $row->prices : "")
                ->setCellValue("F$i", $row->numo ? $row->numo : "")
                ->setCellValue("G$i", $row->bigo);

            $i++;
        }

        $sheet->setActiveSheetIndex(0);

        // 파일 생성
        $fname="매출입장($text1 - $text2).xlsx";
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=$fname");
        header("Cache-Control: max-age=0");

        $writer = IOFactory::createWriter($sheet, "Xlsx");
        $writer->save("php://output");
    }
}
