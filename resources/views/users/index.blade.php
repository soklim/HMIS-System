@extends('layouts.app')
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">List</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
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

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <table class="table-responsive">
                <table class="table table-striped table-bordered table-sm" id="tblUser">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-left">Name</th>
                        <th class="text-left">Email</th>
                        <th class="text-center">Role</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    <tbody id="bodyUser"></tbody>
                </table>
            </table>
        </div>
    </div>


    <div class="modal fade" id="frmAddNew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User</h5>
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
                                <label>Email <span class="text-danger">(*)</span></label>
                                <input type="email" class="form-control" id="txtEmail" data-required="1">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Role <span class="text-danger">(*)</span></label>
                                <select class="form-select select2" id="txtRole" data-required="1">
                                </select>
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
            $.ajax({
                type:'GET',
                url:"{{ route('users.GetInitPage') }}",
                data:{},
                success:function(result){
                    // console.log(result);
                    var role = result.role;
                    role.unshift({ id: 0, text:'-- select --'});
                    $('#txtRole').select2({data: role, width: '100%', dropdownParent: $("#frmAddNew") });

                }
            });
            LoadData();
        })
        function LoadData(){
            $("#bodyUser").html("");
            $.ajax({
                type:'GET',
                url:"{{ route('users.GetData') }}",
                data:{},
                success:function(data){
                    // console.log(data);
                    var item =data;
                    for (var i = 0; i < item.length; i++) {
                        var btnEdit ='<span class="text-primary" style="cursor: pointer;font-size: 24px" title="Edit" onclick="actionEdit('+item[i].id+',\''+item[i].name+'\',\''+item[i].email+'\','+item[i].role_id+')"><i class="bx bx-edit"></i> </span>';
                        var btnReset ='<span class="text-success" style="cursor: pointer;font-size: 24px" title="Reset" onclick="actionReset('+item[i].id+')"><i class="bx bx-reset"></i></span>';
                        var btnActive ="";
                        if(item[i].active == 1){
                            btnActive='<div class="form-switch">'+
                                '<input class="form-check-input" type="checkbox" id="chb0' + item[i].id + '" onclick="UpdateStatus('+item[i].id+')" checked=""'+
                            'div>';
                        }
                        else{
                            btnActive='<div class="form-switch">'+
                                '<input class="form-check-input" type="checkbox" id="chb0' + item[i].id + '" onclick="UpdateStatus('+item[i].id+')">'+
                                '</div>';
                        }
                        $("#bodyUser").append('<tr>'+
                            '<td class="text-center">'+(i+1)+'</td>'+
                            '<td class="text-left">'+item[i].name+'</td>'+
                            '<td class="text-left">'+item[i].email+'</td>'+
                            '<td class="text-center">'+item[i].role_name+'</td>'+
                            '<td class="text-center">'+btnActive+'</td>'+
                            '<td class="text-center">'+btnEdit+btnReset+'</td>'+
                        '</tr>');
                    }
                }
            });
        }
        function clearForm(){
            $('#frmAddNew input').each(function(){
                $(this).val('');
                $(this).removeClass('highlight');
            });
            $('#frmAddNew select').each(function(){
                $(this).siblings(".select2-container").css('border', "none");
                $(this).css('border', "1px solid #ccc");
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
        function actionEdit(Id,Name,Email,RoleId){

            $("#txtId").val(Id);
            $("#txtName").val(Name);
            $("#txtEmail").val(Email);
            $("#txtRole").val(RoleId).trigger("change");
            $("#frmAddNew").modal("show");
            $('#frmAddNew').on('shown.bs.modal', function () {
                $('#txtName').focus();
            })
        }
        function Save(){
            var Id = $("#txtId").val();
            var Name = $("#txtName").val();
            var Email = $("#txtEmail").val();
            var Role = $("#txtRole").val();
            if(Name == ""){
                MSG.Validation("Please input name !!!");
            }
            else if(Email == ""){
                MSG.Validation("Please input email !!!");
            }
            else if(Role == 0){
                MSG.Validation("Please select role !!!");
            }
            else{
                $.ajax({
                    type:'POST',
                    url:"{{ route('users.Save') }}",
                    data:{
                        id: Id,
                        name: Name,
                        email: Email,
                        role_id: Role
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
        function UpdateStatus(id) {
            var _log_status = 1;
            if ($("#chb0" + id + "").is(':checked')) {
                _log_status = 1;
            }
            else {
                _log_status = 0;
            }
            $.ajax({
                async: false,
                dataType: "json",
                type: "POST",
                url:"/UserUpdateActive",
                data: {
                    id: id,
                    active: _log_status
                },
                success: function (result) {
                    MSG.Success();
                },
                error: function (e) {
                    MSG.Validation(e.message);
                }
            });
        }
        function actionReset(id){
            $.ajax({
                async: false,
                dataType: "json",
                type: "POST",
                url:"/ResetPassword",
                data: {
                    id: id,
                    password: "123"
                },
                success: function (result) {
                    MSG.Success();
                },
                error: function (e) {
                    MSG.Validation(e.message);
                }
            });
        }
    </script>
@endsection
