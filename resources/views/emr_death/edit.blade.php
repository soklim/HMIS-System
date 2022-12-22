@extends('layouts.app')
@section('content')
    @foreach($data as $item1)
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Transactions</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Death Notification (Edit)</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" id="death_id" value="{{$item1->death_id}}" data-required="0">
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
                        <label>មណ្ឌលសុខភាព <span class="text-danger">(*)</span></label>
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
                <div class="col-md-6">
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
                    <label>ឈ្មោះ <span class="text-danger">(*)</span></label>
                    <input type="text" id="deceased_name" value="{{$item1->deceased_name}}" class="form-control"/>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>អត្តលេខឯកសារពេទ្យ <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control" id="medical_file_id" value="{{$item1->medical_file_id}}" data-required="1">
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
                <div class="col-md-4">
                    <label>ថ្ងៃខែឆ្នាំកំណើត <span class="text-danger">(*)</span></label>
                    <input type="text" id="date_of_birth" class="form-control datefield" onchange="getAge()" value="{{$item1->date_of_birth}}"  placeholder="YYYY-MM-DD" />
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>ថ្ងៃខែឆ្នាំ-មរណភាព <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control datefield" id="date_of_death" onchange="getAge()" value="{{$item1->date_of_death}}" data-required="1" placeholder="YYYY-MM-DD">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label>ម៉ោង-មរណភាព <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control timefield" id="time_of_death" value="{{$item1->time_of_death}}" data-required="1" placeholder="MM:HH">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        @if($item1->is_baby == 0)
                            <label>អាយុ <span class="text-danger">(*)</span> <input type="checkbox" id="txtCheckAge" onchange="isBaby(this.checked)"/> ទារក </label>
                            <input type="text" class="form-control" id="age_year" value="{{$item1->age}}" data-required="1" readonly>
                            <input type="text" class="form-control timefield" id="age_day" data-required="1" style="display: none">
                        @else
                            <label>អាយុ <span class="text-danger">(*)</span> <input type="checkbox" id="txtCheckAge" checked onchange="isBaby(this.checked)"/> ទារក </label>
                            <input type="text" class="form-control" id="age_year" data-required="1" style="display: none" readonly>
                            <input type="text" class="form-control timefield" id="age_day" value="{{$item1->age}}" data-required="1">
                        @endif
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
                    <input type="text" class="form-control" value="{{$item1->deceased_street}}" id="deceased_street">
                </div>
                <div class="col-md-2">
                    <label>លេខផ្ទះ</label>
                    <input type="text" class="form-control" value="{{$item1->deceased_house}}" id="deceased_house">
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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
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
                        var checked="";
                        if(gender[i].id == {{$item1->sex}}){
                            checked ="checked"
                        }
                        $("#div_sex").append('<div class="form-check form-check-inline">'+
                            '<input class="form-check-input" type="radio" name="sex" value="'+gender[i].id+'" '+checked+' id="sex'+i+'">'+
                            '<label class="form-check-label" for="sex'+i+'">'+gender[i].text+'</label>'+
                            '</div>');
                    }
                    var death_info = result.death_info;

                    for(i=0; i<death_info.length; i++){
                        var checked="";
                        if(death_info[i].id == {{$item1->death_info}}){
                            checked ="checked"
                        }
                        $("#div_death_info").append('<div class="form-check form-check-inline">'+
                            '<input class="form-check-input" type="radio" name="death_info" value="'+death_info[i].id+'" '+checked+' id="death_info'+i+'">'+
                            '<label class="form-check-label" for="death_info'+i+'">'+death_info[i].text+'</label>'+
                            '</div>');
                    }

                    var death_type = result.death_type;
                    for(i=0; i<death_type.length; i++){
                        var checked="";
                        if(death_type[i].id == {{$item1->death_type}}){
                            checked ="checked"
                        }

                        $("#div_death_type").append('<div class="form-check form-check-inline">'+
                            '<input class="form-check-input" type="radio" name="death_type" value="'+death_type[i].id+'" '+checked+' id="death_type'+i+'">'+
                            '<label class="form-check-label" for="death_type'+i+'">'+death_type[i].text+'</label>'+
                            '</div>');
                    }

                    var married_status = result.married_status;
                    for(i=0; i<married_status.length; i++){
                        var checked="";
                        if(married_status[i].id == {{$item1->married_status}}){
                            checked ="checked"
                        }
                        $("#div_married_status").append('<div class="form-check form-check-inline">'+
                            '<input class="form-check-input" type="radio" name="married_status" value="'+married_status[i].id+'" '+checked+' id="married_status'+i+'">'+
                            '<label class="form-check-label" for="married_status'+i+'">'+married_status[i].text+'</label>'+
                            '</div>');
                    }
                    $('#deceased_province_code').val({{$item1->deceased_province_code}}).trigger("change");
                    $('#txtHF_Province').val({{$hf_info[0]->PRO_CODE}}).trigger("change");
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
            }
            else{
                $("#age_year").show();
                $("#age_day").hide();
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
                    $('#deceased_commune_code').find('option').not(':first').remove();
                    $('#deceased_village').find('option').not(':first').remove();

                    var district = result.district;
                    district.unshift({ id: 0, text:'-- select --'});
                    $('#deceased_district_code').select2({data: district, width: '100%'});
                    if(PCode == {{$item1->deceased_province_code}}){
                        $('#deceased_district_code').val({{$item1->deceased_district_code}}).trigger("change");
                    }

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
                    $('#deceased_village').find('option').not(':first').remove();
                    var commune = result.commune;
                    commune.unshift({ id: 0, text:'-- select --'});
                    $('#deceased_commune_code').select2({data: commune, width: '100%'});
                    if(DCode == {{$item1->deceased_district_code}}){
                        $('#deceased_commune_code').val({{$item1->deceased_commune_code}}).trigger("change");
                    }

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
                    if(CCode == {{$item1->deceased_commune_code}}){
                        $('#deceased_village').val({{$item1->deceased_village}}).trigger("change");
                    }

                }
            });
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
        function Save(){
            var death_id = $("#death_id").val();
            var hf_code = $("#hf_code").val();
            var death_type = $("input[name='death_type']:checked");
            var death_info = $("input[name='death_info']:checked");
            var medical_file_id = $("#medical_file_id").val();
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
                age = $("#age_day").val() +" ម៉ោង:នាទី";
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
                        is_baby: is_baby,
                        age: age,
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
    </script>
  @endforeach
@endsection
