@extends('main')
@section('content')

<?php
$tel1 = trim(substr($row->tel, 0, 3));
$tel2 = trim(substr($row->tel, 3, 4));
$tel3 = trim(substr($row->tel, 7, 4));
$tel  = $tel1 . "-" . $tel2 . "-" . $tel3;
$rank = $row->rank == 0 ? '직원' : '관리자';
?>

<br>
<div class="alert mycolor1" role="alert">매출</div>

<form name="form1" method="post" action="">
<table class="table table-sm table-bordered mymargin5">

    <tr>
        <td width="20%" class="mycolor2"><font color="red">*</font> 날짜</td>
        <td width="80%" align="left">{{ $row->writeday }}</td>
    </tr>

    <tr>
        <td width="20%" class="mycolor2"><font color="red">*</font> 제품명</td>
        <td width="80%" align="left">{{ $row->product_name }}</td>
    </tr>

    <tr>
        <td width="20%" class="mycolor2"><font color="red">*</font> 단가</td>
        <td width="80%" align="left">{{ number_format($row->price) }}</td>
    </tr>

    <tr>
        <td width="20%" class="mycolor2"><font color="red">*</font> 수량</td>
        <td width="80%" align="left">{{ number_format($row->numo) }}</td>
    </tr>

    <tr>
        <td width="20%" class="mycolor2">금액</td>
        <td width="80%" align="left">{{ number_format($row->prices) }}</td>
    </tr>

    <tr>
        <td width="20%" class="mycolor2">비고</td>
        <td width="80%" align="left">{{ $row->bigo }}</td>
    </tr>

</table>

<div align="center">
    <a href="{{ route('jangbuo.edit', $row->id) }}{{ $tmp }}" class="btn btn-sm mycolor1">수정</a>

    <form action="{{ route('jangbuo.destroy', $row->id) }}" method="post" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm mycolor1" onClick="return confirm('삭제할까요?');">삭제</button>
    </form>

    &nbsp;
    <input type="button" value="이전화면" class="btn btn-sm mycolor1" onClick="history.back();">
</div>

</form>

@endsection
