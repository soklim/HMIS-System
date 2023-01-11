@extends('layouts.app')
@section('content')
    <style>
        .medicalid{
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
                    <li class="breadcrumb-item active" aria-current="page">{{$module[0]->module_name}} (កែប្រែ)</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" id="bid" value="{{$data[0]->bid}}" data-required="0">
            <h6 style="font-weight: bold;text-decoration: underline">ព័ត៌មានមូលដ្ឋានសុខាភិបាល</h6>
            <hr>
            <div class="row">
                <div class="col-md-2">
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
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label>ក្រុង/ស្រុក/ខណ្ឌ <span class="text-danger">(*)</span></label>
                        <select class="form-select select2" id="txtHF_District" data-required="0" onchange="GetHF(this.value)">
                            <option value="0">-- select --</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label>មូលដ្ឋានសុខាភិបាល <span class="text-danger">(*)</span></label>
                        <select class="form-select select2" id="hf_code" data-required="0">
                            <option value="0">-- select --</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <label>អត្តលេខសំណុំឯកសារសេវាសម្រាលកូន <span class="text-danger">(*)</span></label>
                    <div class="input-group">
                        @foreach(str_split($data[0]->medicalid) as $value)
                            <input type="text" onkeypress="return Input.IsNumber(event, this)" class="form-control medicalid" maxlength="1" value="{{$value}}" name="medicalid">
                        @endforeach
                        @if(strlen($data[0]->medicalid) < 13)
                            @for ($i = 0; $i < 13-strlen($data[0]->medicalid); $i++)
                                <input type="text" onkeypress="return Input.IsNumber(event, this)" class="form-control medicalid" maxlength="1" name="medicalid">
                            @endfor
                        @endif
{{--                        <input type="text" class="form-control" id="medicalid" data-required="1" value="{{$data[0]->medicalid}}" maxlength="11">--}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>ព័ត៌មានកំណើត <span class="text-danger">(*)</span></label><br>
                        @foreach($birth_info as $birth_info)
                            <div class="form-check form-check-inline">
                                @if($data[0]->birth_info == $birth_info->item_id)
                                    <input class="form-check-input" id="birth_info_{{$birth_info->item_id}}" type="radio" checked name="birth_info" value="{{$birth_info->item_id}}">
                                @else
                                    <input class="form-check-input" id="birth_info_{{$birth_info->item_id}}" type="radio" name="birth_info" value="{{$birth_info->item_id}}">
                                @endif
                                <label class="form-check-label" for="birth_info_{{$birth_info->item_id}}">{{$birth_info->name_kh}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label>ប្រភេទកំណើត <span class="text-danger">(*)</span></label><br>
                        @foreach($birth_type as $birth_type)
                            <div class="form-check form-check-inline">
                                @if($data[0]->typeofbirth == $birth_type->item_id)
                                    <input class="form-check-input" id="birth_type_{{$birth_type->item_id}}" checked type="radio" name="birth_type" value="{{$birth_type->item_id}}">
                                @else
                                    <input class="form-check-input" id="birth_type_{{$birth_type->item_id}}" type="radio" name="birth_type" value="{{$birth_type->item_id}}">
                                @endif
                                <label class="form-check-label" for="birth_type_{{$birth_type->item_id}}">{{$birth_type->name_kh}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label>អ្នកផ្ដល់សេវាសម្រាលកូន <span class="text-danger">(*)</span></label><br>
                        @foreach($attendant_at_delivery as $attendant_at_delivery)
                            <div class="form-check form-check-inline">
                                @if($data[0]->Atdelivery == $attendant_at_delivery->item_id)
                                    <input class="form-check-input" id="attendant_at_delivery_{{$attendant_at_delivery->item_id}}" checked type="radio" name="attendant_at_delivery" value="{{$attendant_at_delivery->item_id}}">
                                @else
                                    <input class="form-check-input" id="attendant_at_delivery_{{$attendant_at_delivery->item_id}}" type="radio" name="attendant_at_delivery" value="{{$attendant_at_delivery->item_id}}">
                                @endif
                                <label class="form-check-label" for="attendant_at_delivery_{{$attendant_at_delivery->item_id}}">{{$attendant_at_delivery->name_kh}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <div class="form-check">
                            @if($data[0]->abandoned == 1)
                                <input class="form-check-input" checked type="checkbox" id="abandoned_baby">
                            @else
                                <input class="form-check-input" type="checkbox" id="abandoned_baby">
                            @endif
                            <label class="form-check-label" for="abandoned_baby">ទារកបោះបង់ចោល</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <h6 style="font-weight: bold;text-decoration: underline">ព័ត៌មានទារក</h6>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <label>ឈ្មោះទារក <span class="text-danger">(*)</span></label>
                    <div class="input-group">
                        <input type="text" id="baby_last_name" class="form-control" value="{{$data[0]->baby_last_name}}" placeholder="គោត្តនាម"/>
                        <input type="text" id="baby_first_name" class="form-control" value="{{$data[0]->baby_first_name}}" placeholder="នាមខ្លួន"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <label>ភេទ <span class="text-danger">(*)</span></label><br>
                    @foreach($sex as $sex)
                        <div class="form-check form-check-inline">
                            @if($data[0]->sex == $sex->item_id)
                                <input class="form-check-input" id="sex{{$sex->item_id}}" checked type="radio" name="sex" value="{{$sex->item_id}}">
                            @else
                                <input class="form-check-input" id="sex{{$sex->item_id}}" type="radio" name="sex" value="{{$sex->item_id}}">
                            @endif
                            <label class="form-check-label" for="sex{{$sex->item_id}}">{{$sex->name_kh}}</label>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label>ទម្ងន់ទារក <span class="text-danger">(*)</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="baby_weight" value="{{$data[0]->baby_weight}}" data-required="1">
                            <button type="button" class="btn btn-secondary">ក្រាម</button>
                        </div>

                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label>ថ្ងៃខែឆ្នាំ-កំណើត <span class="text-danger">(*)</span></label>
                        @if($data[0]->dateofbirth != "")
                            <input type="text" id="date_of_birth" class="form-control datefield" value="{{date('d-m-Y', strtotime($data[0]->dateofbirth))}}" placeholder="DD:MM:YYYY" />
                        @else
                            <input type="text" id="date_of_birth" class="form-control datefield" placeholder="DD:MM:YYYY" />
                        @endif
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label>ម៉ោង-កំណើត <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control timefield" id="time_of_birth" value="{{$data[0]->time_of_birth}}" data-required="1" placeholder="MM:HH">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label>ឈ្មោះម្ដាយ <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control" value="{{$data[0]->mothername}}" id="mother_name" data-required="1">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            @if($data[0]->motherdofbirth != "")
                                <label><input type="checkbox" onchange="isMotherAge(this.checked)"/> អាយុ</label>
                            @else
                                <label><input type="checkbox" checked onchange="isMotherAge(this.checked)"/> អាយុ</label>
                            @endif

                            <div class="input-group">
                                <input type="number" class="form-control" value="{{$data[0]->motherage}}" id="motherAge" data-required="1" disabled>
                                <button type="button" class="btn btn-secondary">ឆ្នាំ</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>ថ្ងៃខែឆ្នាំ-កំណើត(ម្ដាយ)</label>
                                @if($data[0]->motherdofbirth != "")
                                    <input type="text" id="mother_date_of_birth" class="form-control datefield" onchange="GetMotherAge(this.value)" value="{{date('d-m-Y', strtotime($data[0]->motherdofbirth))}}"  placeholder="DD:MM:YYYY" />
                                @else
                                    <input type="text" id="mother_date_of_birth" class="form-control datefield" onchange="GetMotherAge(this.value)" placeholder="DD:MM:YYYY" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label>ឈ្មោះឪពុក <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control" value="{{$data[0]->fathername}}" id="father_name" data-required="1">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            @if($data[0]->fatherdofbirth != "")
                                <label><input type="checkbox" onchange="isFatherAge(this.checked)"/> អាយុ</label>
                            @else
                                <label><input type="checkbox" checked onchange="isFatherAge(this.checked)"/> អាយុ</label>
                            @endif

                            <div class="input-group">
                                <input type="number" class="form-control" value="{{$data[0]->fatherage}}" id="fatherAge" data-required="1" disabled>
                                <button type="button" class="btn btn-secondary">ឆ្នាំ</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>ថ្ងៃខែឆ្នាំ-កំណើត(ឪពុក)</label>
                                @if($data[0]->fatherdofbirth != "")
                                    <input type="text" id="father_date_of_birth" class="form-control datefield" onchange="GetFatherAge(this.value)" value="{{date('d-m-Y', strtotime($data[0]->fatherdofbirth))}}"  placeholder="DD:MM:YYYY" />
                                @else
                                    <input type="text" id="father_date_of_birth" class="form-control datefield" onchange="GetFatherAge(this.value)" placeholder="DD:MM:YYYY" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label>ចំនួនកូនកើតរស់ (មកទល់បច្ចុប្បន្ន) <span class="text-danger">(*)</span></label>
                        <input type="number" maxlength="2" class="form-control" id="numofchildalive" value="{{$data[0]->numofchildalive}}" data-required="1">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label>លេខទូរស័ព្ទទំនាក់ទំនង</label>
                        <input type="text" onkeypress="return Input.IsNumber(event, this)" maxlength="20" value="{{$data[0]->contact_phone}}" class="form-control" id="contact_phone" data-required="0">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <h6 style="font-weight: bold;text-decoration: underline">ទីលំនៅប្រក្រតីរបស់ម្ដាយ</h6>
            <hr>
            <div class="row">
                <div class="col-md-2">
                    <label>រាជធានី-ខេត្ត <span class="text-danger">(*)</span></label>
                    <select class="form-select select2" id="mother_province" data-required="0" onchange="GetDistrict_Mother(this.value)">
                        <option value="0">-- select --</option>
                        @foreach($province as $pro)
                            <option value="{{$pro->PROCODE}}">{{$pro->PROVINCE_KH}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label>ក្រុង/ស្រុក/ខណ្ឌ</label>
                    <select class="form-select select2" id="mother_district" data-required="0" onchange="GetCommune_Mother(this.value)">
                        <option value="0">-- select --</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>ឃុំ/សង្កាត់</label>
                    <select class="form-select select2" id="mother_commune" data-required="0" onchange="GetVillage_Mother(this.value)">
                        <option value="0">-- select --</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>ភូមិ</label>
                    <select class="form-select select2" id="mother_village" data-required="0">
                        <option value="0">-- select --</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>លេខផ្លូវ</label>
                    <input type="text" class="form-control" value="{{$data[0]->mStreet}}" id="mother_street" placeholder="គ្មាន">
                </div>
                <div class="col-md-2">
                    <label>លេខផ្ទះ</label>
                    <input type="text" class="form-control" value="{{$data[0]->mHouse}}" id="mother_house" placeholder="គ្មាន">
                </div>
            </div>

        </div>
    </div>
    <div class="row" style="padding-top: 10px;">
        <div class="col-md-12" style="text-align: right">
            <a href="{{route('emr_birth.index')}}" type="button" class="btn btn-danger"><i class="bx bx-arrow-back"></i> Back</a>
            <button type="button" class="btn btn-success" id="btnSave" onclick="Save()"><i class="bx bxs-save"></i> Save</button>
        </div>
    </div>
    <script type="text/javascript">


        $(document).ready(function (){

            $("#mother_province").val({{$data[0]->mPCode}}).trigger("change");
            @if($user[0]->province_id != 0){
                $('#txtHF_Province').val({{$user[0]->province_id}}).trigger("change");
                $('#txtHF_Province').prop("disabled", true);
            }
            @else
                $('#txtHF_Province').val({{$data[0]->PRO_CODE}}).trigger("change");
            @endif
        })

        function GetDistrict_Mother(PCode){
            $.ajax({
                type:'POST',
                url:"{{ route('emr_death.getDistrict') }}",
                data:{
                    PCode:PCode,
                },
                success:function(result){
                    console.log(result);
                    $('#mother_district').html("");
                    $('#mother_commune').find('option').not(':first').remove();
                    $('#mother_village').find('option').not(':first').remove();
                    var district = result.district;
                    district.unshift({ id: 0, text:'-- select --'});
                    $('#mother_district').select2({data: district, width: '100%'});
                    if(PCode == {{$data[0]->mPCode}}){
                        $('#mother_district').val({{$data[0]->mDCode}}).trigger("change");
                    }
                }
            });

        }
        function GetCommune_Mother(DCode){
            $.ajax({
                type:'POST',
                url:"{{ route('emr_death.getCommune') }}",
                data:{
                    DCode:DCode
                },
                success:function(result){
                    console.log(result);
                    $('#mother_commune').html("");
                    $('#mother_village').find('option').not(':first').remove();

                    var commune = result.commune;
                    commune.unshift({ id: 0, text:'-- select --'});
                    $('#mother_commune').select2({data: commune, width: '100%'});
                    if(DCode == {{$data[0]->mDCode}}){
                        $('#mother_commune').val({{$data[0]->mCCode}}).trigger("change");
                    }
                }
            });
        }
        function GetVillage_Mother(CCode){
            $.ajax({
                type:'POST',
                url:"{{ route('emr_death.getVillage') }}",
                data:{
                    CCode:CCode
                },
                success:function(result){
                    console.log(result);
                    $('#mother_village').html("");
                    var village = result.village;
                    village.unshift({ id: 0, text:'-- select --'});
                    $('#mother_village').select2({data: village, width: '100%'});
                    if(CCode == {{$data[0]->mCCode}}){
                        $('#mother_village').val({{$data[0]->mVCode}}).trigger("change");
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
                    $('#hf_code').find('option').not(':first').remove();
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
    <script src="/assets/js/birth.js?v01"></script>
@endsection
