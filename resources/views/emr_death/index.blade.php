@extends('layouts.app')
@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{$module[0]->group_module_name}}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{$module[0]->module_name}}</li>
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
                        <label>មូលដ្ឋានសុខាភិបាល</label>
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
                        <label>លេខចេញ</label>
                        <input type="text" class="form-control" id="txtIssueNo" maxlength="11">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-primary" id="btnSearch" onclick="LoadData()"><i class="bx bx-search-alt"></i> ស្វែងរក</button>
            @if($permission->a_create == 1)
                <a href="{{route('emr_death.create')}}" type="button" class="btn btn-primary" id="btnAdd"><i class="bx bx-plus"></i>បន្ថែមថ្មី</a>
            @endif
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
                        <th class="text-center">លេខចេញ</th>
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

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function (){
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

                        var btnEdit="";
                        @if($permission->a_update == 1)
                            btnEdit='<a href="/emr_death/'+item[i].death_id+'/edit" s="text-primay" style="font-size:24px" title="Edit"><i class="bx bx-edit"></i></a>';
                        @endif
                        var btnPrint ='<a href="/emr_death/'+item[i].death_id+'" class="text-warning" target="_blank" style="font-size:24px"><i class="bx bx-printer"></i></a>';
                        $("#bodyDeath").append('<tr>'+
                            '<td class="text-center">'+(i+1)+'</td>'+
                            '<td class="text-center">'+item[i].issue_no+'</td>'+
                            '<td class="text-left">'+item[i].HFAC_NAMEKh+'</td>'+
                            '<td class="text-center">'+item[i].medical_file_id+'</td>'+
                            '<td class="text-left">'+(item[i].deceased_name  || "")+'</td>'+
                            '<td class="text-center">'+(item[i].sex)+'</td>'+
                            '<td class="text-center">'+(item[i].married_status)+'</td>'+
                            '<td class="text-center">'+(item[i].age || "")+ item[i].age_type_name+'</td>'+
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
