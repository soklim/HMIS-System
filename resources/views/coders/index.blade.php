@extends('layouts.app')
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{$module[0]->group_module_name}}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{$module[0]->module_name}}</li>
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
        <div class="col-md-12">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Name KH</th>
                    <th class="text-center">Desc</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody id="tbody_"></tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="frmAddNew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$module[0]->module_name}}</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <input type="hidden" id="txtId" value="0" data-required="0">
                                <label>Name <span class="text-danger">(*)</span></label>
                                <input type="text" class="form-control" id="txtName" data-required="1">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Name KH <span class="text-danger">(*)</span></label>
                                <input type="text" class="form-control" id="txtNameKH" data-required="1">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Desc</label>
                                <input type="text" class="form-control" id="txtDesc" data-required="1">
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
        function LoadData(){
            $("#tbody_").html("");
            $.ajax({
                type:'GET',
                url:"{{ route('coders.GetData') }}",
                data:{},
                success:function(data){
                    // console.log(data);
                    var item =data;
                    for (var i = 0; i < item.length; i++) {
                        var btnEdit ='<span class="text-primary" style="cursor: pointer;font-size: 24px" title="Edit" onclick="actionEdit('+item[i].id+',\''+item[i].name+'\',\''+item[i].name_kh+'\',\''+(item[i].description || "")+'\')"><i class="bx bx-edit"></i> </span>';
                        var btnDelete ='<span class="text-danger" style="cursor: pointer;font-size: 24px" title="Delete" onclick="actionDelete('+item[i].id+')"><i class="bx bx-trash"></i></span>';

                        $("#tbody_").append('<tr>'+
                            '<td class="text-center">'+(i+1)+'</td>'+
                            '<td class="text-left">'+item[i].name+'</td>'+
                            '<td class="text-center">'+item[i].name_kh+'</td>'+
                            '<td class="text-center">'+(item[i].description || "")+'</td>'+
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
            $("#txtId").val(0);
        }
        function AddNew(){
            clearForm();
            $("#frmAddNew").modal("show");
            $('#frmAddNew').on('shown.bs.modal', function () {
                $('#txtName').focus();
            })
        }
        function actionEdit(Id,Name,NameKH,Desc){
            clearForm();
            $("#txtId").val(Id);
            $("#txtName").val(Name);
            $("#txtNameKH").val(NameKH);
            $("#txtDesc").val(Desc);
            $("#frmAddNew").modal("show");
            $('#frmAddNew').on('shown.bs.modal', function () {
                $('#txtName').focus();
            })
        }
        function Save(){
            var Id = $("#txtId").val();
            var Name = $("#txtName").val();
            var NameKH = $("#txtNameKH").val();
            var Desc = $("#txtDesc").val();
            if(Name == ""){
                MSG.Validation("Please input name !!!");
            }
            else if(NameKH == ""){
                MSG.Validation("Please input name kh !!!");
            }
            else{
                $.ajax({
                    type:'POST',
                    url:"{{ route('coders.Save') }}",
                    data:{
                        id: Id,
                        name: Name,
                        name_kh: NameKH,
                        description: Desc
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
