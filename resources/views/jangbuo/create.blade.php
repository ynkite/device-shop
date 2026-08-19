@extends('main')
@section('content')

<br>
<div class="alert mycolor1" role="alert">매출</div>

<script>
    $(function() {
        $("#writeday").datetimepicker({
            locale: "ko",
            format: "YYYY-MM-DD",
            defaultDate: moment()
        });
    });

function cal_prices()
{
    form1.prices.value = Number(form1.price.value) * Number(form1.numo.value);
    form1.bigo.focus();
}

// ★★★ 교재 STEP04 : 제품찾기 팝업 함수 추가 ★★★
function find_product()
{
    window.open("{{ route('findproduct.index') }}","",
        "resizable=yes,scrollbars=yes,width=500,height=600");
}

// ★ 팝업 → 부모창 callback
function product_callback(products_id, product_name, price)
{
    form1.products_id.value = products_id;
    form1.product_name.value = product_name;
    form1.price.value = price;
    form1.prices.value = Number(form1.price.value) * Number(form1.numo.value);
}
</script>


<form name="form1" method="post" action="{{ route('jangbuo.store') }}">
@csrf

<table class="table table-sm table-bordered mymargin5">

<!-- 날짜 -->
<tr>
    <td width="20%" class="mycolor2"><font color="red">*</font> 날짜</td>
    <td width="80%" align="left">
        <div class="d-inline-flex">
            <div class="input-group input-group-sm date" id="writeday">
                <input type="text" name="writeday" size="10"
                       value="{{ old('writeday') }}"
                       class="form-control form-control-sm">

                <div class="input-group-text">
                    <div class="input-group-addon">
                        <i class="far fa-calendar-alt fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        @error('writeday') {{ $message }} @enderror
    </td>
</tr>


<!-- ★★★ 제품명 (교재 사진과 완전히 동일하게 수정) ★★★ -->
<tr>
    <td width="20%" class="mycolor2"><font color="red">*</font> 제품명</td>
    <td width="80%" align="left">
        <div class="d-inline-flex">

            <input type="hidden" name="products_id" value="{{ old('products_id') }}">

            <input type="text" name="product_name"
                   value="{{ old('product_name') }}"
                   class="form-control form-control-sm" readonly>&nbsp;

            <input type="button" value="제품찾기"
                   onClick="find_product();"
                   class="btn btn-sm mycolor1">

        </div>
        @error('products_id') {{ $message }} @enderror
    </td>
</tr>


<!-- 단가 -->
<tr>
    <td width="20%" class="mycolor2">단가</td>
    <td width="80%" align="left">
        <div class="d-inline-flex">
            <input type="text" name="price" size="20" value="{{ old('price') }}"
                   class="form-control form-control-sm"
                   onChange="cal_prices();">
        </div>
    </td>
</tr>

<!-- 수량 -->
<tr>
    <td width="20%" class="mycolor2">수량</td>
    <td width="80%" align="left">
        <div class="d-inline-flex">
            <input type="text" name="numo" size="20" value="{{ old('numo') }}"
                   class="form-control form-control-sm"
                   onChange="cal_prices();">
        </div>
    </td>
</tr>

<!-- 금액 -->
<tr>
    <td width="20%" class="mycolor2">금액</td>
    <td width="80%" align="left">
        <div class="d-inline-flex">
            <input type="text" name="prices" size="20"
                   value="{{ old('prices') }}"
                   class="form-control form-control-sm" readonly>
        </div>
    </td>
</tr>

<!-- 비고 -->
<tr>
    <td width="20%" class="mycolor2">비고</td>
    <td width="80%" align="left">
        <div class="d-inline-flex">
            <input type="text" name="bigo" size="20"
                   value="{{ old('bigo') }}"
                   class="form-control form-control-sm">
        </div>
    </td>
</tr>

</table>

<div align="center">
    <input type="submit" value="저장" class="btn btn-sm mycolor1">
    <input type="button" value="이전화면" class="btn btn-sm mycolor1" onClick="history.back();">
</div>

</form>

@endsection
