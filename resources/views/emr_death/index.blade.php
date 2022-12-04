@extends('layouts.app')
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Transactions</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Death Notification</li>
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
            <table class="table-responsive">
                <table class="table table-striped table-bordered table-sm" id="tblUser">
                    <tr>
                        <th class="text-center">ល.រ</th>
                        <th class="text-left">មូលដ្ឋានសុខាភិបាល</th>
                        <th class="text-center">លេខឯកសារពេទ្យ</th>
                        <th class="text-left">ឈ្មោះអ្នកស្លាប់</th>
                        <th class="text-center">ភេទ</th>
                        <th class="text-center">ស្ថានភាព</th>
                        <th class="text-center">អាយុ</th>
                        <th class="text-center">កាលបរិច្ឆេទស្លាប់</th>
                        <th class="text-center"></th>
                    </tr>
                    <tbody id="bodyDeath"></tbody>
                </table>
            </table>
        </div>
    </div>


    <div class="modal fade" id="frmAddNew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Death Notification</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="death_id" value="0" data-required="0">
                            <h6 style="font-weight: bold;text-decoration: underline">ព័ត៌មានមរណៈភាព</h6>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label>ករណីស្លាប់ <span class="text-danger">(*)</span></label>
                                        <select class="form-select select2" id="death_type" data-required="1"></select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label>ទីតាំងស្លាប់ <span class="text-danger">(*)</span></label>
                                        <select class="form-select select2" id="death_info" data-required="1"></select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label>លេខកូដមូលដ្ឋានសុខាភិបាល(HMIS) <span class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control" id="hmis_code" data-required="1">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label>អត្តលេខឯកសារពេទ្យ <span class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control" id="medical_file_id" data-required="1">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label>ថ្ងៃខែឆ្នាំ-មរណភាព <span class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control datefield" id="date_of_death" data-required="1" placeholder="ថ្ងៃ-ខែ-ឆ្នាំ">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label>ម៉ោង-មរណភាព <span class="text-danger">(*)</span></label>
                                        <input type="text" class="form-control timefield" id="time_of_death" data-required="1" placeholder="ម៉ោង-នាទីំ">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h6 style="font-weight: bold;text-decoration: underline">ទីតាំងមូលដ្ឋានសុខាភិបាល</h6>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <label>ឈ្មោះមូលដ្ឋានសុខាភិបាល</label>
                                    <input type="text" class="form-control" id="hf_name" value="{{$hf_name}}" data-required="0" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label>រាជធានី-ខេត្ត <span class="text-danger">(*)</span></label>
                                    <select class="form-select select2" id="death_province_code" data-required="0" onchange="GetDistrict(this.value)"></select>
                                </div>
                                <div class="col-md-3">
                                    <label>ក្រុង/ស្រុក/ខណ្ឌ <span class="text-danger">(*)</span></label>
                                    <select class="form-select select2" id="death_district_code" data-required="0" onchange="GetCommune(this.value)">
                                        <option value="0">-- select --</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>ឃុំ/សង្កាត់ <span class="text-danger">(*)</span></label>
                                    <select class="form-select select2" id="death_commune_code" data-required="0">
                                        <option value="0">-- select --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-top: 20px;">
                            <h6 style="font-weight: bold;text-decoration: underline">ព័ត៌មានអ្នកស្លាប់</h6>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>ឈ្មោះ <span class="text-danger">(*)</span></label>
                                    <input type="text" id="deceased_name" class="form-control"/>
                                </div>
                                <div class="col-md-4">
                                    <label>ថ្ងៃខែឆ្នាំកំណើត <span class="text-danger">(*)</span></label>
                                    <input type="text" id="date_of_birth" class="form-control datefield" placeholder="ថ្ងៃ-ខែ-ឆ្នាំ" />
                                </div>
                                <div class="col-md-2">
                                    <label>ភេទ <span class="text-danger">(*)</span></label>
                                    <select class="form-select select2" id="sex" data-required="0"></select>
                                </div>
                                <div class="col-md-2">
                                    <label>ស្ថានភាពគ្រួសារ <span class="text-danger">(*)</span></label>
                                    <select class="form-select select2" id="married_status" data-required="0"></select>
                                </div>
                            </div>
                            <div class="row" style="padding-top: 10px;">
                                <div class="col-md-4">
                                    <label>រាជធានី-ខេត្ត <span class="text-danger">(*)</span></label>
                                    <select class="form-select select2" id="deceased_province_code" data-required="0" onchange="GetDistrict_Deceased(this.value)"></select>
                                </div>
                                <div class="col-md-4">
                                    <label>ក្រុង/ស្រុក/ខណ្ឌ</label>
                                    <select class="form-select select2" id="deceased_district_code" data-required="0" onchange="GetCommune_Deceased(this.value)">
                                        <option value="0">-- select --</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>ឃុំ/សង្កាត់</label>
                                    <select class="form-select select2" id="deceased_commune_code" data-required="0" onchange="GetVillage_Deceased(this.value)">
                                        <option value="0">-- select --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="padding-top: 10px;">
                                <div class="col-md-4">
                                    <label>ភូមិ</label>
                                    <select class="form-select select2" id="deceased_village" data-required="0">
                                        <option value="0">-- select --</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>លេខផ្លូវ</label>
                                    <input type="text" class="form-control" id="deceased_street">
                                </div>
                                <div class="col-md-4">
                                    <label>លេខផ្ទះ</label>
                                    <input type="text" class="form-control" id="deceased_house">
                                </div>
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
            $(".datefield").pickadate({
                selectMonths: true,
                selectYears: true,
                format: 'yyyy-mm-dd',
                hiddenName: true
            });

            $('.timefield').bootstrapMaterialDatePicker({
                date: false,
                format: 'HH:mm'
            });

            $.ajax({
                type:'GET',
                url:"{{ route('emr_death.GetInitPage') }}",
                data:{},
                success:function(result){

                    var province = result.province;
                    province.unshift({ id: 0, text:'-- select --'});
                    $('#death_province_code').select2({data: province, width: '100%', dropdownParent: $("#frmAddNew") });
                    $('#deceased_province_code').select2({data: province, width: '100%', dropdownParent: $("#frmAddNew") });

                    var gender = result.gender;
                    gender.unshift({ id: 0, text:'-- select --'});
                    $('#sex').select2({data: gender, width: '100%', dropdownParent: $("#frmAddNew") });

                    var death_info = result.death_info;
                    death_info.unshift({ id: 0, text:'-- select --'});
                    $('#death_info').select2({data: death_info, width: '100%', dropdownParent: $("#frmAddNew") });

                    var death_type = result.death_type;
                    death_type.unshift({ id: 0, text:'-- select --'});
                    $('#death_type').select2({data: death_type, width: '100%', dropdownParent: $("#frmAddNew") });

                    var married_status = result.married_status;
                    married_status.unshift({ id: 0, text:'-- select --'});
                    $('#married_status').select2({data: married_status, width: '100%', dropdownParent: $("#frmAddNew") });

                }
            });
            LoadData();
        })
        function GetDistrict(PCode){
            $.ajax({
                type:'POST',
                url:"{{ route('emr_death.getDistrict') }}",
                data:{
                    PCode:PCode
                },
                success:function(result){
                    console.log(result);
                    $('#death_district_code').html("");
                    var district = result.district;
                    district.unshift({ id: 0, text:'-- select --'});
                    $('#death_district_code').select2({data: district, width: '100%', dropdownParent: $("#frmAddNew") });

                }
            });
        }
        function GetCommune(DCode){
            $.ajax({
                type:'POST',
                url:"{{ route('emr_death.getCommune') }}",
                data:{
                    DCode:DCode
                },
                success:function(result){
                    console.log(result);
                    $('#death_commune_code').html("");
                    var commune = result.commune;
                    commune.unshift({ id: 0, text:'-- select --'});
                    $('#death_commune_code').select2({data: commune, width: '100%', dropdownParent: $("#frmAddNew") });

                }
            });
        }
        function GetDistrict_Deceased(PCode){
            $.ajax({
                type:'POST',
                url:"{{ route('emr_death.getDistrict') }}",
                data:{
                    PCode:PCode
                },
                success:function(result){
                    console.log(result);
                    $('#deceased_district_code').html("");
                    var district = result.district;
                    district.unshift({ id: 0, text:'-- select --'});
                    $('#deceased_district_code').select2({data: district, width: '100%', dropdownParent: $("#frmAddNew") });

                }
            });
        }
        function GetCommune_Deceased(DCode){
            $.ajax({
                type:'POST',
                url:"{{ route('emr_death.getCommune') }}",
                data:{
                    DCode:DCode
                },
                success:function(result){
                    console.log(result);
                    $('#deceased_commune_code').html("");
                    var commune = result.commune;
                    commune.unshift({ id: 0, text:'-- select --'});
                    $('#deceased_commune_code').select2({data: commune, width: '100%', dropdownParent: $("#frmAddNew") });

                }
            });
        }
        function GetVillage_Deceased(CCode){
            $.ajax({
                type:'POST',
                url:"{{ route('emr_death.getVillage') }}",
                data:{
                    CCode:CCode
                },
                success:function(result){
                    console.log(result);
                    $('#deceased_village').html("");
                    var village = result.village;
                    village.unshift({ id: 0, text:'-- select --'});
                    $('#deceased_village').select2({data: village, width: '100%', dropdownParent: $("#frmAddNew") });

                }
            });
        }
        function LoadData(){
            $("#bodyUser").html("");
            $.ajax({
                type:'GET',
                url:"{{ route('emr_death.GetData') }}",
                data:{},
                success:function(data){
                    console.log(data);
                    var item =data;
                    for (var i = 0; i < item.length; i++) {
                        var btnPrint ='<a href="/emr_death_print" class="text-info" target="_blank" style="font-size:24px"><i class="bx bx-printer"></i></a>';
                        $("#bodyDeath").append('<tr>'+
                            '<td class="text-center">'+item[i].issue_no+'</td>'+
                            '<td class="text-left">'+item[i].hfac_label+'</td>'+
                            '<td class="text-center">'+item[i].medical_file_id+'</td>'+
                            '<td class="text-left">'+(item[i].deceased_name  || "")+'</td>'+
                            '<td class="text-center">'+(item[i].sex || "")+'</td>'+
                            '<td class="text-center">'+(item[i].married_status || "")+'</td>'+
                            '<td class="text-center">'+(item[i].age || "")+'</td>'+
                            '<td class="text-center">'+(item[i].date_of_death || "")+' | '+(item[i].time_of_death || "")+'</td>'+
                            '<td class="text-center">'+btnPrint+'</td>'+
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
            $("#death_id").val(0);
            $("#hf_name").val("{{$hf_name}}");

        }
        function AddNew(){
            clearForm();
            $("#frmAddNew").modal("show");
            $('#frmAddNew').on('shown.bs.modal', function () {
                $('#medical_file_id').focus();
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
            var death_id = $("#death_id").val();
            var death_type = $("#death_type").val();
            var death_info = $("#death_info").val();
            var hmis_code = $("#hmis_code").val();
            var medical_file_id = $("#medical_file_id").val();
            var date_of_death = $("#date_of_death").val();
            var time_of_death = $("#time_of_death").val();
            var death_province_code = $("#death_province_code").val();
            var death_district_code = $("#death_district_code").val();
            var death_commune_code = $("#death_commune_code").val();
            var deceased_name = $("#deceased_name").val();
            var date_of_birth = $("#date_of_birth").val();
            var sex = $("#sex").val();
            var married_status = $("#married_status").val();
            var deceased_province_code = $("#deceased_province_code").val();
            var deceased_district_code = $("#deceased_district_code").val();
            var deceased_commune_code = $("#deceased_commune_code").val();
            var deceased_village = $("#deceased_village").val();
            var deceased_street = $("#deceased_street").val();
            var deceased_house = $("#deceased_house").val();

            if(death_type == 0){
                MSG.Validation("សូមបញ្ចូល ករណីស្លាប់ !!!");
            }
            else if(death_info == 0){
                MSG.Validation("សូមបញ្ចូល ទីតាំងស្លាប់ !!!");
            }
            else if(hmis_code == ""){
                MSG.Validation("សូមបញ្ចូល លេខកូដមូលដ្ឋានសុខាភិបាល !!!");
            }
            else if(medical_file_id == ""){
                MSG.Validation("សូមបញ្ចូល អត្តលេខឯកសារពេទ្ !!!");
            }
            else if(date_of_death == ""){
                MSG.Validation("សូមបញ្ចូល ថ្ងៃខែឆ្នាំ-មរណភាព !!!");
            }
            else if(time_of_death == ""){
                MSG.Validation("សូមបញ្ចូល ម៉ោង-មរណភាព !!!");
            }
            else if(death_province_code == 0){
                MSG.Validation("សូមបញ្ចូល រាជធានី-ខេត្ត !!!");
            }
            else if(death_district_code == 0){
                MSG.Validation("សូមបញ្ចូល ក្រុង/ស្រុក/ខណ្ឌ !!!");
            }
            else if(death_commune_code == 0){
                MSG.Validation("សូមបញ្ចូល ឃុំ/សង្កាត់ !!!");
            }
            else if(deceased_name == ""){
                MSG.Validation("សូមបញ្ចូល ឈ្មោះអ្នកស្លាប់ !!!");
            }
            else if(date_of_death == ""){
                MSG.Validation("សូមបញ្ចូល ថ្ងៃខែឆ្នាំកំណើត !!!");
            }
            else if(sex == ""){
                MSG.Validation("សូមបញ្ចូល ភេទ !!!");
            }
            else if(married_status == ""){
                MSG.Validation("សូមបញ្ចូល ស្ថានភាពគ្រួសារ !!!");
            }
            else if(deceased_province_code == ""){
                MSG.Validation("សូមបញ្ចូល អាសយដ្ឋានអ្នកស្លាប់(រាជធានី-ខេត្ត) !!!");
            }
            else{
                var hf_id ="{{$hf_id}}";
                var hf_label ="{{$hf_label}}";
                $.ajax({
                    type:'POST',
                    url:"{{ route('emr_death.Save') }}",
                    data:{
                        death_id:death_id,
                        hfac_code: hf_id,
                        hfac_label: hf_label,
                        death_type:death_type,
                        death_info:death_info,
                        hmis_code:hmis_code,
                        medical_file_id:medical_file_id,
                        date_of_death:date_of_death,
                        time_of_death:time_of_death,
                        death_province_code:death_province_code,
                        death_district_code:death_district_code,
                        death_commune_code:death_commune_code,
                        deceased_name:deceased_name,
                        date_of_birth:date_of_birth,
                        sex:sex,
                        married_status:married_status,
                        deceased_province_code:deceased_province_code,
                        deceased_district_code:deceased_district_code,
                        deceased_commune_code:deceased_commune_code,
                        deceased_village:deceased_village,
                        deceased_street:deceased_street,
                        deceased_house:deceased_house,
                    },
                    success:function(result){
                        // console.log(result);
                        if(result.code == 0){
                            MSG.Success();
                            $("#frmAddNew").modal('hide');
                            // LoadData();
                        }
                    }
                });
            }
        }

    </script>
@endsection
