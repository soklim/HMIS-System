<!DOCTYPE html>
<html>
<head>
    <title>Print Death Notification</title>
    <meta name="viewport" content="width=device-width" />
    <script src="/assets/js/jquery.min.js"></script>
    <link rel="icon" href="/assets/images/logo.png" type="image/png" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Hanuman&display=swap');
    </style>
    <style type="text/css">

        @page {
            size: A4;
            margin-left: 10px;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                width: 210mm;
                height: 297mm;
            }
        }

        #divBody {
            width: 210mm;
        }

        .small {
            font-size: 10pt;
            font-family: 'Hanuman';
            display: inline;
        }
        .smallest {
            font-size: 10pt;
            font-family: 'Hanuman';
            display: inline;
        }
        .small_bold {
            font-size: 10pt;
            font-family: 'Hanuman';
            display: inline;
            font-weight: bold;
        }

        .header {
            border-collapse: collapse;
            border-spacing: 0;
            line-height: 0
        }
        #tblBody td{
            border: 1px solid;
            padding: 5px;
        }

        #tblBody {
            border: 1px solid;
            width: 100%;
            margin-top: 50px;
            border-collapse: collapse;
        }
        .tblBody2 td{
            border: 1px solid;
            padding: 5px;
        }

        .tblBody2 {
            border: 1px solid;
            width: 100%;
            border-collapse: collapse;
        }

        input[type="checkbox"][aria-disabled="true"] {
            background-color: blue;
            pointer-events: none;
        }

        label[aria-disabled="true"] {
            pointer-events: none;
        }
    </style>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {

        });

    </script>
</head>
<body>
<div id="divBody" style="border:1px solid #fff;margin:0 auto !important;">
    <table style="width: 100%" class="header">
        <tbody>
            <tr>
                <td style="width:10%;text-align: left" rowspan="2" colspan="3"><img src="/assets/images/MOH_logo.png" style="width: 80px"></td>
                <td style="width:45%;text-align: left"><h2 style="font-size:13pt;font-family:'Khmer OS Muol';">???????????????????????????????????????????????????????????????</h2><br></td>
                <td style="width:45%;text-align: center"><h2 style="font-size:13pt;font-family:'Khmer OS Muol';">?????????????????????????????????????????????????????????</h2></td>
            </tr>
            <tr>
                <td style="width:45%;text-align: left">
                    <h2 style="font-size:13pt;font-family:'Hanuman';">???????????? ??????????????? ???????????????????????????????????????</h2>
                </td>
                <td style="width:45%;text-align: center">
                    <h2 style="font-size:13pt;color:red;font-family:'Khmer OS Muol';">???????????????????????????????????????????????????????????????????????????????????????</h2>
                </td>
            </tr>

        </tbody>
    </table>
    @foreach($data as $item1)
    <table style="width: 100%" class="header">
        <tbody>
            <tr>
                <td style="width:55%"></td>
                <td style="text-align:center;width:45%">
                    <p class="small">????????????????????? <p class="small_bold">{{$item1->issue_no}}</p></p>
                </td>
            </tr>
        </tbody>
    </table>
    <table id="tblBody">
        @foreach($hf_info as $item)
        <tr>
            <td style="width: 40%"><p class="small_bold">????????????????????????????????????????????????????????????????????? </p><p class="small_bold" id="hf_name">{{$item->hfac_namekh}}</p></td>
            <td style="width: 20%">
                @foreach($death_type as $death_type)
                    @if($death_type->id == $item1->death_type)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" aria-disabled="true" checked id="chb_death_type">
                            <label class="form-check-label small" aria-disabled="true" for="chb_death_type">{{$death_type->text}}</label>
                        </div>
{{--                    @else--}}
{{--                        <div class="form-check">--}}
{{--                            <input class="form-check-input" type="checkbox" id="chb_death_type" disabled>--}}
{{--                            <label class="form-check-label small" for="chb_death_type">{{$death_type->text}}</label>--}}
{{--                        </div>--}}
                    @endif
                @endforeach
            </td>
            <td style="width: 40%" colspan="2">
                <p class="small_bold">?????????????????????????????????????????????????????????????????????(HMIS)??? </p>
                @foreach(str_split($item->hfac_label) as $value)
                    <span style="border: solid 1px black;width:12px;height: 16px;display: inline-block;
                        background-color: white;padding-left:3px;padding-top: 5px;font-weight: bold;">
                            {{$value}}
                        </span>
                @endforeach
            </td>
        </tr>
        @endforeach
        <tr>
            <td style="width: 40%"><p class="small_bold">?????????????????????????????????????????? </p>
                @foreach($death_info as $death_info)
                    @if($death_info->id == $item1->death_info)
                        <input class="form-check-input" type="checkbox" aria-disabled="true" checked id="chb_death_info">
                        <label class="form-check-label small" aria-disabled="true" for="chb_death_info">{{$death_info->text}}</label>
{{--                    @else--}}
{{--                        <input class="form-check-input" type="checkbox" id="chb_death_type" disabled>--}}
{{--                        <label class="form-check-label small" for="chb_death_type">{{$death_info->text}}</label>--}}
                    @endif
                @endforeach
            </td>
            <td colspan="3" style="width: 60%"><p class="small_bold">???????????????????????????????????????????????????????????????????????? </p>
                <p class="small">?????????/?????????????????????: <span class="small_bold"></span></p>
                <p class="small">???????????????/????????????: <span class="small_bold">{{$item->od_name_kh}}</span></p>
                <p class="small">?????????????????????/???????????????: <span class="small_bold">{{$item->province_kh}}</span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 40%">
                <p class="small_bold">???????????????????????????????????? </p>
                <span class="small_bold">{{$item1->deceased_name}}</span>
                <br><br><br>
                <p class="smallest">????????????????????????????????????????????????????????????????????????????????? ??????????????????????????????????????? ???????????????????????? ????????????????????? "??????????????????????????????"</p>
            </td>
            <td style="width: 40%" colspan="2"><p class="small_bold">??????????????????????????????????????????????????? </p>
                @if($item1->date_of_birth != "")
                    <span class="small_bold">{{date('d-m-Y', strtotime($item1->date_of_birth))}}</span>
                @endif
                <br><br><br>
                <p class="small_bold">??????????????? <span class="small_bold">{{$item1->age}} {{$item1->age_type_name}}</span></p>
            </td>
            <td style="width: 20%"><p class="small_bold">???????????? </p>
                @foreach($sex as $sex)
                    @if($sex->id == $item1->sex)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" aria-disabled="true" checked id="chb_sex">
                            <label class="form-check-label small" aria-disabled="true" for="chb_sex">{{$sex->text}}</label>
                        </div>
{{--                    @else--}}
{{--                        <div class="form-check">--}}
{{--                            <input class="form-check-input" type="checkbox" id="chb_sex" disabled>--}}
{{--                            <label class="form-check-label small" for="chb_death_type">{{$sex->text}}</label>--}}
{{--                        </div>--}}
                    @endif
                @endforeach
            </td>
        </tr>
        <tr>
            <td style="width: 40%">
                <p class="small_bold">??????????????????????????????????????????????????????</p><br>
                <div>
                    @foreach(str_split($item1->medical_file_id) as $value)
                        <span style="border: solid 1px black;width:20px;height: 30px;display: inline-block;
                        background-color: white;padding-left:10px;padding-top: 15px;font-weight: bold;">
                            {{$value}}
                        </span>
                    @endforeach

                    <br><br><br>
                    <p class="smallest" style="font-style: italic">??????????????????????????????????????? ???????????????????????? ????????????????????????????????????????????? ???????????????????????? PMRS(????????????????????????????????????????????????????????????????????????????????????)</p>
                </div>
            <td style="width: 40%" colspan="2">
                <p class="small_bold">????????????????????????????????????????????????????????? </p>
                <span class="small_bold">{{date('d-m-Y', strtotime($item1->date_of_death))}}</span>
                <br><br><br>
                <p class="small_bold">????????????????????????????????????????????? </p>
                <span class="small_bold">{{$item1->time_of_death}}</span>
            </td>
            <td style="width: 20%"><p class="small_bold">???????????????????????????????????????????????? </p>
                @foreach($married_status as $married_status)
                    @if($married_status->id == $item1->married_status)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" aria-disabled="true" checked id="chb_married">
                            <label class="form-check-label small" aria-disabled="true" for="chb_married">{{$married_status->text}}</label>
                        </div>
{{--                    @else--}}
{{--                        <div class="form-check">--}}
{{--                            <input class="form-check-input" type="checkbox" id="chb_sex" disabled>--}}
{{--                            <label class="form-check-label small" for="chb_death_type">{{$married_status->text}}</label>--}}
{{--                        </div>--}}
                    @endif
                @endforeach
            </td>
        </tr>
        <tr>
            <td colspan="4" style="width: 100%">
                <p class="small_bold">???????????????????????????????????????????????????????????????????????????????????? (?????????????????????????????????????????????????????????????????????????????????)???

                </p>
                <span class="small">????????????????????????<span class="small_bold"> {{$item1->deceased_house}}</span></span>
                <span class="small">??????????????????<span class="small_bold"> {{$item1->deceased_street}}</span></span>
                <span class="small">???????????????<span class="small_bold"> {{$item1->deceased_village}}</span></span>
                <span class="small">?????????/????????????????????????<span class="small_bold"> {{$item1->deceased_commune_code}}</span></span>
                <span class="small">???????????????/???????????????/???????????????<span class="small_bold"> {{$item1->deceased_district_code}}</span></span>
                <span class="small">?????????????????????/??????????????????<span class="small_bold"> {{$item1->deceased_province_code}}</span></span>
            </td>
        </tr>
    </table>
    @endforeach
    <table style="width: 100%">
        <tr>
            <td colspan="3" style="text-align: center;width: 100%">
                <p class="small">
                    ?????????????????????????????? ?????????????????????????????????????????????????????????????????? ????????????????????????????????????????????? ?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????? ??????????????????????????????????????????????????????????????????????????????????????????????????????????????????
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: left;width: 100%">
                <br><br>
                <p class="small_bold">
                    ?????????????????????????????????????????????
                </p><br>
                <p class="small">
                    ?????????????????????????????????????????????????????????????????????
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left;width: 70%">
            </td>
            <td style="text-align: left;width: 30%">
                <p class="small">
                    ????????????????????????????????? (????????????/??????/???????????????)???
                </p><br>
                <p class="small">
                    ?????????????????????????????????????????????
                </p><br>
                <p class="small">
                    ???????????????????????????
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: left;width: 100%">
                <br>
                <p class="small_bold">
                    ?????????????????? ????????? ???????????????
                </p><br>
                <p class="small">
                    ????????????????????????????????????????????????
                </p>
                <p class="small"><br>
                    ?????????????????????????????????????????????????????????????????????
                </p>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
