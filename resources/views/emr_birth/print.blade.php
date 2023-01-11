<!DOCTYPE html>
<html>
<head>
    <title>Print Birth Notification</title>
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
    </style>

</head>
<body>
<div id="divBody" style="border:1px solid #fff;margin:0 auto !important;">
    <table style="width: 100%" class="header">
        <tbody>
        <tr>
            <td style="width:10%;text-align: left" rowspan="2" colspan="3"><img src="/assets/images/MOH_logo.png" style="width: 80px"></td>
            <td style="width:45%;text-align: left"><h2 style="font-size:13pt;font-family:'Khmer OS Muol';">ព្រះរាជាណាចក្រកម្ពុជា</h2><br></td>
            <td style="width:45%;text-align: center"><h2 style="font-size:13pt;font-family:'Khmer OS Muol';">លិខិតជូនដំណឹងកំណើត</h2></td>
        </tr>
        <tr>
            <td style="width:45%;text-align: left">
                <h2 style="font-size:13pt;font-family:'Hanuman';">ជាតិ សាសនា ព្រះមហាក្សត្រ</h2>
            </td>
            <td style="width:45%;text-align: center">
                <h2 style="font-size:13pt;color:red;font-family:'Khmer OS Muol';">លេខតាមដានទម្រង់បោះពុម្ភឡើងវិញ</h2>
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
                    <p class="small">លេខចេញ៖ <p class="small_bold">{{$item1->birth_no}}</p></p>
                </td>
            </tr>
            </tbody>
        </table>
        <table id="tblBody">
            @foreach($hf_info as $item)
                <tr>
                    <td style="width: 40%" colspan="2"><p class="small">ឈ្មោះមូលដ្ឋានសុខាភិបាល៖ </p><p class="small_bold" id="hf_name">{{$item->hfac_namekh}}</p></td>
                    <td style="width: 20%">
                        @if($item1->abandoned == 1)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="abandoned_baby" checked aria-disabled="true">
                                <label class="form-check-label" for="abandoned_baby"><p class="small_bold">ទារកបោះបង់ចោល</p></label>
                            </div>
                        @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="abandoned_baby" disabled>
                                <label class="form-check-label" for="abandoned_baby"><p class="small_bold">ទារកបោះបង់ចោល</p></label>
                            </div>
                        @endif
                    </td>
                    <td style="width: 40%">
                        <p class="small">លេខកូដមូលដ្ឋានសុខាភិបាល(HMIS)៖ </p>
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
                <td style="width: 40%" colspan="2"><p class="small_bold">ព័ត៌មានកំណើត៖ </p>
                    @foreach($birth_info as $birth_info)
                        @if($birth_info->item_id == $item1->birth_info)
                            <input class="form-check-input" type="checkbox" checked id="chb_birth_type" aria-disabled="true">
                            <label class="form-check-label small" for="chb_birth_type">{{$birth_info->name_kh}}</label>
{{--                        @else--}}
{{--                            <input class="form-check-input" type="checkbox" id="chb_birth_type" disabled>--}}
{{--                            <label class="form-check-label small" for="chb_birth_type">{{$birth_info->name_kh}}</label>--}}
                        @endif
                    @endforeach
                </td>
                <td colspan="2" style="width: 60%"><p class="small_bold">ទីតាំងមូលដ្ឋានសុខាភិបាល៖ </p>
                    <p class="small">ឃុំ/សង្កាត់: <span class="small_bold"></span></p>
                    <p class="small">ស្រុក/ខណ្ឌ: <span class="small_bold">{{$item->od_name_kh}}</span></p>
                    <p class="small">រាជធានី/ខេត្ត: <span class="small_bold">{{$item->province_kh}}</span></p>
                </td>
            </tr>
        </table>
        <table class="tblBody2">
            <tr>
                <td style="width: 20%" rowspan="2">
                    <p class="small_bold">ឈ្មោះទារក៖ </p><br>
                    <span class="small_bold">{{$item1->baby_last_name}} {{$item1->baby_first_name}}</span>
                </td>
                <td style="width: 30%"><p class="small_bold">ប្រភេទកំណើត៖ </p>
                    @foreach($birth_type as $birth_type)
                        @if($birth_type->item_id == $item1->typeofbirth )
                            <input class="form-check-input" type="checkbox" checked id="chb_birth_type" aria-disabled="true">
                            <label class="form-check-label small" for="chb_birth_type">{{$birth_type->name_kh}}</label>
                            {{--                        @else--}}
                            {{--                            <input class="form-check-input" type="checkbox" id="chb_birth_type" disabled>--}}
                            {{--                            <label class="form-check-label small" for="chb_birth_type">{{$birth_type->name_kh}}</label>--}}
                        @endif
                    @endforeach
                </td>
                <td style="width: 20%"><p class="small_bold">អ្នកផ្ដល់សេវាសម្រាលកូន៖ </p>
                    @foreach($attendant_at_delivery as $attendant_at_delivery)
                        @if($attendant_at_delivery->item_id == $item1->Atdelivery)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" checked id="chb_at_delivery" aria-disabled="true">
                                <label class="form-check-label small" for="chb_at_delivery">{{$attendant_at_delivery->name_kh}}</label>
                            </div>
{{--                        @else--}}
{{--                            <div class="form-check">--}}
{{--                                <input class="form-check-input" type="checkbox" id="chb_at_delivery" disabled>--}}
{{--                                <label class="form-check-label small" for="chb_at_delivery">{{$attendant_at_delivery->name_kh}}</label>--}}
{{--                            </div>--}}
                        @endif
                    @endforeach
                </td>
                <td style="width: 30%">
                    <p class="small_bold">ថ្ងៃខែឆ្នាំកំណើត៖ </p><br>
                    <span class="small_bold">{{date('d-m-Y', strtotime($item1->dateofbirth ))}}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 30%"><p class="small_bold">ភេទ៖ </p>
                    @foreach($sex as $sex)
                        @if($sex->item_id == $item1->sex)
                            <input class="form-check-input" type="checkbox" checked id="chb_sex" aria-disabled="true">
                            <label class="form-check-label small" for="chb_sex">{{$sex->name_kh}}</label>
                            {{--                        @else--}}
                            {{--                            <input class="form-check-input" type="checkbox" id="chb_sex" disabled>--}}
                            {{--                            <label class="form-check-label small" for="chb_sex">{{$sex->name_kh}}</label>--}}
                        @endif
                    @endforeach
                </td>
                <td style="width: 20%">
                    <p class="small_bold">ទម្ងន់ទារក(គិតជាក្រាម)៖ </p>
                    <span class="small_bold">{{$item1->baby_weight}}</span>
                </td>
                <td style="width: 30%"><p class="small_bold">ម៉ោងកើត៖ </p><br>
                    <span class="small_bold">{{$item1->time_of_birth}}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 20%">
                    <p class="small">ឈ្មោះម្ដាយ៖ </p><br>
                    <span class="small_bold">{{$item1->mothername}}</span>
                </td>
                <td style="width: 30%">
                    <p class="small">ថ្ងៃខែឆ្នាំ-កំណើត(ម្ដាយ)៖ </p>
                    <span class="small_bold">{{date('d-m-Y', strtotime($item1->motherdofbirth))}}</span><br>
                    <span class="small">អាយុ៖ <span class="small_bold">{{$item1->motherage}}ឆ្នាំ</span></span>
                </td>
                <td style="width: 20%">
                    <p class="small">ឈ្មោះឪពុក៖ </p><br>
                    <span class="small_bold">{{$item1->mothername}}</span>
                </td>
                <td style="width: 30%">
                    <p class="small">ថ្ងៃខែឆ្នាំ-កំណើត(ឪពុក)៖ </p>
                    <span class="small_bold">{{date('d-m-Y', strtotime($item1->motherdofbirth))}}</span><br>
                    <span class="small">អាយុ៖ <span class="small_bold"> {{$item1->fatherage}}ឆ្នាំ</span></span>
                </td>
            </tr>
        </table>
        <table class="tblBody2">
            <tr>
                <td style="width: 35%;text-align: center;">
                    <label class="small_bold">ចំនួនកូនកើតរស់ (មកទល់បច្ចុប្បន្ន)៖</label> <br><br>
                    <label class="small_bold">{{$item1->numofchildalive}} នាក់</label>
                </td>
                <td style="width: 65%">
                    <label class="small_bold">អត្តលេខសំណុំឯកសារសេវាសម្រាលកូន៖</label><br><br>
                    <div>
                        @foreach(str_split($item1->medicalid) as $value)
                            <span style="border: solid 1px black;width:20px;height: 30px;display: inline-block;
                        background-color: white;padding-left:10px;padding-top: 15px;font-weight: bold;">
                            {{$value}}
                        </span>
                        @endforeach
                        <br><br>
                        <p class="smallest" style="font-style: italic">ប្រសិនបើគ្មាន សូមបំពេញ អត្តលេខអ្នកជំងឺ ឬអត្តលេខ PMRS(របស់ម្ដាយសម្រាប់ទារកទើបតែកើត)</p>
                    </div>
                </td>
            </tr>
        </table>
        <table class="tblBody2">
            <tr>
                <td style="width: 100%">
                    <p class="small_bold">ទីលំនៅប្រក្រតីរបស់ម្ដាយទារក៖
                    </p>
                    <span class="small">ផ្ទះលេខ៖<span class="small_bold"> {{$item1->mHouse}}</span></span>
                    <span class="small">ផ្លូវ៖<span class="small_bold"> {{$item1->mStreet}}</span></span>
                    <span class="small">ភូមិ៖<span class="small_bold"> {{$item1->mVCode}}</span></span>
                    <span class="small">ឃុំ/សង្កាត់៖<span class="small_bold"> {{$item1->mCCode}}</span></span>
                    <span class="small">ក្រុង/ស្រុក/ខណ្ឌ៖<span class="small_bold"> {{$item1->mDCode}}</span></span>
                    <span class="small">រាជធានី/ខេត្ត៖<span class="small_bold"> {{$item1->mPCode}}</span></span>
                </td>
            </tr>
        </table>
    @endforeach
    <table style="width: 100%">
        <tr>
            <td colspan="3" style="text-align: left;width: 100%">
                <br>
                <p class="small_bold">
                    ទម្រង់បានចេញនៅ៖
                </p><br>
                <p class="small">
                    កាលបរិច្ឆទជាអក្សរខ្មែរ៖
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left;width: 70%">
            </td>
            <td style="text-align: left;width: 30%">
                <p class="small">
                    កាលបរិច្ឆេទ (ថ្ងៃ/ខែ/ឆ្នាំ)៖
                </p><br>
                <p class="small">
                    ឈ្មោះគ្រូពេទ្យ៖
                </p><br>
                <p class="small">
                    ហេត្ថលេខ៖
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: left;width: 100%">
                <br>
                <p class="small_bold">
                    បានឃើញ និង ឯកភាព
                </p><br>
                <p class="small">
                    នាយកមន្ទីរពេទ្យ៖
                </p>
                <p class="small"><br>
                    ហត្ថលេខនាយកមន្ទីរពេទ្យ៖
                </p>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
