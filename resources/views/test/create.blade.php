@extends('main')
@section('content')

<br>
<div class="alert mycolor1" role="alert">회사 추가</div>

<form name="form1" method="post" action="{{ route('test.store') }}{{ $tmp }}">
@csrf
<table class="table table-sm table-bordered mymargin5">
<tr>
            <td width="20%" class="mycolor2">번호</td>
            <td width="80%" align="left"></td>
        </tr>
    <tr><td class="mycolor2">회사명</td>
        <td><input type="text" name="coname" value="{{ old('coname') }}" class="form-control form-control-sm"></td>
    </tr>
    <tr>
            <td width="20%" class="mycolor2">전화</td>
            <td width="80%" align="left">
                <div class="d-inline-flex">
                    <input type="text" name="tel1" size="3" maxlength="3"
                        value="{{ old('tel1') }}" class="form-control form-control-sm"> -
                    <input type="text" name="tel2" size="4" maxlength="4"
                        value="{{ old('tel2') }}" class="form-control form-control-sm"> -
                    <input type="text" name="tel3" size="4" maxlength="4"
                        value="{{ old('tel3') }}" class="form-control form-control-sm">
                </div>
            </td>
        </tr>
    <tr><td class="mycolor2">창립일</td>
        <td><input type="date" name="startday" value="{{ old('startday') }}" class="form-control form-control-sm"></td>
    </tr>
    <tr><td class="mycolor2">회사종류</td>
        <td>
            <select name="cokind" class="form-select form-select-sm">
                @for($i=0; $i<$n=count($a_cokind); $i++)
                    <option value="{{ $i }}">{{ $a_cokind[$i] }}</option>
                @endfor
            </select>
        </td>
    </tr>
</table>
<div align="center">
    <input type="submit" value="저장" class="btn btn-sm mycolor1">
    <input type="button" value="이전화면" class="btn btn-sm mycolor1" onclick="history.back();">
</div>
</form>
@endsection
