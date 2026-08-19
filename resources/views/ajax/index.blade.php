@extends('main')
@section('content')

<meta name="_token" content="{{ csrf_token() }}">

<br>
<div class="alert mycolor1" role="alert">Ajax 구분</div>

<script>
    function find_text() {
        form1.action = "{{ route('ajax.index') }}";
        form1.submit();
    }
</script>

<form name="form1" method="get" action="">
    <div class="row">
        <div class="col-3" align="left">
            <div class="input-group input-group-sm">
                <span class="input-group-text">이름</span>
                <input type="text" name="text1" value="{{ $text1 }}"
                    class="form-control"
                    onkeydown="if (event.keyCode==13) find_text();">
                <button class="btn mycolor1" type="button" onclick="find_text();">검색</button>
            </div>
        </div>

        <div class="col-9" align="right">
            <a href="#ajaxModal" id="ajax_add"
                class="btn btn-sm mycolor1"
                data-bs-toggle="modal"
                data-bs-target="#ajaxModal">추가</a>
        </div>
    </div>
</form>

<br>

<table class="table table-bordered table-sm table-hover mymargin5" id="table_list">
    <tr class="mycolor2">
        <td width="10%">번호</td>
        <td width="80%">구분명</td>
        <td width="10%">삭제</td>
    </tr>

    @foreach($list as $row)
        <tr id="rowno{{ $row->id }}">
            <td>{{ $row->id }}</td>

            <!-- ★ 수정 모달을 열기 위한 A TAG 추가 -->
            <td>
                <a href="#ajaxModal"
                   data-bs-toggle="modal"
                   data-bs-target="#ajaxModal"
                   class="ajax_edit"
                   data-id="{{ $row->id }}"
                   data-name="{{ $row->name }}">
                    {{ $row->name }}
                </a>
            </td>

            <td>
                <a href="#"
                   rowno="{{ $row->id }}"
                   class="ajax_del btn btn-sm mycolor1">삭제</a>
            </td>
        </tr>
    @endforeach
</table>

{{ $list->links('mypagination') }}



<!-- Modal -->
<div class="modal fade" id="ajaxModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header mycolor1">
                <h5 class="modal-title modal-title">구분 추가</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body bg-light">
                <form name="form2" method="post">
                    @csrf

                    <!-- ★ kind hidden field -->
                    <input type="hidden" id="kind" value="add">

                    <table class="table table-sm table-borderless mymargin5">
                        <tr>
                            <td width="30%">번호</td>
                            <td>
                                <input type="text" name="id" id="data_id"
                                       class="form-control form-control-sm" disabled>
                            </td>
                        </tr>

                        <tr>
                            <td>구분명</td>
                            <td>
                                <input type="text" name="name" id="data_name"
                                       class="form-control form-control-sm">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>

            <div class="modal-footer alert-secondary">
                <button type="button" id="ajax_save"
                    class="btn btn-sm btn-secondary"
                    data-bs-dismiss="modal">저장</button>

                <button type="button" class="btn btn-sm btn-light" 
                    data-bs-dismiss="modal">닫기</button>
            </div>

        </div>
    </div>
</div>


<!-- Ajax -->
<script>

    // ● 추가 버튼 : kind = add
    $(document).on("click", "#ajax_add", function () {
        $("#kind").val("add");
        $(".modal-title").text("구분 추가");

        $("#data_id").val("");
        $("#data_name").val("");
    });


    // ● 수정 버튼 : kind = edit
    $(document).on("click", ".ajax_edit", function () {
        $("#kind").val("edit");
        $(".modal-title").text("구분 수정");

        $("#data_id").val($(this).data("id"));
        $("#data_name").val($(this).data("name"));
    });


    // ● 저장버튼 → add 또는 edit
    $(function () {
        $("#ajax_save").click(function () {

            var kind = $("#kind").val();
            var id   = $("#data_id").val();
            var name = $("#data_name").val();

            // ★ 추가 (POST)
            if (kind == "add") {

                $.ajax({
                    headers: { "X-CSRF-TOKEN": $("meta[name='_token']").attr("content") },
                    url: "ajax",
                    type: "POST",
                    data: { name: name },

                    success: function (data) {
                        var id = data.id;

                        $("#table_list").append(
                            "<tr id='rowno" + id + "'>" +
                                "<td>" + id + "</td>" +
                                "<td><a href='#ajaxModal' data-bs-toggle='modal' data-bs-target='#ajaxModal' " +
                                     "class='ajax_edit' data-id='" + id + "' data-name='" + name + "'>" +
                                     name + "</a></td>" +
                                "<td><a href='#' rowno='" + id + "' class='ajax_del btn btn-sm mycolor1'>삭제</a></td>" +
                            "</tr>"
                        );
                    }
                });

            }
            else {  
                // ★ 수정(PATCH)
                $.ajax({
                    headers: { "X-CSRF-TOKEN": $("meta[name='_token']").attr("content") },
                    url: "ajax/" + id,
                    type: "POST",
                    data: {
                        _method: "PATCH",
                        name: name
                    },

                    success: function () {
                        $("#rowno" + id).replaceWith(
                            "<tr id='rowno" + id + "'>" +
                                "<td>" + id + "</td>" +
                                "<td><a href='#ajaxModal' data-bs-toggle='modal' data-bs-target='#ajaxModal' " +
                                     "class='ajax_edit' data-id='" + id + "' data-name='" + name + "'>" +
                                     name + "</a></td>" +
                                "<td><a href='#' rowno='" + id + "' class='ajax_del btn btn-sm mycolor1'>삭제</a></td>" +
                            "</tr>"
                        );
                    }
                });
            }
        });
    });


    // ● 삭제
    $("#table_list").on("click", ".ajax_del", function () {

        if (confirm("삭제할까요?")) {

            var id = $(this).attr("rowno");

            $.ajax({
                headers: { "X-CSRF-TOKEN": $("meta[name='_token']").attr("content") },
                url: "ajax/" + id,
                type: "POST",
                data: { _method: "DELETE" },

                success: function () {
                    $("#rowno" + id).remove();
                }
            });

        }
    });

</script>

@endsection
