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
                    <li class="breadcrumb-item active" aria-current="page">Death Notification (Create)</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" id="death_id" value="0" data-required="0">
            <h6 style="font-weight: bold;text-decoration: underline">ព័ត៌មានមរណៈភាព</h6>
            <hr>
            @foreach($hf_info as $item)
            <div class="row">
                <div class="col-md-4">
                    <label>ឈ្មោះមូលដ្ឋានសុខាភិបាល: <span style="font-weight: bold">{{$item->hfac_namekh}}</span></label>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
{{--                        <label>ករណីស្លាប់ <span class="text-danger">(*)</span></label>--}}
                        <div id="div_death_type">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>លេខកូដមូលដ្ឋានសុខាភិបាល(HMIS) <span id="hmis_code" style="font-weight: bold">{{$item->hfac_label}}</span></label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>ព័ត៌មានមរណភាព <span class="text-danger">(*)</span></label>
                        <div id="div_death_info">

                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label>ឃុំ/សង្កាត់: <span style="font-weight: bold"></span></label>
                        </div>
                        <div class="col-md-4">
                            <label>ក្រុង/ស្រុក/ខណ្ឌ: <span style="font-weight: bold">{{$item->od_name_kh}}</span></label>
                        </div>
                        <div class="col-md-4">
                            <label>រាជធានី-ខេត្ត: <span style="font-weight: bold">{{$item->province_kh}}</span></label>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-md-12">
            <h6 style="font-weight: bold;text-decoration: underline">ព័ត៌មានអ្នកស្លាប់</h6>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <label>ឈ្មោះ <span class="text-danger">(*)</span></label>
                    <input type="text" id="deceased_name" class="form-control"/>
                </div>
                <div class="col-md-4">
                    <label>ថ្ងៃខែឆ្នាំកំណើត <span class="text-danger">(*)</span></label>
                    <input type="text" id="date_of_birth" class="form-control datefield" placeholder="YYYY-MM-DD" />
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
                        <label>អត្តលេខឯកសារពេទ្យ <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control" id="medical_file_id" data-required="1">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>ថ្ងៃខែឆ្នាំ-មរណភាព <span class="text-danger">(*)</span></label>
                        <input type="text" class="form-control datefield" id="date_of_death" data-required="1" placeholder="YYYY-MM-DD">
                    </div>
                </div>
                <div class="col-md-4">
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
                    // $('#death_province_code').select2({data: province, width: '100%'});
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

                    var married_status = result.married_status;
                    for(i=0; i<married_status.length; i++){
                        $("#div_married_status").append('<div class="form-check form-check-inline">'+
                            '<input class="form-check-input" type="radio" name="married_status" value="'+married_status[i].id+'" id="married_status'+i+'">'+
                            '<label class="form-check-label" for="married_status'+i+'">'+married_status[i].text+'</label>'+
                            '</div>');
                    }
                }
            });
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

            if(death_type.length == 0){
                MSG.Validation("សូមបញ្ចូល ករណីស្លាប់ !!!");
            }
            else if(death_info.length == 0){
                MSG.Validation("សូមបញ្ចូល ព័ត៌មានមរណភាព !!!");
            }
            else if(deceased_name == ""){
                MSG.Validation("សូមបញ្ចូល ឈ្មោះអ្នកស្លាប់ !!!");
            }
            else if(date_of_birth == ""){
                MSG.Validation("សូមបញ្ចូល ថ្ងៃខែឆ្នាំកំណើត !!!");
            }
            else if(sex.length == 0){
                MSG.Validation("សូមបញ្ចូល ភេទ !!!");
            }
            else if(married_status.length == 0){
                MSG.Validation("សូមបញ្ចូល ស្ថានភាពគ្រួសារ !!!");
            }
            else if(medical_file_id == ""){
                MSG.Validation("សូមបញ្ចូល អត្តលេខឯកសារពេទ្យ !!!");
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
            else{
                $.ajax({
                    type:'POST',
                    url:"{{ route('emr_death.Save') }}",
                    data:{
                        death_id:death_id,
                        death_type:death_type[0].value,
                        death_info:death_info[0].value,
                        medical_file_id:medical_file_id,
                        date_of_death:date_of_death,
                        time_of_death:time_of_death,
                        // death_province_code:death_province_code,
                        // death_district_code:death_district_code,
                        // death_commune_code:death_commune_code,
                        deceased_name:deceased_name,
                        date_of_birth:date_of_birth,
                        sex:sex[0].value,
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
@endsection
