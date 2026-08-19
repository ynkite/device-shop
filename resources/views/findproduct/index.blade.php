@extends('main_nomenu')
@section('content')

<br>
<div class="alert mycolor1" role="alert">제품선택</div>

<script>
    function find_text()
    {
        form1.action = "{{ route('findproduct.index') }}";
        form1.submit();
    }

    // 부모창으로 값 보내기
    function SendProduct(id, name, price)
    {
        opener.form1.products_id.value = id;
        opener.form1.product_name.value = name;
        opener.form1.price.value = price;

        // 금액 자동계산 (단가 * 수량)
        opener.form1.prices.value = Number(price) * Number(opener.form1.numo.value);

        self.close();
    }
</script>

<!-- 검색창 -->
<form name="form1" method="get" action="">
    <div class="row">
        <div class="col-6" align="left">
            <div class="input-group input-group-sm">
                <span class="input-group-text">이름</span>

                <input type="text" name="text1" value="{{ $text1 }}"
                       class="form-control"
                       onkeydown="if (event.keyCode == 13) { find_text(); }">

                <button class="btn btn-sm mycolor1" type="button"
                        onclick="find_text();">
                    검색
                </button>
            </div>
        </div>

        <div class="col-6" align="right"></div>
    </div>
</form>


<!-- 리스트 -->
<table class="table table-bordered table-sm mymargin5">
    <tr class="mycolor2">
        <td width="10%">번호</td>
        <td width="20%">구분명</td>
        <td width="30%">제품명</td>
        <td width="20%">단가</td>
        <td width="20%">재고</td>
    </tr>

    @foreach($list as $row)
    <tr>
        <td>{{ $row->id }}</td>
        <td>{{ $row->gubun_name }}</td>

        <td>
            <a href="javascript:SendProduct({{ $row->id }}, '{{ $row->name }}', {{ $row->price }});">
                {{ $row->name }}
            </a>
        </td>

        <td>{{ $row->price }}</td>
        <td>{{ $row->jaego }}</td>
    </tr>
    @endforeach
</table>

<!-- 페이지네이션 -->
<div class="row">
    <div class="col">
        {{ $list->links('mypagination') }}
    </div>
</div>

@endsection
