@extends('main')
@section('content')

<br>
<div class="alert mycolor1" role="alert">회사 정보</div>

@php
    // 회사종류 변환
    $cokind = $a_cokind[$row->cokind];

    // 전화번호 형식 변환 (010-0000-0000)
    $phone = $row->cotel;
    if (strlen($phone) == 11) {
        $phone = substr($phone, 0, 3) . '-' . substr($phone, 3, 4) . '-' . substr($phone, 7, 4);
    } elseif (strlen($phone) == 10) {
        $phone = substr($phone, 0, 3) . '-' . substr($phone, 3, 3) . '-' . substr($phone, 6, 4);
    }
@endphp

<table class="table table-sm table-bordered mymargin5">
    <tr>
        <td width="20%" class="mycolor2">번호</td>
        <td width="80%" align="left">{{ $row->id }}</td>
    </tr>
    <tr>
        <td width="20%" class="mycolor2">회사명</td>
        <td width="80%" align="left">{{ $row->coname }}</td>
    </tr>
    <tr>
        <td width="20%" class="mycolor2">전화</td>
        <td width="80%" align="left">{{ $phone }}</td>
    </tr>
    <tr>
        <td width="20%" class="mycolor2">창립일</td>
        <td width="80%" align="left">{{ $row->startday }}</td>
    </tr>
    <tr>
        <td width="20%" class="mycolor2">회사종류</td>
        <td width="80%" align="left">{{ $cokind }}</td>
    </tr>
</table>

<div align="center">
    <a href="{{ route('test.edit', $row->id) }}{{ $tmp }}" class="btn btn-sm mycolor1">수정</a>

    <form action="{{ route('test.destroy', $row->id) }}" method="post" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm mycolor1" onclick="return confirm('삭제할까요?');">삭제</button>
    </form>

    <input type="button" value="이전화면" class="btn btn-sm mycolor1" onclick="history.back();">
</div>

@endsection
