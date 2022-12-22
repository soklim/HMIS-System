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

        .small {
            font-size: 13pt;
            font-family: 'Hanuman';
            display: inline;
        }
        .smallest {
            font-size: 10pt;
            font-family: 'Hanuman';
            display: inline;
        }
        .small_bold {
            font-size: 13pt;
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

        input[type='checkbox'] {
            accent-color: blue;
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
<div style="width:25cm;border:1px solid #fff;margin:0 auto !important;padding-left:48px;padding-right:48px;padding-bottom:20px;">
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
                    <td style="width: 40%" colspan="2"><p class="small_bold">ឈ្មោះមូលដ្ឋានសុខាភិបាល៖ </p><p class="small_bold" id="hf_name">{{$item->hfac_namekh}}</p></td>
                    <td style="width: 20%">
                        @if($item1->abandoned == 1)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="abandoned_baby" checked disabled>
                                <label class="form-check-label" for="abandoned_baby"><p class="small_bold">បោះបង់ចោល</p></label>
                            </div>
                        @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="abandoned_baby" disabled>
                                <label class="form-check-label" for="abandoned_baby"><p class="small_bold">បោះបង់ចោល</p></label>
                            </div>
                        @endif
                    </td>
                    <td style="width: 40%">
                        <p class="small_bold">លេខកូដមូលដ្ឋានសុខាភិបាល(HMIS)៖ </p>
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
                            <input class="form-check-input" type="checkbox" checked id="chb_birth_type" disabled>
                            <label class="form-check-label small" for="chb_birth_type">{{$birth_info->name_kh}}</label>
                        @else
                            <input class="form-check-input" type="checkbox" id="chb_birth_type" disabled>
                            <label class="form-check-label small" for="chb_birth_type">{{$birth_info->name_kh}}</label>
                        @endif
                    @endforeach
                </td>
                <td colspan="2" style="width: 60%"><p class="small_bold">ទីតាំងមូលដ្ឋានសុខាភិបាល៖ </p>
                    <p class="small">ឃុំ/សង្កាត់: <span class="small_bold"></span></p>
                    <p class="small">ស្រុក/ខណ្ឌ: <span class="small_bold">{{$item->od_name_kh}}</span></p>
                    <p class="small">រាជធានី/ខេត្ត: <span class="small_bold">{{$item->province_kh}}</span></p>
                </td>
            </tr>
            <tr>
                <td style="width: 30%" rowspan="2">
                    <p class="small_bold">ឈ្មោះទារក៖ </p>
                    <span class="small_bold">{{$item1->babyname}}</span>
                </td>
                <td style="width: 20%"><p class="small_bold">ប្រភេទកំណើត៖ </p>
                    @foreach($birth_type as $birth_type)
                        @if($birth_type->item_id == $item1->typeofbirth )
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" checked id="chb_birth_type" disabled>
                                <label class="form-check-label small" for="chb_birth_type">{{$birth_type->name_kh}}</label>
                            </div><br>
                        @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chb_birth_type" disabled>
                                <label class="form-check-label small" for="chb_birth_type">{{$birth_type->name_kh}}</label>
                            </div><br>
                        @endif
                    @endforeach
                </td>
                <td style="width: 20%"><p class="small_bold">សម្រាលដោយ៖ </p>
                    @foreach($attendant_at_delivery as $attendant_at_delivery)
                        @if($attendant_at_delivery->item_id == $item1->Atdelivery)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" checked id="chb_at_delivery" disabled>
                                <label class="form-check-label small" for="chb_at_delivery">{{$attendant_at_delivery->name_kh}}</label>
                            </div>
                        @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chb_at_delivery" disabled>
                                <label class="form-check-label small" for="chb_at_delivery">{{$attendant_at_delivery->name_kh}}</label>
                            </div>
                        @endif
                    @endforeach
                </td>
                <td style="width: 30%">
                    <p class="small_bold">ថ្ងៃខែឆ្នាំ កំណើត៖ </p>
                    <span class="small_bold">{{date('d-m-Y', strtotime($item1->dateofbirth ))}}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 20%"><p class="small_bold">ភេទ៖ </p>
                    @foreach($sex as $sex)
                        @if($sex->item_id == $item1->sex)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" checked id="chb_sex" disabled>
                                <label class="form-check-label small" for="chb_sex">{{$sex->name_kh}}</label>
                            </div>
                        @else
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="chb_sex" disabled>
                                <label class="form-check-label small" for="chb_sex">{{$sex->name_kh}}</label>
                            </div>
                        @endif
                    @endforeach
                </td>
                <td style="width: 20%">
                    <p class="small_bold">ទម្ងន់ទារក(គិតជាគីឡូ និងក្រាម)៖ </p>
                    <span class="small_bold">3kg</span>
                </td>
                <td style="width: 30%"><p class="small_bold">ម៉ោងកើត៖ </p>
                    <span class="small_bold">{{$item1->time_of_birth}}</span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%">
                    <p class="small_bold">ឈ្មោះម្ដាយ៖ </p>
                    <span class="small_bold">{{$item1->mothername}}</span>
                </td>
                <td style="width: 25%">
                    <p class="small_bold">ថ្ងៃខែឆ្នាំ-កំណើត(ម្ដាយ)៖ </p>
                    <span class="small_bold">{{date('d-m-Y', strtotime($item1->motherdofbirth))}}</span>
                </td>
                <td style="width: 25%">
                    <p class="small_bold">ឈ្មោះឪពុក៖ </p>
                    <span class="small_bold">{{$item1->mothername}}</span>
                </td>
                <td style="width: 25%">
                    <p class="small_bold">ថ្ងៃខែឆ្នាំ-កំណើត(ម្ដាយ)៖ </p>
                    <span class="small_bold">{{date('d-m-Y', strtotime($item1->motherdofbirth))}}</span>
                </td>
            </tr>
{{--            <tr>--}}
{{--                <td style="width: 40%">--}}
{{--                    <p class="small_bold">អត្តលេខឯកសារពេទ្យ៖</p><br>--}}
{{--                    <div>--}}
{{--                        @foreach(str_split($item1->medical_file_id) as $value)--}}
{{--                            <span style="border: solid 1px black;width:20px;height: 30px;display: inline-block;--}}
{{--                        background-color: white;padding-left:10px;padding-top: 15px;font-weight: bold;">--}}
{{--                            {{$value}}--}}
{{--                        </span>--}}
{{--                        @endforeach--}}

{{--                        <br><br><br>--}}
{{--                        <p class="smallest" style="font-style: italic">ប្រសិនបើគ្មាន សូមបំពេញ អត្តលេខអ្នកជំងឺ ឬអត្តលេខ PMRS(របស់ម្ដាយសម្រាប់ទារកទើបតែកើត)</p>--}}
{{--                    </div>--}}
{{--                <td style="width: 40%" colspan="2">--}}
{{--                    <p class="small_bold">ថ្ងៃខែឆ្នាំមរណភាព៖ </p>--}}
{{--                    <span class="small_bold">{{date('d-m-Y', strtotime($item1->date_of_death))}}</span>--}}
{{--                    <br><br><br>--}}
{{--                    <p class="small_bold">ពេលវេលាមរណភាព៖ </p>--}}
{{--                    <span class="small_bold">{{$item1->time_of_death}}</span>--}}
{{--                </td>--}}
{{--                <td style="width: 20%"><p class="small_bold">ស្ថានភាពគ្រួសារ៖ </p>--}}
{{--                    @foreach($married_status as $married_status)--}}
{{--                        @if($married_status->id == $item1->married_status)--}}
{{--                            <div class="form-check">--}}
{{--                                <input class="form-check-input" type="checkbox" checked id="chb_sex" disabled>--}}
{{--                                <label class="form-check-label small" for="chb_death_type">{{$married_status->text}}</label>--}}
{{--                            </div>--}}
{{--                        @else--}}
{{--                            <div class="form-check">--}}
{{--                                <input class="form-check-input" type="checkbox" id="chb_sex" disabled>--}}
{{--                                <label class="form-check-label small" for="chb_death_type">{{$married_status->text}}</label>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                </td>--}}
{{--            </tr>--}}
            <tr>
                <td colspan="4" style="width: 100%">
                    <p class="small_bold">ទីលំនៅប្រក្រតីរបស់អ្នកស្លាប់ (ឬទីលំនៅរបស់ម្ដាយមរណជនជាទារក)៖

                    </p>
                    <span class="small">ផ្ទះលេខ៖<span class="small_bold"> {{$item1->mHouse}}</span></span>
                    <span class="small">ផ្លូវ៖<span class="small_bold"> {{$item1->mStreet}}</span></span>
                    <span class="small">ភូមិ៖<span class="small_bold"> {{$item1->mVCode}}</span></span>
                    <span class="small">ឃុំ/សង្កាត៖<span class="small_bold"> {{$item1->mCCode}}</span></span>
                    <span class="small">ក្រុង/ស្រុក/ខណ្ឌ៖<span class="small_bold"> {{$item1->mDCode}}</span></span>
                    <span class="small">រាជធានី/ខេត្ត៖<span class="small_bold"> {{$item1->mPCode}}</span></span>
                </td>
            </tr>
        </table>
    @endforeach
    <table style="width: 100%">
        <tr>
            <td colspan="3" style="text-align: center;width: 100%">
                <p class="small">
                    សូមកាត់ចេញ មុនពេលបំពេញកាលបរិច្ឆេទ និងចុះហត្ថលេខា។ សូមផ្ដល់សំណៅចម្លងនៃទម្រង់ដែលបានចុះហត្ថលេខា និងចុះកាលបរិច្ឆេទរួចទៅកាន់គ្រួសារនៃសព។
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: left;width: 100%">
                <br><br>
                <p class="small_bold">
                    ទម្រង់បានចេញនៅ៖
                </p><br><br>
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
                </p><br><br>
                <p class="small">
                    ឈ្មោះគ្រូពេទ្យ៖
                </p><br><br>
                <p class="small">
                    ហេត្ថលេខ៖
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: left;width: 100%">
                <br><br>
                <p class="small_bold">
                    បានឃើញ និង ឯកភាព
                </p><br><br>
                <p class="small">
                    នាយកមន្ទីរពេទ្យ៖
                </p>
                <p class="small"><br><br>
                    ហត្ថលេខនាយកមន្ទីរពេទ្យ៖
                </p>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
