@extends('layouts.app')
@section('content')
    <style>
        #tblMedical td{
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
                    <li class="breadcrumb-item active" aria-current="page">{{$module[0]->module_name}} (បន្ថែមថ្មី)</li>
                </ol>
            </nav>
        </div>
    </div>
    <hr/>
    <div class="row">
        @foreach($death as $death)
        <div class="col-md-3">
            <label>លេខចេញ(មរណៈភាព): <b>{{$death->issue_no}}</b></label>
        </div>
        <div class="col-md-3">
            <label>ឈ្មោះមរណៈជន: <b>{{$death->deceased_name}}</b></label>
        </div>
        <div class="col-md-3">
            <label>ករណីស្លាប់: <b>{{$death->death_type}}</b></label>
        </div>
        <div class="col-md-3">
            <label>ព័ត៌មានមរណៈភាព: <b>{{$death->death_info}}</b></label>
        </div>
        @endforeach
    </div>
    <div class="row" style="padding-top: 20px; padding-bottom: 20px;">
        <div class="col-md-12">
            <ul class="nav nav-tabs nav-success" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#sectionA" role="tab" aria-selected="true">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon"><i class="bx bxs-book-open font-18 me-1"></i>
                            </div>
                            <div class="tab-title">ទម្រង់ ក៖ ទិន្នន័យវេជ្ជសាស្ត្រ៖ ផ្នែកទិ១ និងផ្នែកទី២</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#sectionB" role="tab" aria-selected="false">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon"><i class="bx bx-table font-18 me-1"></i>
                            </div>
                            <div class="tab-title">ទម្រង់ ក៖ ទិន្នន័យវេជ្ជសាស្ត្រដទៃទៀត</div>
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
                                        <td style="width: 45%">មូលហេតុនៃការស្លាប់</td>
                                        <td style="width: 15%">ចន្លោះពេល(ចាប់ពីពេលចាប់ផ្ដើម រហូតដល់ពេលស្លាប់)</td>
                                        <td style="width: 15%" class="text-center">Coder</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%" class="text-center">ក</td>
                                        <td style="width: 45%">
                                            <input type="text" class="form-control" maxlength="500" name="reason" id="reason_0">
                                        </td>
                                        <td style="width: 15%">
                                            <input type="text" class="form-control" maxlength="500" name="period" id="period_0">
                                        </td>
                                        <td style="width: 15%">
                                            <select class="form-select-sm" id="coder_0" name="coder" style="width: 100%">
                                                <option value="0">-- select --</option>
                                                @foreach($coder as $item)
                                                    <option value="{{$item->id}}">{{$item->name_kh}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%" class="text-center">ខ</td>
                                        <td style="width: 45%">
                                            <input type="text" class="form-control" maxlength="500" name="reason" id="reason_1">
                                        </td>
                                        <td style="width: 15%">
                                            <input type="text" class="form-control" maxlength="500" name="period" id="period_1">
                                        </td>
                                        <td style="width: 15%">
                                            <select class="form-select-sm" id="coder_1" name="coder" style="width: 100%">
                                                <option value="0">-- select --</option>
                                                @foreach($coder as $item)
                                                    <option value="{{$item->id}}">{{$item->name_kh}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%" class="text-center">គ</td>
                                        <td style="width: 45%">
                                            <input type="text" class="form-control" maxlength="500" name="reason" id="reason_2">
                                        </td>
                                        <td style="width: 15%">
                                            <input type="text" class="form-control" maxlength="500" name="period" id="period_2">
                                        </td>
                                        <td style="width: 15%">
                                            <select class="form-select-sm" id="coder_2" name="coder" style="width: 100%">
                                                <option value="0">-- select --</option>
                                                @foreach($coder as $item)
                                                    <option value="{{$item->id}}">{{$item->name_kh}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%" class="text-center">ឃ</td>
                                        <td style="width: 45%">
                                            <input type="text" class="form-control" maxlength="500" name="reason" id="reason_3">
                                        </td>
                                        <td style="width: 15%">
                                            <input type="text" class="form-control" maxlength="500" name="period" id="period_3">
                                        </td>
                                        <td style="width: 15%">
                                            <select class="form-select-sm" id="coder_3" name="coder" style="width: 100%">
                                                <option value="0">-- select --</option>
                                                @foreach($coder as $item)
                                                    <option value="{{$item->id}}">{{$item->name_kh}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="sectionB" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tblMedical">
                                    @foreach($data as $item)
                                        <tr>
                                            @if($item->levelId == 1)
{{--                                                <td colspan="2"><b>{!! $item->description_kh !!}</b></td>--}}
                                            @else
                                                @if($item->question_id == 11 || $item->question_id == 23)
                                                    <td colspan="2">
                                                        @if($item->answer_type == 1)
                                                            <input type="text" class="form-control" id="answer_{{$item->question_id}}" data-id="{{$item->question_id}}">
                                                        @elseif($item->answer_type == 2)

                                                                <?php
                                                                $setting_item = DB::table("setting_items as s")
                                                                    ->select("s.id","s.name","s.name_kh")
                                                                    ->where("s.type_id","=", $item->setting_type_id)
                                                                    ->get();
                                                                ?>
                                                            @foreach($setting_item as $setting_item)
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="chb_{{$item->question_id}}" id="chb_{{$setting_item->id}}_{{$item->question_id}}">
                                                                    <label class="form-check-label" name="chb_{{$item->question_id}}" for="chb_{{$setting_item->id}}_{{$item->question_id}}">{!! $setting_item->name_kh !!}</label>
                                                                </div>
                                                            @endforeach


                                                        @else
                                                            <input type="text" class="form-control datefield" id="answer_{{$item->question_id}}" data-id="{{$item->question_id}}" placeholder="YYYY-MM-DD">
                                                        @endif
                                                    </td>
                                                @else
                                                    <td>{!! $item->description_kh !!}</span></td>
                                                    <td>
                                                        @if($item->answer_type == 1)
                                                            <input type="text" class="form-control" data-id="{{$item->question_id}}">
                                                        @elseif($item->answer_type == 2)

                                                                <?php
                                                                $setting_item = DB::table("setting_items as s")
                                                                    ->select("s.id","s.name","s.name_kh")
                                                                    ->where("s.type_id","=", $item->setting_type_id)
                                                                    ->get();
                                                                ?>
                                                            @foreach($setting_item as $setting_item)
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" data-id="{{$item->question_id}}" name="chb_{{$item->question_id}}" id="chb_{{$setting_item->id}}_{{$item->question_id}}">
                                                                    <label class="form-check-label" name="chb_{{$item->question_id}}" for="chb_{{$setting_item->id}}_{{$item->question_id}}">{{$setting_item->name_kh}}</label>
                                                                </div>
                                                            @endforeach


                                                        @else
                                                            <input type="text" class="form-control datefield" data-id="{{$item->question_id}}" placeholder="YYYY-MM-DD">
                                                        @endif
                                                    </td>
                                                @endif

                                            @endif
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
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
            $(".select2").select2();

        })
    </script>

@endsection
