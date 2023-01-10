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
        .coder{
            display: none;
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
        <div class="col-md-5"></div>
        <div class="col-md-2" style="text-align: center;">
            <button class="btn btn-success" type="button" id="btnSave" style="width: 100%; border-radius: 18px;font-size: 16px">
                <i class="bx bxs-save"></i> រក្សាទុក
            </button>
        </div>
        <div class="col-md-5"></div>
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
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#sectionB" role="tab" aria-selected="false">
                        <div class="d-flex align-items-center">
                            <div class="tab-icon"><i class="bx bx-table font-18 me-1"></i>
                            </div>
                            <div class="tab-title">ទម្រង់ ខ៖ ទិន្នន័យវេជ្ជសាស្ត្រដទៃទៀត</div>
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
                                        <td style="width: 15%" class="text-center coder">Coder</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 5%" class="text-center">ក</td>
                                        <td style="width: 45%">
                                            <input type="text" class="form-control" value="{{$section_a[0]->death_reason}}" maxlength="500" name="reason" id="reason_1">
                                        </td>
                                        <td style="width: 15%">
                                            <input type="text" class="form-control" value="{{$section_a[0]->period}}" maxlength="500" name="period" id="period_1">
                                        </td>
                                        <td style="width: 15%" class="text-center coder">
                                            <select class="form-select-sm" id="coder_1" name="coder" style="width: 100%">
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
                                            <input type="text" class="form-control" value="{{$section_a[1]->death_reason}}" maxlength="500" name="reason" id="reason_2">
                                        </td>
                                        <td style="width: 15%">
                                            <input type="text" class="form-control" value="{{$section_a[1]->period}}" maxlength="500" name="period" id="period_2">
                                        </td>
                                        <td style="width: 15%" class="text-center coder">
                                            <select class="form-select-sm" id="coder_2" name="coder" style="width: 100%">
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
                                            <input type="text" class="form-control" value="{{$section_a[2]->death_reason}}" maxlength="500" name="reason" id="reason_3">
                                        </td>
                                        <td style="width: 15%">
                                            <input type="text" class="form-control" value="{{$section_a[2]->period}}" maxlength="500" name="period" id="period_3">
                                        </td>
                                        <td style="width: 15%" class="text-center coder">
                                            <select class="form-select-sm" id="coder_3" name="coder" style="width: 100%">
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
                                            <input type="text" class="form-control" value="{{$section_a[3]->death_reason}}" maxlength="500" name="reason" id="reason_4">
                                        </td>
                                        <td style="width: 15%">
                                            <input type="text" class="form-control" value="{{$section_a[3]->period}}" maxlength="500" name="period" id="period_4">
                                        </td>
                                        <td style="width: 15%" class="text-center coder">
                                            <select class="form-select-sm" id="coder_4" name="coder" style="width: 100%">
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
                                    <thead>
                                    <tr>
                                        <th class="text-center">ល.រ</th>
                                        <th class="text-center">កម្រងសំណួរ</th>
                                        <th class="text-center">ចម្លើយ</th>
                                    </tr>
                                    </thead>
                                    <tbody id="bodyMedical">
                                    <?php
                                    $index=0;
                                    ?>
                                    @foreach($section_b as $item)
                                            <?php
                                            $index++;
                                            ?>
                                        <tr id="tr_{{$index}}">
                                            <td class="text-center">{{$index}}</td>
                                            @if($index == 11 || $index == 34)
                                            @else
                                                @if($item->required == 1)
                                                    <td>{!! $item->description_kh !!}</span> <span class="text-danger">(*)</span> <i class="bx bx-info-circle text-warning" style="display: none"></i></td>
                                                @else
                                                    <td>{!! $item->description_kh !!}</span></td>
                                                @endif
                                            @endif
                                            <td @if($index == 11 || $index == 34) colspan="2" @endif>
                                                @if($item->answer_type == 1)
                                                    <input type="text" class="form-control" id="answer_{{$index}}" name="answer_{{$index}}" data-id="{{$item->question_id}}" value="{{$item->answer}}" @if($item->required == 1) data-required="1" @else data-required="0" @endif>
                                                @elseif($item->answer_type == 2)
                                                        <?php
                                                        $setting_item = DB::table("setting_items as s")
                                                            ->select("s.item_id as id","s.name","s.name_kh")
                                                            ->where("s.type_id","=", $item->setting_type_id)
                                                            ->get();
                                                        ?>
                                                    @foreach($setting_item as $setting_item)
                                                        @if($item->answer == $setting_item->id)
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" checked data-id="{{$item->question_id}}" value="{{$setting_item->id}}" @if($item->required == 1) data-required="1" @else data-required="0" @endif name="answer_{{$index}}" id="answer_{{$setting_item->id}}_{{$index}}">
                                                                <label class="form-check-label" name="answer_{{$index}}" for="answer_{{$setting_item->id}}_{{$index}}">{!! $setting_item->name_kh !!}</label>
                                                            </div>
                                                        @else
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" data-id="{{$item->question_id}}" value="{{$setting_item->id}}" @if($item->required == 1) data-required="1" @else data-required="0" @endif name="answer_{{$index}}" id="answer_{{$setting_item->id}}_{{$index}}">
                                                                <label class="form-check-label" name="answer_{{$index}}" for="answer_{{$setting_item->id}}_{{$index}}">{!! $setting_item->name_kh !!}</label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @elseif($item->answer_type == 3)
                                                    @if($item->answer != "")
                                                        <input type="text" class="form-control datefield" id="answer_{{$index}}" name="answer_{{$index}}" value="{{date('d-m-Y', strtotime($item->answer))}}" data-id="{{$item->question_id}}" @if($item->required == 1) data-required="1" @else data-required="0" @endif placeholder="DD-MM-YYYY">
                                                    @else
                                                        <input type="text" class="form-control datefield" id="answer_{{$index}}" name="answer_{{$index}}" data-id="{{$item->question_id}}" @if($item->required == 1) data-required="1" @else data-required="0" @endif placeholder="DD-MM-YYYY">
                                                    @endif
                                                @else
                                                    @if($index == 15)
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="answer_{{$index}}" value="{{$item->answer}}" name="answer_{{$index}}" data-id="{{$item->question_id}}" @if($item->required == 1) data-required="1" @else data-required="0" @endif>
                                                            <button type="button" class="btn btn-secondary">ក្រាម</button>
                                                        </div>
                                                    @elseif($index == 16)
                                                        <div class="input-group">
                                                            <input type="number" class="form-control" id="answer_{{$index}}" value="{{$item->answer}}" name="answer_{{$index}}" data-id="{{$item->question_id}}" @if($item->required == 1) data-required="1" @else data-required="0" @endif>
                                                            <button type="button" class="btn btn-secondary">សប្ដាហ៍</button>
                                                        </div>
                                                    @else
                                                        <input type="number" class="form-control" id="answer_{{$index}}" value="{{$item->answer}}" name="answer_{{$index}}" data-id="{{$item->question_id}}" @if($item->required == 1) data-required="1" @else data-required="0" @endif>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
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
    </script>
    <script src="/assets/js/mccd.js"></script>
@endsection
