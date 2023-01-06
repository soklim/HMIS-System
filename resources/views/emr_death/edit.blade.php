@extends('layouts.app')
@section('content')
    <style>
        .medical_file_id{
            padding-left: 0px;
            padding-right: 0px;
            text-align: center;
        }
    </style>
    @foreach($data as $item1)
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{$module[0]->group_module_name}}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{$module[0]->module_name}} (កែប្រែ)</li>
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
                        <label>មូលដ្ឋានសុខាភីបាល <span class="text-danger">(*)</span></label>
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
                        <label>ព័ត៌មានមរណៈភាព <span class="text-danger">(*)</span></label>
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
                <div class="col-md-3">
                    <label>ឈ្មោះមរណៈជន <span class="text-danger">(*)</span></label>
                    <input type="text" id="deceased_name" value="{{$item1->deceased_name}}" class="form-control" placeholder="គ្មាន"/>
                </div>
                <div class="col-md-5">
                    <div class="form-group mb-3">
                        <label>អត្តលេខឯកសារពេទ្យ <span class="text-danger">(*)</span></label>
                        <div class="input-group">
                            @foreach(str_split($item1->medical_file_id) as $value)
                                <input type="text" class="form-control medical_file_id" maxlength="1" value="{{$value}}" name="medical_file_id">
                            @endforeach
                            @if(strlen($item1->medical_file_id) < 13)
                                @for ($i = 0; $i < 13-strlen($item1->medical_file_id); $i++)
                                    <input type="text" class="form-control medical_file_id" maxlength="1" name="medical_file_id">
                                @endfor
                            @endif
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
                    @if($item1->input_age == 0)
                        <label><input type="checkbox" id="txtCheckAge" onchange="inputAge(this.checked)"/> អាយុ</label>
                    @else
                        <label><input type="checkbox" id="txtCheckAge" onchange="inputAge(this.checked)" checked/> អាយុ</label>
                    @endif
                    @foreach($age_type as $age_type)
                        @if($age_type->item_id == $item1->age_type_id)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input age_type" value="{{$age_type->item_id}}" disabled id="age_type_{{$age_type->item_id}}" checked type="radio" name="age_type">
                                <label class="form-check-label" for="age_type_{{$age_type->item_id}}">{{$age_type->name_kh}}</label>
                            </div>
                        @else
                            <div class="form-check form-check-inline">
                                <input class="form-check-input age_type" value="{{$age_type->item_id}}" disabled id="age_type_{{$age_type->item_id}}" type="radio" name="age_type">
                                <label class="form-check-label" for="age_type_{{$age_type->item_id}}">{{$age_type->name_kh}}</label>
                            </div>
                        @endif
                    @endforeach
                    <input type="number" class="form-control" id="age" data-required="1" value="{{$item1->age}}" disabled>
                </div>
                <div class="col-md-3">
                    <label>ថ្ងៃខែឆ្នាំ-កំណើត</label>
                    @if($item1->date_of_birth != "")
                        <input type="text" id="date_of_birth" class="form-control datefield" onchange="getAge()" value="{{date('d-m-Y', strtotime($item1->date_of_birth))}}"  placeholder="DD:MM:YYYY" />
                    @else
                        <input type="text" id="date_of_birth" class="form-control datefield" onchange="getAge()" placeholder="DD:MM:YYYY" />
                    @endif
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label>ថ្ងៃខែឆ្នាំ-មរណៈភាព <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control datefield" id="date_of_death" onchange="getAge()" value="{{date('d-m-Y', strtotime($item1->date_of_death))}}" data-required="1" placeholder="DD:MM:YYYY">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label>ម៉ោង-មរណៈភាព <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control timefield" id="time_of_death" value="{{$item1->time_of_death}}" data-required="1" placeholder="HH:MM">
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
                    <label>ផ្លូវលេខ</label>
                    <input type="text" class="form-control" value="{{$item1->deceased_street}}" placeholder="គ្មាន" id="deceased_street">
                </div>
                <div class="col-md-2">
                    <label>ផ្ទះលេខ</label>
                    <input type="text" class="form-control" value="{{$item1->deceased_house}}" placeholder="គ្មាន" id="deceased_house">
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
                    @else{
                        $('#txtHF_District').val({{$data[0]->OD_CODE}}).trigger("change");
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
                    @else{
                        $('#hf_code').val({{$data[0]->hfac_code}}).trigger("change");
                    }
                    @endif

                }
            });
        }

    </script>
    <script src="/assets/js/death.js?v02"></script>
  @endforeach
@endsection
