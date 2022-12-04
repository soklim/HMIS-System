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
                        <th class="text-center">ល.រ</th>
                        <th class="text-left">នាមត្រកូល/នាមខ្លួន</th>
                        <th class="text-left">ភេទ</th>
                        <th class="text-left">លេខទូរស័ព្ទ</th>
                        <th class="text-left">Email</th>
                        <th class="text-center">Role</th>
{{--                        <th class="text-center">ស្ថានភាព</th>--}}
                        <th class="text-center"></th>
                    </tr>
                    <tbody id="bodyUser"></tbody>
                </table>
            </table>
        </div>
    </div>


    <div class="modal fade" id="frmAddNew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <input type="hidden" id="txtId" value="0" data-required="0">
                                <label>នាមត្រកូល/នាមខ្លួន <span class="text-danger">(*)</span></label>
                                <input type="text" class="form-control" id="txtName" data-required="1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>ភេទ <span class="text-danger">(*)</span></label>
                                <select class="form-select select2" id="txtSex" data-required="1"></select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>លេខទូរស័ព្ទ <span class="text-danger">(*)</span></label>
                                <input type="text" class="form-control" id="txtPhone" data-required="1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>Email <span class="text-danger">(*)</span></label>
                                <input type="email" class="form-control" id="txtEmail" data-required="1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label>Role <span class="text-danger">(*)</span></label>
                                <select class="form-select select2" id="txtRole" data-required="1" onchange="SelectRole(this.value)">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" id="divProvince" style="display: none">
                            <div class="form-group mb-2">
                                <label>មន្ទីរខេត្ត <span class="text-danger">(*)</span></label>
                                <select class="form-select select2" id="txtProvince" data-required="0" onchange="GetDistrict(this.value)"></select>
                            </div>
                        </div>
                        <div class="col-md-4" id="divDistrict" style="display: none">
                            <div class="form-group mb-2">
                                <label>មន្ទីរពេទ្យស្រុក <span class="text-danger">(*)</span></label>
                                <select class="form-select select2" id="txtDistrict" data-required="0" onchange="GetHF(this.value)">
                                    <option value="0">-- select --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" id="divHF" style="display: none">
                            <div class="form-group mb-2">
                                <label>មណ្ឌលសុខភាព <span class="text-danger">(*)</span></label>
                                <select class="form-select select2" id="txtHF" data-required="0">
                                    <option value="0">-- select --</option>
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
        var emailList=[];
        var prevEmail ="";
        $(document).ready(function (){
            $.ajax({
                type:'GET',
                url:"{{ route('users.GetInitPage') }}",
                data:{},
                success:function(result){
                    for(i=0; i<result.email.length; i++){
                        emailList.push(result.email[i].email);
                    }
                    console.log(emailList);
                    var role = result.role;
                    role.unshift({ id: 0, text:'-- select --'});
                    $('#txtRole').select2({data: role, width: '100%', dropdownParent: $("#frmAddNew") });

                    var province = result.province;
                    province.unshift({ id: 0, text:'-- select --'});
                    $('#txtProvince').select2({data: province, width: '100%', dropdownParent: $("#frmAddNew") });

                    var gender = result.gender;
                    gender.unshift({ id: 0, text:'-- select --'});
                    $('#txtSex').select2({data: gender, width: '100%', dropdownParent: $("#frmAddNew") });

                }
            });
            LoadData();
        })

        function SelectRole(role_id){

            if(role_id == 3){
                $("#divProvince").show();
                $("#divDistrict").hide();
                $("#divHF").hide();
            }
            else if(role_id == 4){
                $("#divProvince").show();
                $("#divDistrict").show();
                $("#divHF").hide();
            }
            else if(role_id == 5){
                $("#divProvince").show();
                $("#divDistrict").show();
                $("#divHF").show();
            }
            else{
                $("#divProvince").hide();
                $("#divDistrict").hide();
                $("#divHF").hide();
            }
            $("#txtProvince").val(0).trigger('change');
            $("#txtDistrict").val(0).trigger('change');
            $("#txtHF").val(0).trigger('change');
        }
        function GetDistrict(province_code){
            $.ajax({
                type:'POST',
                url:"{{ route('users.getDistrict') }}",
                data:{
                    pro_code:province_code
                },
                success:function(result){
                    console.log(result);
                    $('#txtDistrict').html("");
                    var district = result.district;
                    district.unshift({ id: 0, text:'-- select --'});
                    $('#txtDistrict').select2({data: district, width: '100%', dropdownParent: $("#frmAddNew") });

                }
            });
        }
        function GetHF(district_code){
            $.ajax({
                type:'POST',
                url:"{{ route('users.getHF') }}",
                data:{
                    district_code:district_code
                },
                success:function(result){
                    console.log(result);
                    $('#txtHF').html("");
                    var HF = result.HF;
                    HF.unshift({ id: 0, text:'-- select --'});
                    $('#txtHF').select2({data: HF, width: '100%', dropdownParent: $("#frmAddNew") });

                }
            });
        }
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
                        var btnEdit ='<span class="text-primary" style="cursor: pointer;font-size: 24px" title="Edit" '+
                            'onclick="actionEdit('+item[i].id+',\''+item[i].name+'\',\''+item[i].email+'\','+item[i].role_id+','+item[i].sex+',\''+item[i].phone+'\','+item[i].province_id+','+item[i].district_id+','+item[i].hf_id+')">'+
                            '<i class="bx bx-edit"></i> </span>';
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
                            '<td class="text-left">'+item[i].sex_name+'</td>'+
                            '<td class="text-left">'+(item[i].phone || "")+'</td>'+
                            '<td class="text-left">'+item[i].email+'</td>'+
                            '<td class="text-center">'+item[i].role_name+'</td>'+
                            // '<td class="text-center">'+btnActive+'</td>'+
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
                $(this).val(0).trigger('change');
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
        function actionEdit(Id,Name,Email,RoleId,sex,phone,province_id, district_id, hf_id){

            $("#txtId").val(Id);
            $("#txtName").val(Name);
            $("#txtEmail").val(Email);
            $("#txtRole").val(RoleId).trigger("change");
            $("#txtSex").val(sex).trigger("change");
            $("#txtPhone").val(phone);
            $("#txtProvince").val(province_id).trigger("change");

            prevEmail = Email;
            if(district_id != 0){
                setTimeout(function () {
                    $("#txtDistrict").val(district_id).trigger("change");
                }, 600);
            }
            if(hf_id != 0){
                setTimeout(function () {
                    $("#txtHF").val(hf_id).trigger("change");
                }, 1200);
            }

            if(district_id != 0 && hf_id != 0) {
                setTimeout(function () {
                    $("#frmAddNew").modal("show");
                    $('#frmAddNew').on('shown.bs.modal', function () {
                        $('#txtName').focus();
                    })
                }, 2000);
            }
            else if(district_id != 0 && hf_id == 0){
                setTimeout(function () {
                    $("#frmAddNew").modal("show");
                    $('#frmAddNew').on('shown.bs.modal', function () {
                        $('#txtName').focus();
                    })
                }, 1200);
            }
            else{
                $("#frmAddNew").modal("show");
                $('#frmAddNew').on('shown.bs.modal', function () {
                    $('#txtName').focus();
                })
            }

        }
        function Save(){
            var Id = $("#txtId").val();
            var Name = $("#txtName").val();
            var Email = $("#txtEmail").val();
            var Role = $("#txtRole").val();
            var Phone = $("#txtPhone").val();
            var Sex = $("#txtSex").val();
            var Province = $("#txtProvince").val();
            var District = $("#txtDistrict").val();
            var HF = $("#txtHF").val();

            const index = emailList.indexOf(prevEmail);
            if (index > -1) { // only splice array when item is found
                emailList.splice(index, 1); // 2nd parameter means remove one item only
            }

            if(Name == ""){
                MSG.Validation("Please input name !!!");
            }
            else if(Sex == 0){
                MSG.Validation("សូមជ្រើសរើស ភេទ !!!");
            }
            else if(Phone == ""){
                MSG.Validation("សូមជ្រើសរើស លេខទូរស័ព្ទ !!!");
            }
            else if(Email == ""){
                MSG.Validation("Please input email !!!");
            }
            else if(Role == 0){
                MSG.Validation("Please select role !!!");
            }
            else if(Role == 3 && Province == 0){
                MSG.Validation("សូមជ្រើសរើស មន្ទីរខេត្ត !!!");
            }
            else if(Role == 4 && Province == 0){
                MSG.Validation("សូមជ្រើសរើស មន្ទីរខេត្ត !!!");
            }
            else if(Role == 4 && District == 0){
                MSG.Validation("សូមជ្រើសរើស មន្ទីរពេទ្យស្រុក !!!");
            }
            else if(Role == 5 && Province == 0){
                MSG.Validation("សូមជ្រើសរើស មន្ទីរខេត្ត !!!");
            }
            else if(Role == 5 && District == 0){
                MSG.Validation("សូមជ្រើសរើស មន្ទីរពេទ្យស្រុក !!!");
            }
            else if(Role == 5 && HF == 0){
                MSG.Validation("សូមជ្រើសរើស មណ្ឌលសុខភាព !!!");
            }
            else if(emailList.includes(Email)){
                MSG.Validation("មិនអាចបញ្ចូលemailដូចគ្នាបានទេ !!!");
            }
            else{
                $.ajax({
                    type:'POST',
                    url:"{{ route('users.Save') }}",
                    data:{
                        id: Id,
                        name: Name,
                        email: Email,
                        role_id: Role,
                        sex: Sex,
                        phone: Phone,
                        province_id: Province,
                        district_id: District,
                        hf_id: HF
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
