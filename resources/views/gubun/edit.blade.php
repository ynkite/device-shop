@extends('main')
@section('content')

<!------------------------------------------------------------>
<!-- 시작 : Content -->
<!------------------------------------------------------------>
<br>
<div class="alert mycolor1" role="alert">구분</div>

<form name="form1" method="post" action="{{ route('gubun.update', $row->id) }}{{ $tmp }}">
    @csrf
    @method('PATCH')


    <table class="table table-sm table-bordered mymargin5">
        <tr>
            <td width="20%" class="mycolor2">번호</td>
            <td width="80%" align="left">{{ $row->id }}</td>
        </tr>
        <tr>
            <td width="20%" class="mycolor2"><font color="red">*</font> 이름</td>
            <td width="80%" align="left">
                <div class="d-inline-flex">
                    <input type="text" name="name" size="20" maxlength="20"
                        value="{{ $row->name }}" class="form-control form-control-sm">
                </div>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </td>
        </tr>
    </table>

    <div align="center">
        <input type="submit" value="저장" class="btn btn-sm mycolor1">&nbsp;
        <input type="button" value="이전화면" class="btn btn-sm mycolor1" onClick="history.back();">
    </div>
</form>

<!------------------------------------------------------------>
<!-- 끝 : Content -->
<!------------------------------------------------------------>
@endsection
