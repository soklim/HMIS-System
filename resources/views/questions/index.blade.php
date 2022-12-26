@extends('layouts.app')
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">System Setting</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Questions</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary" id="btnAdd" onclick="AddNew()"><i class="bx bx-plus"></i>Add</button>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-3">
            <div class="form-group mb-3">
                <label>Section</label>
                <select class="form-select" id="section_filter" onchange="LoadData()">
                    <option value="0">-- select --</option>
                    @foreach($section as $item)
                        <option value="{{$item->id}}">{{$item->description_kh}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                <tr>
                    <th class="text-center">No</th>
{{--                    <th class="text-left">Section</th>--}}
                    <th class="text-left">Question</th>
                    <th class="text-left">Question KH</th>
                    <th class="text-center">Answer Type</th>
                    <th class="text-center">Setting Type</th>
                    <th class="text-center">Order Number</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody id="bodyItem"></tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="frmAddNew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Question</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <input type="hidden" id="id" value="0" data-required="0">
                                <label>Section <span class="text-danger">(*)</span></label>
                                <select class="form-select" id="section_id">
                                    <option value="0">-- select --</option>
                                    @foreach($section as $item)
                                        <option value="{{$item->id}}">{{$item->description_kh}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Question</label>
                                <input type="text" class="form-control" id="question" data-required="1">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Question KH</label>
                                <input type="text" class="form-control" id="question_kh" data-required="1">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Answer Type<span class="text-danger">(*)</span></label>
                                <select class="form-select" id="answer_type">
                                    <option value="0">-- select --</option>
                                    @foreach($answer_type as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Setting Type</label>
                                <select class="form-select" id="setting_type_id">
                                    <option value="0">-- select --</option>
                                    @foreach($setting_type as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Order No <span class="text-danger">(*)</span></label>
                                <input type="number" class="form-control" id="order_no" data-required="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="Save()"><i class="bx bxs-save"></i> Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bx bx-x"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function (){
            LoadData();
        })
        function AddNew(){
            clearForm();
            $("#frmAddNew").modal("show");
            $('#frmAddNew').on('shown.bs.modal', function () {
                $('#question').focus();
            })
        }
        function LoadData(){
            $("#bodyItem").html("");
            $.ajax({
                type:'GET',
                url:"{{ route('questions.GetData') }}",
                data:{
                    section_id:$("#section_filter").val()
                },
                success:function(data){
                    // console.log(data);
                    var item =data;
                    for (var i = 0; i < item.length; i++) {
                        var btnEdit ='<span class="text-primary" style="cursor: pointer;font-size: 24px" title="Edit" ' +
                            'onclick="actionEdit('+item[i].id+',\''+item[i].question+'\',\''+item[i].question_kh+'\','+item[i].section_id+','+item[i].setting_type_id+','+item[i].order_no+','+item[i].answer_type+')"><i class="bx bx-edit"></i> </span>';

                        $("#bodyItem").append('<tr>'+
                            '<td class="text-center">'+(i+1)+'</td>'+
                            // '<td class="text-left">'+item[i].section_name+'</td>'+
                            '<td class="text-left">'+(item[i].question || "")+'</td>'+
                            '<td class="text-left">'+(item[i].question_kh || "")+'</td>'+
                            '<td class="text-center">'+item[i].answer_type_name+'</td>'+
                            '<td class="text-center">'+(item[i].setting_type_name || "")+'</td>'+
                            '<td class="text-center">'+item[i].order_no+'</td>'+
                            '<td class="text-center">'+btnEdit+'</td>'+
                            '</tr>');
                    }
                }
            });
        }
        function clearForm(){
            $('#frmAddNew input').each(function(){
                $(this).val('');
            });
            $('#frmAddNew select').each(function(){
                $(this).val(0);
            });
            $("#id").val(0);
        }

        function actionEdit(Id,question,question_kh,section_id,setting_type_id,order_no,answer_type){
            clearForm();
            $("#id").val(Id);
            $("#question").val(question);
            $("#question_kh").val(question_kh);
            $("#section_id").val(section_id);
            $("#answer_type").val(answer_type);
            $("#setting_type_id").val(setting_type_id);
            $("#order_no").val(order_no);
            $("#frmAddNew").modal("show");
            $('#frmAddNew').on('shown.bs.modal', function () {
                $('#question').focus();
            })
        }
        function Save(){
            var id = $("#id").val();
            var question = $("#question").val();
            var question_kh = $("#question_kh").val();
            var section_id = $("#section_id").val();
            var setting_type_id = $("#setting_type_id").val();
            var order_no = $("#order_no").val();
            var answer_type = $("#answer_type").val();
            if(section_id == 0){
                MSG.Validation("Please select section !!!");
            }
            else if(order_no == ""){
                MSG.Validation("Please input order number !!!");
            }
            else if(answer_type == 2 && setting_type_id == 0){
                MSG.Validation("Please select setting type !!!");
            }
            else{
                $.ajax({
                    type:'POST',
                    url:"{{ route('questions.Save') }}",
                    data:{
                        id: id,
                        question: question,
                        question_kh: question_kh,
                        section_id: section_id,
                        answer_type: answer_type,
                        setting_type_id: setting_type_id,
                        order_no: order_no
                    },
                    success:function(result){
                        // console.log(result);
                        if(result.code == 0){
                            MSG.Success();
                            $("#frmAddNew").modal('hide');
                            LoadData();
                        }
                    }
                });
            }
        }

    </script>
@endsection
