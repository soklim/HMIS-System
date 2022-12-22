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
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>រាជធានី-ខេត្ត</label>
                        <select class="form-select select2" id="txtHF_Province" style="width: 100%" data-required="0" onchange="GetOD(this.value)">
                            <option value="0">-- select --</option>
                            @foreach($province as $pro)
                                <option value="{{$pro->PROCODE}}">{{$pro->PROVINCE_KH}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>ក្រុង/ស្រុក/ខណ្ឌ</label>
                        <select class="form-select select2" id="txtHF_District" data-required="0" onchange="GetHF(this.value)">
                            <option value="0">-- select --</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>មណ្ឌលសុខភាព</label>
                        <select class="form-select select2" id="txtHFCode" data-required="0">
                            <option value="0">-- select --</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>ឈ្មោះអ្នកស្លាប់</label>
                        <input type="text" class="form-control" id="txtDeceased_Name" maxlength="50">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>លេខឯកសារពេទ្យ</label>
                        <input type="text" class="form-control" id="txtMedicalId" maxlength="11">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label>Issue No</label>
                        <input type="text" class="form-control" id="txtIssueNo" maxlength="11">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-primary" id="btnSearch" onclick="LoadData()"><i class="bx bx-search-alt"></i> ស្វែងរក</button>
            <a href="{{route('emr_death.create')}}" type="button" class="btn btn-primary" id="btnAdd"><i class="bx bx-plus"></i>បន្ថែម</a>
            <button type="button" class="btn btn-success" id="btnExport" onclick="ExportExcel('xlsx');"><i class="bx bx-download"></i> Export</button>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm" id="myTable">
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
                    <tbody id="bodyDeath">

                    </tbody>
                </table>
            </div>
        </div>
    </div>


{{--    <div class="modal fade" id="frmAddNew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">--}}
{{--        <div class="modal-dialog modal-fullscreen" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title">Death Notification</h5>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-12">--}}
{{--                            <input type="hidden" id="death_id" value="0" data-required="0">--}}
{{--                            <h6 style="font-weight: bold;text-decoration: underline">ព័ត៌មានមរណៈភាព</h6>--}}
{{--                            <hr>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <div class="form-group mb-3">--}}
{{--                                        <label>ករណីស្លាប់ <span class="text-danger">(*)</span></label>--}}
{{--                                        <select class="form-select select2" id="death_type" data-required="1"></select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <div class="form-group mb-3">--}}
{{--                                        <label>ទីតាំងស្លាប់ <span class="text-danger">(*)</span></label>--}}
{{--                                        <select class="form-select select2" id="death_info" data-required="1"></select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <div class="form-group mb-3">--}}
{{--                                        <label>លេខកូដមូលដ្ឋានសុខាភិបាល(HMIS) <span class="text-danger">(*)</span></label>--}}
{{--                                        <input type="text" class="form-control" id="hmis_code" data-required="1">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <div class="form-group mb-3">--}}
{{--                                        <label>អត្តលេខឯកសារពេទ្យ <span class="text-danger">(*)</span></label>--}}
{{--                                        <input type="text" class="form-control" id="medical_file_id" data-required="1">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <div class="form-group mb-3">--}}
{{--                                        <label>ថ្ងៃខែឆ្នាំ-មរណភាព <span class="text-danger">(*)</span></label>--}}
{{--                                        <input type="text" class="form-control datefield" id="date_of_death" data-required="1" placeholder="ថ្ងៃ-ខែ-ឆ្នាំ">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <div class="form-group mb-3">--}}
{{--                                        <label>ម៉ោង-មរណភាព <span class="text-danger">(*)</span></label>--}}
{{--                                        <input type="text" class="form-control timefield" id="time_of_death" data-required="1" placeholder="ម៉ោង-នាទីំ">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-12">--}}
{{--                            <h6 style="font-weight: bold;text-decoration: underline">ទីតាំងមូលដ្ឋានសុខាភិបាល</h6>--}}
{{--                            <hr>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-3">--}}
{{--                                    <label>ឈ្មោះមូលដ្ឋានសុខាភិបាល</label>--}}
{{--                                    <input type="text" class="form-control" id="hf_name" value="{{$hf_name}}" data-required="0" readonly>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-3">--}}
{{--                                    <label>រាជធានី-ខេត្ត <span class="text-danger">(*)</span></label>--}}
{{--                                    <select class="form-select select2" id="death_province_code" data-required="0" onchange="GetDistrict(this.value)"></select>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-3">--}}
{{--                                    <label>ក្រុង/ស្រុក/ខណ្ឌ <span class="text-danger">(*)</span></label>--}}
{{--                                    <select class="form-select select2" id="death_district_code" data-required="0" onchange="GetCommune(this.value)">--}}
{{--                                        <option value="0">-- select --</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-3">--}}
{{--                                    <label>ឃុំ/សង្កាត់ <span class="text-danger">(*)</span></label>--}}
{{--                                    <select class="form-select select2" id="death_commune_code" data-required="0">--}}
{{--                                        <option value="0">-- select --</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-12" style="padding-top: 20px;">--}}
{{--                            <h6 style="font-weight: bold;text-decoration: underline">ព័ត៌មានអ្នកស្លាប់</h6>--}}
{{--                            <hr>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <label>ឈ្មោះ <span class="text-danger">(*)</span></label>--}}
{{--                                    <input type="text" id="deceased_name" class="form-control"/>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <label>ថ្ងៃខែឆ្នាំកំណើត <span class="text-danger">(*)</span></label>--}}
{{--                                    <input type="text" id="date_of_birth" class="form-control datefield" placeholder="ថ្ងៃ-ខែ-ឆ្នាំ" />--}}
{{--                                </div>--}}
{{--                                <div class="col-md-2">--}}
{{--                                    <label>ភេទ <span class="text-danger">(*)</span></label>--}}
{{--                                    <select class="form-select select2" id="sex" data-required="0"></select>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-2">--}}
{{--                                    <label>ស្ថានភាពគ្រួសារ <span class="text-danger">(*)</span></label>--}}
{{--                                    <select class="form-select select2" id="married_status" data-required="0"></select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="row" style="padding-top: 10px;">--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <label>រាជធានី-ខេត្ត <span class="text-danger">(*)</span></label>--}}
{{--                                    <select class="form-select select2" id="deceased_province_code" data-required="0" onchange="GetDistrict_Deceased(this.value)"></select>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <label>ក្រុង/ស្រុក/ខណ្ឌ</label>--}}
{{--                                    <select class="form-select select2" id="deceased_district_code" data-required="0" onchange="GetCommune_Deceased(this.value)">--}}
{{--                                        <option value="0">-- select --</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <label>ឃុំ/សង្កាត់</label>--}}
{{--                                    <select class="form-select select2" id="deceased_commune_code" data-required="0" onchange="GetVillage_Deceased(this.value)">--}}
{{--                                        <option value="0">-- select --</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="row" style="padding-top: 10px;">--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <label>ភូមិ</label>--}}
{{--                                    <select class="form-select select2" id="deceased_village" data-required="0">--}}
{{--                                        <option value="0">-- select --</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <label>លេខផ្លូវ</label>--}}
{{--                                    <input type="text" class="form-control" id="deceased_street">--}}
{{--                                </div>--}}
{{--                                <div class="col-md-4">--}}
{{--                                    <label>លេខផ្ទះ</label>--}}
{{--                                    <input type="text" class="form-control" id="deceased_house">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-success" onclick="Save()"><i class="bx bxs-save"></i> Save</button>--}}
{{--                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bx bx-x"></i> Close</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
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
            @if($user[0]->province_id != 0){
                $('#txtHF_Province').val({{$user[0]->province_id}}).trigger("change");
                $('#txtHF_Province').prop("disabled", true);
            }
            @endif
            $(".select2").select2();
            LoadData();
            // LoadData();
        })
        function ExportExcel(type) {

            var data = document.getElementById('myTable');
            var file = XLSX.utils.table_to_book(data, { sheet: "sheet1" });
            XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
            XLSX.writeFile(file, 'download.' + type);
        }
        function LoadData(){
            $("#bodyDeath").html("");
            $.ajax({
                type:'GET',
                url:"{{ route('emr_death.GetData') }}",
                data:{
                    province: $("#txtHF_Province").val(),
                    district: $("#txtHF_District").val(),
                    hf_code: $("#txtHFCode").val(),
                    deceased_name: $("#txtDeceased_Name").val(),
                    medical_id: $("#txtMedicalId").val(),
                    issue_no: $("#txtIssueNo").val(),
                },
                success:function(data){
                    console.log(data);
                    var item =data;
                    for (var i = 0; i < item.length; i++) {

                        var btnEdit='<a href="/emr_death/'+item[i].death_id+'/edit" s="text-primay" style="font-size:24px" title="Edit"><i class="bx bx-edit"></i></a>';
                        var btnPrint ='<a href="/emr_death/'+item[i].death_id+'" class="text-warning" target="_blank" style="font-size:24px"><i class="bx bx-printer"></i></a>';
                        $("#bodyDeath").append('<tr>'+
                            '<td class="text-center">'+item[i].issue_no+'</td>'+
                            '<td class="text-left">'+item[i].HFAC_NAMEKh+'</td>'+
                            '<td class="text-center">'+item[i].medical_file_id+'</td>'+
                            '<td class="text-left">'+(item[i].deceased_name  || "")+'</td>'+
                            '<td class="text-center">'+(item[i].sex)+'</td>'+
                            '<td class="text-center">'+(item[i].married_status)+'</td>'+
                            '<td class="text-center">'+(item[i].age || "")+'</td>'+
                            '<td class="text-center">'+(item[i].date_of_death || "")+' | '+(item[i].time_of_death || "")+'</td>'+
                            '<td class="text-center">'+btnEdit+btnPrint+'</td>'+
                            '</tr>');
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
                    $('#txtHFCode').html("");
                    var HF = result.HF;
                    HF.unshift({ id: 0, text:'-- select --'});
                    $('#txtHFCode').select2({data: HF, width: '100%'});

                        @if($user[0]->hf_id != 0){
                        $('#txtHFCode').val({{$user[0]->hf_id}}).trigger("change");
                        $('#txtHFCode').prop("disabled", true);
                    }
                    @endif

                }
            });
        }
    </script>
@endsection
