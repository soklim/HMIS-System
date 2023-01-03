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
                    <li class="breadcrumb-item active" aria-current="page">Birth Notification</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <hr />
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
                        <label>ឈ្មោះទារក</label>
                        <input type="text" class="form-control" id="txtBabyName" maxlength="50">
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
            @if($permission->a_create == 1)
                <a href="{{route('emr_birth.create')}}" type="button" class="btn btn-primary" id="btnAdd"><i class="bx bx-plus"></i>បន្ថែម</a>
            @endif
            <button type="button" class="btn btn-success" id="btnExport" onclick="ExportExcel('xlsx');"><i class="bx bx-download"></i> Export</button>
        </div>
    </div>
    <div class="row" style="padding-top: 10px;">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm" id="myTable">
                    <tr>
                        <th class="text-center">ល.រ</th>
                        <th class="text-left">មូលដ្ឋានសុខាភិបាល</th>
                        <th class="text-center">លេខឯកសារពេទ្យ</th>
                        <th class="text-left">ឈ្មោះទារក</th>
                        <th class="text-center">ព័ត៌មានកំណើត</th>
                        <th class="text-center">ប្រភេទកំណើត</th>
                        <th class="text-center">ភេទ</th>
                        <th class="text-center">ថ្ងៃខែឆ្នាំកំណើត</th>
                        <th class="text-center"></th>
                    </tr>
                    <tbody id="bodyBirth">
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

        })
        function ExportExcel(type) {

            var data = document.getElementById('myTable');
            var file = XLSX.utils.table_to_book(data, { sheet: "sheet1" });
            XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
            XLSX.writeFile(file, 'download.' + type);
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

        function LoadData(){
            $("#bodyBirth").html("");
            $.ajax({
                type:'GET',
                url:"{{ route('emr_birth.GetData') }}",
                data:{
                    province: $("#txtHF_Province").val(),
                    district: $("#txtHF_District").val(),
                    hf_code: $("#txtHFCode").val(),
                    baby_name: $("#txtBabyName").val(),
                    medical_id: $("#txtMedicalId").val(),
                    birth_no: $("#txtIssueNo").val(),
                },
                success:function(data){
                    var item = data;
                    console.log(item);
                    for (var i = 0; i < item.length; i++) {
                        var btnEdit="";
                        @if($permission->a_update == 1)

                            var url = '{{route("emr_birth.edit", "id")}}';
                            url = url.replace('id', item[i].bid);
                            // btnEdit='<a href="/emr_birth/'+item[i].bid+'/edit" s="text-primay" style="font-size:24px" title="Edit"><i class="bx bx-edit"></i></a>';
                            btnEdit='<a href="'+url+'" s="text-primay" style="font-size:24px" title="Edit"><i class="bx bx-edit"></i></a>';
                        @endif
                        var btnPrint ='<a href="/emr_birth/'+item[i].bid+'" class="text-warning" target="_blank" style="font-size:24px"><i class="bx bx-printer"></i></a>';
                        $("#bodyBirth").append('<tr>'+
                            '<td class="text-center">'+item[i].birth_no+'</td>'+
                            '<td class="text-left">'+item[i].HFAC_NAMEKh+'</td>'+
                            '<td class="text-center">'+item[i].medicalid+'</td>'+
                            '<td class="text-left">'+(item[i].babyname  || "")+'</td>'+
                            '<td class="text-center">'+(item[i].birth_info)+'</td>'+
                            '<td class="text-center">'+(item[i].birth_type)+'</td>'+
                            '<td class="text-center">'+(item[i].sex)+'</td>'+
                            '<td class="text-center">'+(item[i].dateofbirth || "")+' | '+(item[i].time_of_birth || "")+'</td>'+
                            '<td class="text-center">'+btnEdit+btnPrint+'</td>'+
                            '</tr>');
                    }
                }
            });
        }
    </script>
@endsection
