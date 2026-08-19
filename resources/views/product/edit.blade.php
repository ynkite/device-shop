@extends('main')
@section('content')

<br>
<div class="alert mycolor1" role="alert">제품 수정</div>

<form name="form1" method="post" action="{{ route('product.update', $row->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <table class="table table-sm table-bordered mymargin5">
        <tr>
            <td width="20%" class="mycolor2">번호</td>
            <td width="80%" align="left">{{ $row->id }}</td>
        </tr>

        <tr>
            <td width="20%" class="mycolor2"><font color="red">*</font> 구분명</td>
            <td width="80%" align="left">
                <div class="d-inline-flex">
                    <select name="gubuns_id" class="form-select form-select-sm">
                        <option value="">선택하세요.</option>
                        @foreach ($list as $row1)
                            @if ($row->gubuns_id == $row1->id)
                                <option value="{{ $row1->id }}" selected>{{ $row1->name }}</option>
                            @else
                                <option value="{{ $row1->id }}">{{ $row1->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                @error('gubuns_id') {{ $message }} @enderror
            </td>
        </tr>

        <tr>
            <td width="20%" class="mycolor2"><font color="red">*</font> 제품명</td>
            <td width="80%" align="left">
                <div class="d-inline-flex">
                    <input type="text" name="name" size="20" value="{{ $row->name }}"
                        class="form-control form-control-sm">
                </div>
                @error('name') {{ $message }} @enderror
            </td>
        </tr>

        <tr>
            <td width="20%" class="mycolor2"><font color="red">*</font> 단가</td>
            <td width="80%" align="left">
                <div class="d-inline-flex">
                    <input type="text" name="price" size="20" value="{{ $row->price }}"
                        class="form-control form-control-sm">
                </div>
                @error('price') {{ $message }} @enderror
            </td>
        </tr>

        <tr>
            <td width="20%" class="mycolor2">재고</td>
            <td width="80%" align="left">
                <div class="d-inline-flex">
                    <input type="text" name="jaego" size="20" value="{{ $row->jaego }}"
                        class="form-control form-control-sm">
                </div>
            </td>
        </tr>

        <tr>
            <td width="20%" class="mycolor2">사진</td>
            <td width="80%" align="left">
                <div class="d-inline-flex">
                    <input type="file" name="pic" size="20" class="form-control form-control-sm">
                </div>
                @if ($row->pic)
                    <br>
                    <img src="{{ asset('storage/product_img/' . $row->pic) }}" width="200" height="150" class="img-fluid img-thumbnail mymargin5">
                @endif
            </td>
        </tr>
    </table>

    <div align="center">
        <button type="submit" class="btn btn-sm mycolor1">수정</button>
        <a href="{{ route('product.index') }}" class="btn btn-sm mycolor2">이전</a>
    </div>
</form>

@endsection
