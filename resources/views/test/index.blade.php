@extends('main')
@section('content')

<br>
<div class="alert mycolor1" role="alert">회사정보</div>

<script>
function find_text() {
    form1.action = "{{ route('test.index') }}";
    form1.submit();
}
</script>

<form name="form1" action="">
    <div class="row">
        <div class="col-3" align="left">
            <div class="input-group input-group-sm">
                <span class="input-group-text">회사명</span>
                <input type="text" name="text1" value="{{ $text1 }}" class="form-control"
                       onkeydown="if(event.keyCode==13){find_text();}">
                <button class="btn mycolor1" type="button" onClick="find_text();">검색</button>
            </div>
        </div>
        <div class="col-9" align="right">
            <a href="{{ route('test.create') }}{{ $tmp }}" class="btn btn-sm mycolor1">추가</a>
        </div>
    </div>
</form>

<table class="table table-bordered table-sm mymargin5">
    <tr class="mycolor2">
        <td>번호</td>
        <td>회사명</td>
        <td>전화</td>
        <td>창립일</td>
        <td>회사종류</td>
    </tr>

    @foreach($list as $row)
@php
    $cokind = $a_cokind[$row->cokind];

    // 전화번호 형식 010-0000-0000 변환
    $phone = $row->cotel;
    if (strlen($phone) == 11) {
        $phone = substr($phone, 0, 3) . '-' . substr($phone, 3, 4) . '-' . substr($phone, 7, 4);
    } elseif (strlen($phone) == 10) {
        $phone = substr($phone, 0, 3) . '-' . substr($phone, 3, 3) . '-' . substr($phone, 6, 4);
    }
@endphp
<tr>
    <td>{{ $row->id }}</td>
    <td><a href="{{ route('test.show', $row->id) }}{{ $tmp }}">{{ $row->coname }}</a></td>
    <td>{{ $phone }}</td>   <!-- ← 여기 수정 -->
    <td>{{ $row->startday }}</td>
    <td>{{ $cokind }}</td>
</tr>
@endforeach

</table>

<div class="row">
    <div class="col">
        {{ $list->links('mypagination') }}
    </div>
</div>

@endsection
