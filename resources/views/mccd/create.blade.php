@extends('layouts.app')
@section('content')
    <style>

        #tblMedical td{
            border: solid 1px black;
        }
    </style>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Transactions</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">MCCD Notification (Create)</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group mb-3">
                <label>អ្នកស្លាប់</label><br>
                <select class="form-select select2" id="death_id">
                    <option value="0">-- select --</option>
                    @foreach($death as $death)
                        <option value="{{$death->death_id}}">{{$death->issue_no}}-{{$death->deceased_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row" style="padding-top: 20px; padding-bottom: 20px;">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="tblMedical">
                    @foreach($data as $item)
                        <tr>
                            @if($item->levelId == 1)
                                <td colspan="2"><b>{!! $item->description_kh !!}</b></td>
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
