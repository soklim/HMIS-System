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
                        <label>ព័ត៌មានមរណៈភាព <span class="text-danger">(*)</span></label>
                        <div id="div_death_info">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <h6 style="font-weight: bold;text-decoration: underline">ព័ត៌មានមរណៈជន</h6>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <label>ឈ្មោះមរណៈជន <span class="text-danger">(*)</span></label>
                    <input type="text" id="deceased_name" class="form-control" placeholder="គ្មាន"/>
                </div>
                <div class="col-md-5">
                    <div class="form-group mb-3">
                        <label>អត្តលេខឯកសារពេទ្យ <span class="text-danger">(*)</span></label>
                        <div class="input-group">
                            <input type="text" onkeypress="return Input.IsNumber(event, this)" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" onkeypress="return Input.IsNumber(event, this)" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" onkeypress="return Input.IsNumber(event, this)" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" onkeypress="return Input.IsNumber(event, this)" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" onkeypress="return Input.IsNumber(event, this)" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" onkeypress="return Input.IsNumber(event, this)" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" onkeypress="return Input.IsNumber(event, this)" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" onkeypress="return Input.IsNumber(event, this)" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" onkeypress="return Input.IsNumber(event, this)" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" onkeypress="return Input.IsNumber(event, this)" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" onkeypress="return Input.IsNumber(event, this)" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" onkeypress="return Input.IsNumber(event, this)" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                            <input type="text" onkeypress="return Input.IsNumber(event, this)" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
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
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label><input type="checkbox" id="txtCheckAge" onchange="inputAge(this.checked)"/> អាយុ</label>
                        @foreach($age_type as $age_type)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input age_type" value="{{$age_type->item_id}}" disabled id="age_type_{{$age_type->item_id}}" checked type="radio" name="age_type">
                                <label class="form-check-label" for="age_type_{{$age_type->item_id}}">{{$age_type->name_kh}}</label>
                            </div>
                        @endforeach

                        <input type="number" class="form-control" id="age" data-required="1" disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <label>ថ្ងៃខែឆ្នាំ-កំណើត</label>
                    <input type="text" id="date_of_birth" class="form-control datefield" onchange="getAge()" placeholder="DD:MM:YYYY" />
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label>ថ្ងៃខែឆ្នាំ-មរណៈភាព <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control datefield" id="date_of_death" onchange="getAge()" data-required="1" placeholder="DD:MM:YYYY">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label>ម៉ោង-មរណៈភាព <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control timefield" id="time_of_death" data-required="1" placeholder="HH:MM">
                    </div>
                </div>
                <div class="col-md-2">
                    <label>លេខទូរស័ព្ទទំនាក់ទំនង</label>
                    <input type="text" onkeypress="return Input.IsNumber(event, this)" maxlength="20" class="form-control" id="contact_phone">
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
                    <label>ផ្លូវលេខ</label>
                    <input type="text" class="form-control" id="deceased_street" placeholder="គ្មាន">
                </div>
                <div class="col-md-2">
                    <label>ផ្ទះលេខ</label>
                    <input type="text" class="form-control" id="deceased_house" placeholder="គ្មាន">
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

        $(document).ready(function (){

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
    <script src="/assets/js/death.js?v02"></script>
@endsection
