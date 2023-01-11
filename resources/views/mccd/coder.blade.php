@extends('layouts.app')
@section('content')
    <style>
        #tblMedical td{
            border: solid 1px black;
        }
        #tblMedical th{
            border: solid 1px black;
        }
        #tblSectionA td{
            border: solid 1px black;
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
                    <li class="breadcrumb-item active" aria-current="page">{{$module[0]->module_name}} (@if($type_id== 1) MCCD @else Fetal @endif)</li>
                </ol>
            </nav>
        </div>
    </div>
    <hr/>
    <div class="row">
        @foreach($death as $death)
            <div class="col-md-12" style="border: 1px solid #676767 !important;border-radius: 15px;padding: 20px;margin-left:10px;margin-right:10px;">
                <div style="width: 100%;">
                    <p style="display:inline;font-weight: bold;background: #fff;margin-top: -30px;margin-left: 10px;position: absolute;font-size: 16px;">
                        ព័ត៌មានមរណៈជន
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <input type="hidden" id="mccd_id" value="{{$mccd[0]->mccd_id}}">
                        <input type="hidden" id="death_id" value="{{$death->death_id}}">
                        <label>លេខចេញ: <b>{{$death->issue_no}}</b></label>
                    </div>
                    <div class="col-md-3">
                        <label>ឈ្មោះមរណៈជន: <b>{{$death->deceased_name}}</b></label>
                    </div>
                    <div class="col-md-1">
                        <label>ភេទ: <b>{{$death->sex}}</b></label>
                    </div>
                    <div class="col-md-1">
                        <label>អាយុ: <b>{{$death->age}}</b></label>
                    </div>
                    <div class="col-md-2">
                        <label>ករណីស្លាប់: <b>{{$death->death_type}}</b></label>
                    </div>
                    <div class="col-md-2">
                        <label>ព័ត៌មានមរណៈភាព: <b>{{$death->death_info}}</b></label>
                    </div>
                </div>

            </div>

        @endforeach
    </div>
    <div class="row" style="padding-top: 10px;">
        <div class="col-md-4"></div>
        <div class="col-md-2" style="text-align: center">
            @if($type_id== 1)
                <a class="btn btn-danger" href="/mccd_list/1" type="button" id="btnBack" style="width: 100%; border-radius: 18px;font-size: 16px">
                    <i class="bx bx-arrow-back"></i> ត្រឡប់ទៅទំព័រដើម
                </a>
            @else
                <a class="btn btn-danger" href="/fetal_list/2" type="button" id="btnBack" style="width: 100%; border-radius: 18px;font-size: 16px">
                    <i class="bx bx-arrow-back"></i> ត្រឡប់ទៅទំព័រដើម
                </a>
            @endif
        </div>
        <div class="col-md-2" style="text-align: center;">
            <button class="btn btn-success" type="button" id="btnSaveCoder" style="width: 100%; border-radius: 18px;font-size: 16px">
                <i class="bx bxs-save"></i> រក្សាទុក
            </button>
        </div>
        <div class="col-md-4" style="text-align: right">
            <button class="btn btn-success" onclick="AddCoder()" type="button" id="btnAddMoreCoder" style="border-radius: 18px;font-size: 16px">
                <i class="bx bx-plus"></i> បន្ថែម Coder
            </button>
        </div>
    </div>
    <div class="row" style="padding-top: 20px; padding-bottom: 20px;">
        <div class="col-md-12">
            <ul class="nav nav-tabs nav-success" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#sectionA" role="tab" aria-selected="true">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon"><i class="bx bxs-book-open font-18 me-1"></i>
                            </div>
                            <div class="tab-title">ទម្រង់ ក៖ ទិន្នន័យវេជ្ជសាស្ត្រ៖ ផ្នែកទី១ និងផ្នែកទី២</div>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="tab-content py-3">
                <div class="tab-pane fade show active" id="sectionA" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tblSectionA">
                                    <tr>
                                        <td rowspan="5" style="vertical-align: middle; width: 20%;">
                                            ១. រាយការណ៍អំពីជំងឺ ឬលក្ខខណ្ឌដែលបណ្ដាលស្លាប់ដោយផ្ទាល់នៅក្នុងជួរ ក <br><br><br>
                                            រាយការណ៍អំពីខ្សែសង្វាក់នៃហេតុការណ៍តាមលំដាប់លំដោយ (បើមាន)<br><br><br>
                                            បញ្ជាក់អំពីមូលហេតុបន្ទាប់បន្សំនៃការស្លាប់នៅជួរក្រោមគេបង្គាស់។
                                        </td>
                                        <td style="width: 5%"></td>
                                        <td style="width: 45%;vertical-align: middle;">មូលហេតុនៃការស្លាប់</td>
                                        <td style="width: 15%;vertical-align: middle;">ចន្លោះពេល(ចាប់ពីពេលចាប់ផ្ដើម រហូតដល់ពេលស្លាប់)</td>
                                        <td style="width: 15%;vertical-align: middle;" class="text-center coder">Coder</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%" class="text-center">ក <input type="hidden" value="{{$section_a[0]->id}}" id="section_a_id_1"></td>
                                        <td style="width: 45%">
                                            <input type="text" disabled class="form-control" value="{{$section_a[0]->death_reason}}" maxlength="500" name="reason" id="reason_1">
                                        </td>
                                        <td style="width: 15%">
                                            <input type="text" disabled class="form-control" value="{{$section_a[0]->period}}" maxlength="500" name="period" id="period_1">
                                        </td>
                                        <td style="width: 15%" class="text-center coder">
                                            <select class="form-select-sm select2" id="coder_1" name="coder" style="width: 100%">
                                                <option value="0">-- select --</option>
                                                @foreach($coder as $item)
                                                    @if($section_a[0]->level_coder == $item->id)
                                                        <option value="{{$item->id}}" selected>{{$item->name_kh}}</option>
                                                    @else
                                                        <option value="{{$item->id}}">{{$item->name_kh}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%" class="text-center">ខ <input type="hidden" value="{{$section_a[1]->id}}" id="section_a_id_2"></td>
                                        <td style="width: 45%">
                                            <input type="text" disabled class="form-control" value="{{$section_a[1]->death_reason}}" maxlength="500" name="reason" id="reason_2">
                                        </td>
                                        <td style="width: 15%">
                                            <input type="text" disabled class="form-control" value="{{$section_a[1]->period}}" maxlength="500" name="period" id="period_2">
                                        </td>
                                        <td style="width: 15%" class="text-center coder">
                                            <select class="form-select-sm select2" id="coder_2" name="coder" style="width: 100%">
                                                <option value="0">-- select --</option>
                                                @foreach($coder as $item)
                                                    @if($section_a[1]->level_coder == $item->id)
                                                        <option value="{{$item->id}}" selected>{{$item->name_kh}}</option>
                                                    @else
                                                        <option value="{{$item->id}}">{{$item->name_kh}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%" class="text-center">គ <input type="hidden" value="{{$section_a[2]->id}}" id="section_a_id_3"></td>
                                        <td style="width: 45%">
                                            <input type="text" disabled class="form-control" value="{{$section_a[2]->death_reason}}" maxlength="500" name="reason" id="reason_3">
                                        </td>
                                        <td style="width: 15%">
                                            <input type="text" disabled class="form-control" value="{{$section_a[2]->period}}" maxlength="500" name="period" id="period_3">
                                        </td>
                                        <td style="width: 15%" class="text-center coder">
                                            <select class="form-select-sm select2" id="coder_3" name="coder" style="width: 100%">
                                                <option value="0">-- select --</option>
                                                @foreach($coder as $item)
                                                    @if($section_a[2]->level_coder == $item->id)
                                                        <option value="{{$item->id}}" selected>{{$item->name_kh}}</option>
                                                    @else
                                                        <option value="{{$item->id}}">{{$item->name_kh}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%" class="text-center">ឃ <input type="hidden" value="{{$section_a[3]->id}}" id="section_a_id_4"></td>
                                        <td style="width: 45%">
                                            <input type="text" disabled class="form-control" value="{{$section_a[3]->death_reason}}" maxlength="500" name="reason" id="reason_4">
                                        </td>
                                        <td style="width: 15%">
                                            <input type="text" disabled class="form-control" value="{{$section_a[3]->period}}" maxlength="500" name="period" id="period_4">
                                        </td>
                                        <td style="width: 15%" class="text-center coder">
                                            <select class="form-select-sm select2" id="coder_4" name="coder" style="width: 100%">
                                                <option value="0">-- select --</option>
                                                @foreach($coder as $item)
                                                    @if($section_a[3]->level_coder == $item->id)
                                                        <option value="{{$item->id}}" selected>{{$item->name_kh}}</option>
                                                    @else
                                                        <option value="{{$item->id}}">{{$item->name_kh}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="frmAddNew" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$module[0]->module_name}} (បន្ថែមថ្មី)</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <input type="hidden" id="txtId" value="0" data-required="0">
                                <label>Name <span class="text-danger">(*)</span></label>
                                <input type="text" class="form-control" id="txtName" data-required="1">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Name KH <span class="text-danger">(*)</span></label>
                                <input type="text" class="form-control" id="txtNameKH" data-required="1">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label>Desc</label>
                                <input type="text" class="form-control" id="txtDesc" data-required="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="SaveCoder()"><i class="bx bxs-save"></i> Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bx bx-x"></i> Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var GtypeID= {{$type_id}};

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function clearForm(){
            $('#frmAddNew input').each(function(){
                $(this).val('');
            });
            $("#txtId").val(0);
        }
        function AddCoder(){
            clearForm();
            $("#frmAddNew").modal("show");
            $('#frmAddNew').on('shown.bs.modal', function () {
                $('#txtName').focus();
            })
        }

        function SaveCoder(){
            var Id = $("#txtId").val();
            var Name = $("#txtName").val();
            var NameKH = $("#txtNameKH").val();
            var Desc = $("#txtDesc").val();
            if(Name == ""){
                MSG.Validation("Please input name !!!");
            }
            else if(NameKH == ""){
                MSG.Validation("Please input name kh !!!");
            }
            else{
                $.ajax({
                    type:'POST',
                    url:"{{ route('coders.Save') }}",
                    data:{
                        id: Id,
                        name: Name,
                        name_kh: NameKH,
                        description: Desc
                    },
                    success:function(result){
                        console.log(result);
                        if(result.code == 0){
                            MSG.Success();
                            $("#frmAddNew").modal('hide');

                            var item = result.data;
                            $("#coder_1").append('<option value="'+item.id+'">'+item.name_kh+'</option>');
                            $("#coder_2").append('<option value="'+item.id+'">'+item.name_kh+'</option>');
                            $("#coder_3").append('<option value="'+item.id+'">'+item.name_kh+'</option>');
                            $("#coder_4").append('<option value="'+item.id+'">'+item.name_kh+'</option>');
                        }
                    }
                });
            }
        }
    </script>
    <script src="/assets/js/mccd.js"></script>
@endsection
