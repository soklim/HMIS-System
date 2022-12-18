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
                    <li class="breadcrumb-item active" aria-current="page">Birth Notification (Create)</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" id="bid" value="0" data-required="0">
            <h6 style="font-weight: bold;text-decoration: underline">ព័ត៌មានមូលដ្ឋានសុខាភិបាល</h6>
            <hr>
            <div class="row">
                <div class="col-md-3">
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
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label>ក្រុង/ស្រុក/ខណ្ឌ <span class="text-danger">(*)</span></label>
                        <select class="form-select select2" id="txtHF_District" data-required="0" onchange="GetHF(this.value)">
                            <option value="0">-- select --</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label>មណ្ឌលសុខភាព <span class="text-danger">(*)</span></label>
                        <select class="form-select select2" id="hf_code" data-required="0">
                            <option value="0">-- select --</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label>លេខឯកសារពេទ្យ <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control" id="medicalid" data-required="1" maxlength="11">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>ព័ត៌មានកំណើត <span class="text-danger">(*)</span></label><br>
                        @foreach($birth_info as $birth_info)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="birth_info_{{$birth_info->item_id}}" type="radio" name="birth_info" value="{{$birth_info->item_id}}">
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
                                <input class="form-check-input" id="birth_type_{{$birth_type->item_id}}" type="radio" name="birth_type" value="{{$birth_type->item_id}}">
                                <label class="form-check-label" for="birth_type_{{$birth_type->item_id}}">{{$birth_type->name_kh}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label>Attendant at delivery <span class="text-danger">(*)</span></label><br>
                        @foreach($attendant_at_delivery as $attendant_at_delivery)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="attendant_at_delivery_{{$attendant_at_delivery->item_id}}" type="radio" name="attendant_at_delivery" value="{{$attendant_at_delivery->item_id}}">
                                <label class="form-check-label" for="attendant_at_delivery_{{$attendant_at_delivery->item_id}}">{{$attendant_at_delivery->name_kh}}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="abandoned_baby">
                            <label class="form-check-label" for="abandoned_baby">បោះបង់ចោល</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <h6 style="font-weight: bold;text-decoration: underline">ព័ត៌មានទារក</h6>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <label>ឈ្មោះ <span class="text-danger">(*)</span></label>
                    <input type="text" id="baby_name" class="form-control"/>
                </div>
                <div class="col-md-2">
                    <label>ភេទ <span class="text-danger">(*)</span></label><br>
                    @foreach($sex as $sex)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="sex{{$sex->item_id}}" type="radio" name="sex" value="{{$sex->item_id}}">
                            <label class="form-check-label" for="sex{{$sex->item_id}}">{{$sex->name_kh}}</label>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label>គីឡូ <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control" id="birth_weight" placeholder="គិតជាគីឡូ និងក្រាម" data-required="1">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label>ថ្ងៃខែឆ្នាំ-កំណើត <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control datefield" id="date_of_birth" data-required="1" placeholder="YYYY-MM-DD">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label>ម៉ោង-កំណើត <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control timefield" id="time_of_birth" data-required="1" placeholder="MM:HH">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label>ឈ្មោះម្ដាយ <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control" id="mother_name" data-required="1">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label>ថ្ងៃខែឆ្នាំ-កំណើត(ម្ដាយ) <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control datefield" id="mother_date_of_birth" data-required="1" placeholder="YYYY-MM-DD">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label>ឈ្មោះឪពុក <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control" id="father_name" data-required="1">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label>ថ្ងៃខែឆ្នាំ-កំណើត(ឪពុក) <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control datefield" id="father_name_date_of_birth" data-required="1" placeholder="YYYY-MM-DD">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-3">
                        <label>ចំនួនកូនដែលធ្លាប់កើតពីមុន <span class="text-danger">(*)</span></label>
                        <input type="number" maxlength="2" class="form-control" id="numofchildalive" data-required="1">
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
                    <input type="text" class="form-control" id="mother_street">
                </div>
                <div class="col-md-2">
                    <label>លេខផ្ទះ</label>
                    <input type="text" class="form-control" id="mother_house">
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

            $(".select2").select2();

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
                    var district = result.district;
                    district.unshift({ id: 0, text:'-- select --'});
                    $('#mother_district').select2({data: district, width: '100%'});

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
                    var commune = result.commune;
                    commune.unshift({ id: 0, text:'-- select --'});
                    $('#mother_commune').select2({data: commune, width: '100%'});

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

                }
            });
        }

        function Save(){
            var bid = $("#bid").val();
            var hf_code = $("#hf_code").val();
            var medicalid = $("#medicalid").val();
            var birth_info = $("input[name='birth_info']:checked");
            var birth_type = $("input[name='birth_type']:checked");
            var attendant_at_delivery = $("input[name='attendant_at_delivery']:checked");
            var abandoned_baby=0;
            if ($("#abandoned_baby").is(':checked')) {
                abandoned_baby =1;
            }
            var baby_name = $("#baby_name").val();
            var sex = $("input[name='sex']:checked");
            var date_of_birth = $("#date_of_birth").val();
            var time_of_birth = $("#time_of_birth").val();
            var mother_name = $("#mother_name").val();
            var mother_date_of_birth = $("#mother_date_of_birth").val();
            var father_name = $("#father_name").val();
            var father_date_of_birth = $("#father_name_date_of_birth").val();
            var numofchildalive = $("#numofchildalive").val();
            var mother_province = $("#mother_province").val();
            var mother_district = $("#mother_district").val();
            var mother_commune = $("#mother_commune").val();
            var mother_village = $("#mother_village").val();
            var mother_street = $("#mother_street").val();
            var mother_house = $("#mother_house").val();

            if(hf_code == 0){
                MSG.Validation("សូមជ្រើសរើស មណ្ឌលសុខភាព !!!");
            }
            else if(medicalid == ""){
                MSG.Validation("សូមបញ្ចូល អត្តលេខឯកសារពេទ្យ !!!");
            }
            else if(birth_info.length == 0){
                MSG.Validation("សូមជ្រើសរើស ព័ត៌មានកំណើត !!!");
            }
            else if(birth_type.length == 0){
                MSG.Validation("សូមជ្រើសរើស ប្រភេទកំណើត !!!");
            }
            else if(attendant_at_delivery.length == 0){
                MSG.Validation("សូមជ្រើសរើស attendant_at_delivery !!!");
            }
            else if(baby_name == ""){
                MSG.Validation("សូមបញ្ចូល ឈ្មោះទារក !!!");
            }
            else if(sex.length == 0){
                MSG.Validation("សូមជ្រើសរើស ភេទ !!!");
            }
            else if(date_of_birth == ""){
                MSG.Validation("សូមបញ្ចូល ថ្ងៃខែឆ្នាំកំណើត !!!");
            }
            else if(time_of_birth == ""){
                MSG.Validation("សូមបញ្ចូល ម៉ោងកំណើត !!!");
            }
            else if(mother_name == ""){
                MSG.Validation("សូមបញ្ចូល ឈ្មោះម្ដាយ !!!");
            }
            else if(mother_date_of_birth == 0){
                MSG.Validation("សូមបញ្ចូល ថ្ងៃខែឆ្នាំកំណើត(ម្ដាយ) !!!");
            }
            else if(father_name == ""){
                MSG.Validation("សូមបញ្ចូល ឈ្មោះឪពុក !!!");
            }
            else if(father_date_of_birth == 0){
                MSG.Validation("សូមបញ្ចូល ថ្ងៃខែឆ្នាំកំណើត(ឪពុក) !!!");
            }
            else if(numofchildalive == ""){
                MSG.Validation("សូមបញ្ចូល ចំនួនកូនដែលធ្លាប់កើតពីមុន !!!");
            }
            else if(mother_province == ""){
                MSG.Validation("សូមបញ្ចូល ទីលំនៅប្រក្រតីរបស់ម្ដាយ !!!");
            }
            else{
                $.ajax({
                    type:'POST',
                    url:"{{ route('emr_birth.Save') }}",
                    data:{
                        bid:bid,
                        hf_code: hf_code,
                        medicalid:medicalid,
                        birth_info:birth_info[0].value,
                        birth_type:birth_type[0].value,
                        attendant_at_delivery:attendant_at_delivery[0].value,
                        abandoned_baby:abandoned_baby,
                        baby_name:baby_name,
                        sex:sex[0].value,
                        date_of_birth: date_of_birth,
                        time_of_birth: time_of_birth,
                        mother_name: mother_name,
                        mother_date_of_birth:mother_date_of_birth,
                        father_name:father_name,
                        father_date_of_birth:father_date_of_birth,
                        numofchildalive:numofchildalive,
                        mother_province:mother_province,
                        mother_district:mother_district,
                        mother_commune:mother_commune,
                        mother_village:mother_village,
                        mother_street:mother_street,
                        mother_house:mother_house,
                    },
                    success:function(result){
                        console.log(result);
                        if(result.code == 0){
                            MSG.Success();
                            location.href = "{{route('emr_birth.index')}}";
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

                }
            });
        }
    </script>
@endsection
