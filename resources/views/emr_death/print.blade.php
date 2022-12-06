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
        .big {
            font-size: 13pt;
            font-family: 'Khmer OS Muol Light';
            display: inline;
        }

        .small {
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
        .small_underline {
            font-size: 11pt;
            font-family: 'Hanuman';
            display: inline;
            text-decoration: underline;
        }
        .small_over {
            display: inline;
            position: absolute;
            z-index: 100;
            margin-top: 0px;
            font-size: 13pt;
            font-family: 'Hanuman';
        }
        .header {
            border-collapse: collapse;
            border-spacing: 0;
            line-height: 0
        }
        #tblBody td{
            border: 1px solid;
        }

        #tblBody {
            border: 1px solid;
            width: 100%;
            margin-top: 50px;
            border-collapse: collapse;
        }
    </style>
    <script>
        var _death_id = "{{$death_id}}";
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
                <td style="width:45%;text-align: center"><h2 style="font-size:13pt;font-family:'Khmer OS Muol';">លិខិតជូនដំណឹងមរណភាព</h2></td>
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
    <table style="width: 100%" class="header">
        <tbody>
            <tr>
                <td style="width:55%"></td>
                <td style="text-align:center;width:45%">
                    <p class="small">លេខចេញ៖ </p>
                </td>
            </tr>
        </tbody>
    </table>
    <table id="tblBody">
        <tr>
            <td style="width: 45%"><p class="small_bold">ឈ្មោះមូលដ្ឋានសុខាភិបាល</p><p class="small_bold" id="hf_name"></p></td>
            <td style="width: 15%"><p class="small">ស្លាប់ករណីធម្មតា</p><p class="small"></p></td>
            <td style="width: 40%"><p class="small_bold">លេខកូដមូលដ្ឋានសុខាភិបាល</p><p class="small_bold" id="hmis_code"></p></td>
        </tr>
    </table>
</div>
{{--<div style="width: 25cm; border: 1px solid #fff; margin: 0 auto !important; padding-left: 48px; padding-right: 48px; padding-bottom: 20px;">--}}

{{--    <div style="width:100%;text-align:right;"><p style="font-size:13pt;font-family:'Khmer OS Battambang';" id="fdate">រាជធានីភ្នំពេញថ្ងៃទី..02......ខែ...12.....ឆ្នាំ....2021............</p></div>--}}
{{--    <div style="width:100%;">--}}
{{--        <div style="width: 40%;float: left;"><p class="big">យល់ព្រមតម្កល់ទុកនៅការិយាល័យមេធាវី</p></div>--}}
{{--        <div style="width: 30%;float: left;text-align: center;"><p class="big">ស្នាមមេដៃអ្នកទិញ</p><br /><br /><br /><br /><br /><br /><br /><p class="small" id="sname">......................................</p></div>--}}
{{--        <div style="width: 30%;float: left;text-align: center;"><p class="big">ស្នាមមេដៃតំណាងអ្នកលក់</p><br /><br /><br /><br /><br /><br /><br /><p class="small">........</p><p class="big">ឃាវ សែលឹម </p><p class="small">..........</p></div>--}}
{{--    </div>--}}
{{--</div>--}}
</body>
</html>
