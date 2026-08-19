@extends('main')
@section('content')

<br>
<div class="alert mycolor1" role="alert">종류별 분포도</div>

<script>


    function find_text()
    {
        form1.action = "{{ route('chart.index') }}";
        form1.submit();
    }

    $(function() {
        $('#text1').datetimepicker({
            locale: 'ko',
            format: 'YYYY-MM-DD',
            defaultDate: moment()
        });

        $('#text2').datetimepicker({
            locale: 'ko',
            format: 'YYYY-MM-DD',
            defaultDate: moment()
        });

        $("#text1").on("dp.change", function(e){ find_text(); });
        $("#text2").on("dp.change", function(e){ find_text(); });
    });
</script>

<form name="form1" action="">
    <div class="row">
        <div class="col-12" align="left">

            {{-- 날짜1 --}}
            <div class="d-inline-flex">
                <div class="input-group input-group-sm date" id="text1">
                    <span class="input-group-text">날짜1</span>
                    <input type="text" name="text1" size="10"
                        value="{{ $text1 }}"
                        class="form-control"
                        onkeydown="if(event.keyCode==13){ find_text(); }">
                    <span class="input-group-text">
                        <div class="input-group-addon">
                            <i class="far fa-calendar-alt fa-lg"></i>
                        </div>
                    </span>
                </div>
            </div>

            {{-- 날짜2 --}}
            <div class="d-inline-flex">
                <div class="input-group input-group-sm date" id="text2">
                    <span class="input-group-text">날짜2</span>
                    <input type="text" name="text2" size="10"
                        value="{{ $text2 }}"
                        class="form-control"
                        onkeydown="if(event.keyCode==13){ find_text(); }">
                    <span class="input-group-text">
                        <div class="input-group-addon">
                            <i class="far fa-calendar-alt fa-lg"></i>
                        </div>
                    </span>
                </div>
            </div>

        </div>
    </div>
</form>

<br>

{{-- chart.js --}}
<script src="{{ asset('my/js/chart.min.js') }}"></script>

<div style="width:40%">
    <canvas id="myChart"></canvas>
</div>

<script>

    const ctx = document.getElementById('myChart');
    const myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [{!! $str_label !!}],
            datasets: [{
                data: [{!! $str_data !!}],
                backgroundColor: [
                    "rgba(255, 99, 132, 0.8)",
                    "rgba(255, 159, 64, 0.8)",
                    "rgba(255, 205, 86, 0.8)",
                    "rgba(75, 192, 192, 0.8)",
                    "rgba(153, 102, 255, 0.8)",
                    "rgba(201, 203, 207, 0.8)",
                    "rgba(54, 162, 235, 0.8)",

                    "rgba(255, 99, 132, 0.5)",
                    "rgba(255, 159, 64, 0.5)",
                    "rgba(255, 205, 86, 0.5)",
                    "rgba(75, 192, 192, 0.5)",
                    "rgba(153, 102, 255, 0.5)",
                    "rgba(201, 203, 207, 0.5)",
                    "rgba(54, 162, 235, 0.5)"
                ]
            }]
        },
        options: {}   // ★ VSCode 오류 제거용 옵션 추가 (중요)
    });
</script>


@endsection
