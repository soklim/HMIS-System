@extends('layouts.app')
@section('content')
    <style>
        .medical_file_id{
            padding-left: 0px;
            padding-right: 0px;
            text-align: center;
        }
    </style>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{$module[0]->group_module_name}}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{$module[0]->module_name}} (បន្ថែមថ្មី)</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" id="death_id" value="0" data-required="0">
            <h6 style="font-weight: bold;text-decoration: underline">ព័ត៌មានមរណៈភាព</h6>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>រាជធានី-ខេត្ត <span class="text-danger">(*)</span></label>
                        <select class="form-select select2" id="txtHF_Province" data-required="0" onchange="GetOD(this.value)">
                            <option value="0">-- select --</option>
                            @foreach($province as $pro)
                                <option value="{{$pro->PROCODE}}">{{$pro->PROVINCE_KH}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>ក្រុង/ស្រុក/ខណ្ឌ <span class="text-danger">(*)</span></label>
                        <select class="form-select select2" id="txtHF_District" data-required="0" onchange="GetHF(this.value)">
                            <option value="0">-- select --</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>មូលដ្ឋានសុខាភិបាល <span class="text-danger">(*)</span></label>
                        <select class="form-select select2" id="hf_code" data-required="0">
                            <option value="0">-- select --</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3" style="border: solid 1px black;border-radius: 10px;padding-top:10px;padding-left:10px">
                        <label>ករណីស្លាប់ <span class="text-danger">(*)</span></label>
                        <div id="div_death_type">
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group mb-3" style="border: solid 1px black;border-radius: 10px;padding-top:10px;padding-left:10px">
                        <label>ព័ត៌មានមរណភាព <span class="text-danger">(*)</span></label>
                        <div id="div_death_info">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <h6 style="font-weight: bold;text-decoration: underline">ព័ត៌មានអ្នកស្លាប់</h6>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <label>ឈ្មោះមរណៈជន <span class="text-danger">(*)</span></label>
                    <input type="text" id="deceased_name" class="form-control"/>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>អត្តលេខឯកសារពេទ្យ <span class="text-danger">(*)</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                        </div>

                    </div>
                </div>
                <div class="col-md-2">
                    <label>ភេទ <span class="text-danger">(*)</span></label>
                    <div id="div_sex">

                    </div>
                </div>
                <div class="col-md-2">
                    <label>ស្ថានភាពគ្រួសារ <span class="text-danger">(*)</span></label>
                    <div id="div_married_status">

                    </div>
                </div>
            </div>
            <div class="row" style="padding-top: 10px;">
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label><input type="checkbox" id="txtCheckAge" onchange="isBaby(this.checked)"/> អាយុ</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input age_type" disabled id="age_1" checked type="radio" name="age_type">
                            <label class="form-check-label" for="age_1">ឆ្នាំ</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input age_type" disabled id="age_2" type="radio" name="age_type">
                            <label class="form-check-label" for="age_2">ខែ</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input age_type" disabled id="age_3" type="radio" name="age_type">
                            <label class="form-check-label" for="age_3">ថ្ងៃ</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input age_type" disabled id="age_4" type="radio" name="age_type">
                            <label class="form-check-label" for="age_4">ម៉ោង</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input age_type" disabled id="age_5" type="radio" name="age_type">
                            <label class="form-check-label" for="age_5">នាទី</label>
                        </div>
                        <input type="text" class="form-control" id="age_year" data-required="1" readonly>
                        <input type="number" class="form-control" id="age_day" data-required="1" style="display: none">
                    </div>
                </div>
                <div class="col-md-3">
                    <label>ថ្ងៃខែឆ្នាំកំណើត <span class="text-danger">(*)</span></label>
                    <input type="text" id="date_of_birth" class="form-control datefield" onchange="getAge()" placeholder="YYYY-MM-DD" />
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label>ថ្ងៃខែឆ្នាំ-មរណភាព <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control datefield" id="date_of_death" onchange="getAge()" data-required="1" placeholder="YYYY-MM-DD">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label>ម៉ោង-មរណភាព <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control timefield" id="time_of_death" data-required="1" placeholder="MM:HH">
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-12">
            <h6 style="font-weight: bold;text-decoration: underline">ទីលំនៅប្រក្រតីរបស់អ្នកស្លាប់</h6>
            <hr>
            <div class="row">
                <div class="col-md-2">
                    <label>រាជធានី-ខេត្ត <span class="text-danger">(*)</span></label>
                    <select class="form-select select2" id="deceased_province_code" data-required="0" onchange="GetDistrict_Deceased(this.value)"></select>
                </div>
                <div class="col-md-2">
                    <label>ក្រុង/ស្រុក/ខណ្ឌ</label>
                    <select class="form-select select2" id="deceased_district_code" data-required="0" onchange="GetCommune_Deceased(this.value)">
                        <option value="0">-- select --</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>ឃុំ/សង្កាត់</label>
                    <select class="form-select select2" id="deceased_commune_code" data-required="0" onchange="GetVillage_Deceased(this.value)">
                        <option value="0">-- select --</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>ភូមិ</label>
                    <select class="form-select select2" id="deceased_village" data-required="0">
                        <option value="0">-- select --</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>លេខផ្លូវ</label>
                    <input type="text" class="form-control" id="deceased_street">
                </div>
                <div class="col-md-2">
                    <label>លេខផ្ទះ</label>
                    <input type="text" class="form-control" id="deceased_house">
                </div>
            </div>

        </div>
    </div>
    <div class="row" style="padding-top: 10px;">
        <div class="col-md-12" style="text-align: right">
            <a href="{{route('emr_death.index')}}" type="button" class="btn btn-danger"><i class="bx bx-arrow-back"></i> Back</a>
            <button type="button" class="btn btn-success" id="btnSave" onclick="Save()"><i class="bx bxs-save"></i> Save</button>
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
                    $('#deceased_province_code').select2({data: province, width: '100%'});

                    var gender = result.gender;
                    for(i=0; i<gender.length; i++){
                        $("#div_sex").append('<div class="form-check form-check-inline">'+
                            '<input class="form-check-input" type="radio" name="sex" value="'+gender[i].id+'" id="sex'+i+'">'+
                            '<label class="form-check-label" for="sex'+i+'">'+gender[i].text+'</label>'+
                            '</div>');
                    }
                    var death_info = result.death_info;
                    for(i=0; i<death_info.length; i++){
                        $("#div_death_info").append('<div class="form-check form-check-inline">'+
                            '<input class="form-check-input" type="radio" name="death_info" value="'+death_info[i].id+'" id="death_info'+i+'">'+
                            '<label class="form-check-label" for="death_info'+i+'">'+death_info[i].text+'</label>'+
                            '</div>');
                    }

                    var death_type = result.death_type;
                    for(i=0; i<death_type.length; i++){
                        $("#div_death_type").append('<div class="form-check form-check-inline">'+
                            '<input class="form-check-input" type="radio" name="death_type" value="'+death_type[i].id+'" id="death_type'+i+'">'+
                            '<label class="form-check-label" for="death_type'+i+'">'+death_type[i].text+'</label>'+
                        '</div>');
                    }

                    // var hf_type = result.hf_type;
                    // for(i=0; i<hf_type.length; i++){
                    //     $("#div_hf_type").append('<div class="form-check form-check-inline">'+
                    //         '<input class="form-check-input" type="radio" name="hf_type" value="'+hf_type[i].id+'" id="hf_type'+i+'">'+
                    //         '<label class="form-check-label" for="hf_type'+i+'">'+hf_type[i].text+'</label>'+
                    //         '</div>');
                    // }

                    var married_status = result.married_status;
                    for(i=0; i<married_status.length; i++){
                        $("#div_married_status").append('<div class="form-check form-check-inline">'+
                            '<input class="form-check-input" type="radio" name="married_status" value="'+married_status[i].id+'" id="married_status'+i+'">'+
                            '<label class="form-check-label" for="married_status'+i+'">'+married_status[i].text+'</label>'+
                            '</div>');
                    }
                }
            });
            @if($user[0]->province_id != 0){
                $('#txtHF_Province').val({{$user[0]->province_id}}).trigger("change");
                $('#txtHF_Province').prop("disabled", true);
            }
            @endif
        })

        function isBaby(checked){
            if(checked == true){
                $("#age_year").hide();
                $("#age_day").show();
                $("#date_of_birth").prop("disabled",true);
                $("#date_of_birth").val("");
                $(".age_type").prop("disabled",false);
            }
            else{
                $("#age_year").show();
                $("#age_day").hide();
                $("#date_of_birth").prop("disabled",false);
                $(".age_type").prop("disabled",true);
                $("#age_1").prop("checked",true);
            }

        }
        function getAge() {

            if($('#date_of_birth').val() != "" && $('#date_of_death').val() != ""){

                var start = new Date($('#date_of_birth').val());
                var end = new Date($('#date_of_death').val());
                if(start.getTime() > end.getTime()){
                    MSG.Error("ថ្ងៃខែឆ្នាំកំណើត មិនអាចធំជាង ថ្ងៃខែឆ្នាំ-មរណភាព បានទេ !!!");
                    $('#date_of_birth').val("");
                    $('#date_of_death').val("");
                    $('#age_year').val("");
                    return false;
                }
                // end - start returns difference in milliseconds
                var diff = new Date(end - start);
                // get days
                var days = diff/1000/60/60/24;
                var year = Math.floor(days/365)+"ឆ្នាំ ";
                var month = Math.floor((parseInt(days)%365)/30)+"ខែ ";
                var day = Math.floor((parseInt(days)%365)%30)+"ថ្ងៃ";
                $("#age_year").val(year+month+day);
            }
            else{
                $("#age_year").val("");
            }

        }
        function GetDistrict_Deceased(PCode){
            $.ajax({
                type:'POST',
                url:"{{ route('emr_death.getDistrict') }}",
                data:{
                    PCode:PCode,
                },
                success:function(result){
                    console.log(result);
                    $('#deceased_district_code').html("");
                    var district = result.district;
                    district.unshift({ id: 0, text:'-- select --'});
                    $('#deceased_district_code').select2({data: district, width: '100%'});

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
                    $('#deceased_commune_code').select2({data: commune, width: '100%'});

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
                    $('#deceased_village').select2({data: village, width: '100%'});

                }
            });
        }

        function Save(){
            var death_id = $("#death_id").val();
            var hf_code = $("#hf_code").val();
            var death_type = $("input[name='death_type']:checked");
            var death_info = $("input[name='death_info']:checked");
            var medical_file_id ="";
            var medicalid_list = document.getElementsByName("medical_file_id");
            for(i = 0; i < medicalid_list.length; i++){
                medical_file_id += medicalid_list[i].value;
            }
            var date_of_death = $("#date_of_death").val();
            var time_of_death = $("#time_of_death").val();
            var deceased_name = $("#deceased_name").val();
            var date_of_birth = $("#date_of_birth").val();
            var sex = $("input[name='sex']:checked");
            var married_status = $("input[name='married_status']:checked");
            var deceased_province_code = $("#deceased_province_code").val();
            var deceased_district_code = $("#deceased_district_code").val();
            var deceased_commune_code = $("#deceased_commune_code").val();
            var deceased_village = $("#deceased_village").val();
            var deceased_street = $("#deceased_street").val();
            var deceased_house = $("#deceased_house").val();

            var age = $("#age_year").val();
            var is_baby =0;
            if($("#txtCheckAge").is(':checked')){
                age = $("#age_day").val();
                is_baby =1;
            }

            if(hf_code == 0){
                MSG.Validation("សូមជ្រើសរើស មណ្ឌលសុខភាព !!!");
            }
            else if(death_type.length == 0){
                MSG.Validation("សូមបញ្ចូល ករណីស្លាប់ !!!");
            }
            else if(death_info.length == 0){
                MSG.Validation("សូមបញ្ចូល ព័ត៌មានមរណភាព !!!");
            }
            else if(deceased_name == ""){
                MSG.Validation("សូមបញ្ចូល ឈ្មោះអ្នកស្លាប់ !!!");
            }
            else if(medical_file_id == ""){
                MSG.Validation("សូមបញ្ចូល អត្តលេខឯកសារពេទ្យ !!!");
            }
            else if(sex.length == 0){
                MSG.Validation("សូមបញ្ចូល ភេទ !!!");
            }
            else if(married_status.length == 0){
                MSG.Validation("សូមបញ្ចូល ស្ថានភាពគ្រួសារ !!!");
            }
            else if(date_of_birth == ""){
                MSG.Validation("សូមបញ្ចូល ថ្ងៃខែឆ្នាំកំណើត !!!");
            }
            else if(date_of_death == ""){
                MSG.Validation("សូមបញ្ចូល ថ្ងៃខែឆ្នាំ-មរណភាព !!!");
            }
            else if(time_of_death == ""){
                MSG.Validation("សូមបញ្ចូល ម៉ោង-មរណភាព !!!");
            }
            else if(deceased_province_code == 0){
                MSG.Validation("សូមបញ្ចូល រាជធានី-ខេត្ត !!!");
            }
            else if(age == ""){
                MSG.Validation("សូមបញ្ចូល អាយុ !!!");
            }
            else{
                $.ajax({
                    type:'POST',
                    url:"{{ route('emr_death.Save') }}",
                    data:{
                        death_id:death_id,
                        hmis_code: hf_code,
                        death_type:death_type[0].value,
                        death_info:death_info[0].value,
                        medical_file_id:medical_file_id,
                        date_of_death:date_of_death,
                        time_of_death:time_of_death,
                        deceased_name:deceased_name,
                        date_of_birth:date_of_birth,
                        sex:sex[0].value,
                        age: age,
                        is_baby: is_baby,
                        married_status:married_status[0].value,
                        deceased_province_code:deceased_province_code,
                        deceased_district_code:deceased_district_code,
                        deceased_commune_code:deceased_commune_code,
                        deceased_village:deceased_village,
                        deceased_street:deceased_street,
                        deceased_house:deceased_house,
                    },
                    success:function(result){
                        console.log(result);
                        if(result.code == 0){
                            MSG.Success();
                            location.href = "{{route('emr_death.index')}}";
                            // $("#frmAddNew").modal('hide');
                            // LoadData();
                        }
                    }
                });
            }
        }

        function GetOD(province_code){

            $.ajax({
                type:'POST',
                url:"{{ route('users.getDistrict') }}",
                data:{
                    pro_code:province_code
                },
                success:function(result){
                    console.log(result);
                    $('#txtHF_District').html("");
                    var district = result.district;
                    district.unshift({ id: 0, text:'-- select --'});
                    $('#txtHF_District').select2({data: district, width: '100%'});
                        @if($user[0]->district_id != 0){
                        $('#txtHF_District').val({{$user[0]->district_id}}).trigger("change");
                        $('#txtHF_District').prop("disabled", true);
                    }
                    @endif
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
                    $('#hf_code').html("");
                    var HF = result.HF;
                    HF.unshift({ id: 0, text:'-- select --'});
                    $('#hf_code').select2({data: HF, width: '100%'});

                        @if($user[0]->hf_id != 0){
                        $('#hf_code').val({{$user[0]->hf_id}}).trigger("change");
                        $('#hf_code').prop("disabled", true);
                    }
                    @endif

                }
            });
        }
    </script>
@endsection
