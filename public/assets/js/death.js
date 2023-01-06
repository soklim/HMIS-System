$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function (){
    $(".datefield").pickadate({
        selectMonths: true,
        selectYears: true,
        format: 'dd-mm-yyyy',
        hiddenName: true
    });

    $('.timefield').bootstrapMaterialDatePicker({
        date: false,
        format: 'HH:mm'
    });

    $(".select2").select2();

    $("#txtCheckAge").trigger("change");

    $("#deceased_name").focus(function() {
        if($("#deceased_name").val() == ""){
            $("#deceased_name").val("គ្មាន");
        }
    });

    $("#deceased_name").focusout(function() {
        if($("#deceased_name").val() == "គ្មាន"){
            $("#deceased_name").val("");
        }
    });

    $("#deceased_street").focus(function() {
        if($("#deceased_street").val() == ""){
            $("#deceased_street").val("គ្មាន");
        }
    });

    $("#deceased_street").focusout(function() {
        if($("#deceased_street").val() == "គ្មាន"){
            $("#deceased_street").val("");
        }
    });

    $("#deceased_house").focus(function() {
        if($("#deceased_house").val() == ""){
            $("#deceased_house").val("គ្មាន");
        }
    });
    $("#deceased_house").focusout(function() {
        if($("#deceased_house").val() == "គ្មាន"){
            $("#deceased_house").val("");
        }
    });

})

function inputAge(checked){
    if(checked == true){
        $("#age").prop("disabled",false);
        $("#date_of_birth").prop("disabled",true);
        $("#date_of_birth").val("");
        $(".age_type").prop("disabled",false);
    }
    else{
        $("#age").prop("disabled",true);
        $("#date_of_birth").prop("disabled",false);
        $(".age_type").prop("disabled",true);
        $("#rdbYear").prop("checked",true);
    }
}
function getAge() {

    if($('#date_of_birth').val() != "" && $('#date_of_death').val() != ""){
        var dateString_Start = $('#date_of_birth').val();
        var dateParts_Start = dateString_Start.split("-");

        var dateString_End = $('#date_of_death').val();
        var dateParts_End = dateString_End.split("-");

        var start = new Date(+dateParts_Start[2], dateParts_Start[1] - 1, +dateParts_Start[0]);
        var end = new Date(+dateParts_End[2], dateParts_End[1] - 1, +dateParts_End[0]);
        if(start.getTime() > end.getTime()){
            MSG.Error("ថ្ងៃខែឆ្នាំកំណើត មិនអាចធំជាង ថ្ងៃខែឆ្នាំ-មរណភាព បានទេ !!!");
            $('#date_of_birth').val("");
            $('#date_of_death').val("");
            $('#age').val("");
            return false;
        }
        // end - start returns difference in milliseconds
        var diff = new Date(end - start);
        // get days
        var days = diff/1000/60/60/24;
        var year = Math.floor(days/365);
        if(year > 0){
            $("#age").val(year);
            $("#age_type_1").prop("checked",true);
        }
        else{
            var month = Math.floor((parseInt(days)%365)/30);
            if(month){
                $("#age").val(month);
                $("#age_type_2").prop("checked",true);
            }
            else{
                var day = Math.floor((parseInt(days)%365)%30);
                if(day > 0){
                    $("#age").val(day);
                    $("#age_type_3").prop("checked",true);
                }
                else{
                    $("#age").val("");
                }
            }
        }
    }
    else{
        $("#age").val("");
    }

}

function Save(){
    var death_id = $("#death_id").val();
    var hf_code = $("#hf_code").val();
    var death_type = $("input[name='death_type']:checked");
    var death_info = $("input[name='death_info']:checked");
    // var medical_file_id = $("#medical_file_id").val();
    var medical_file_id ="";
    var medicalid_list = document.getElementsByName("medical_file_id");
    for(i = 0; i < medicalid_list.length; i++){
        medical_file_id += medicalid_list[i].value;
    }
    var dod = $("#date_of_death").val();
    var [day, month, year] = dod.split('-');
    var date_of_death = [year, month, day].join('-');

    var dob = $("#date_of_birth").val();
    var date_of_birth = "";
    if(dob != ""){
        var [day, month, year] = dob.split('-');
        date_of_birth = [year, month, day].join('-');
    }

    var time_of_death = $("#time_of_death").val();
    var deceased_name = $("#deceased_name").val();
    // var date_of_birth = $("#date_of_birth").val();
    var sex = $("input[name='sex']:checked");
    var married_status = $("input[name='married_status']:checked");
    var deceased_province_code = $("#deceased_province_code").val();
    var deceased_district_code = $("#deceased_district_code").val();
    var deceased_commune_code = $("#deceased_commune_code").val();
    var deceased_village = $("#deceased_village").val();
    var deceased_street = $("#deceased_street").val();
    var deceased_house = $("#deceased_house").val();

    var age = $("#age").val();
    var age_type = $("input[name='age_type']:checked");
    var age_type_id = age_type[0].value;
    var input_age =0;
    if($("#txtCheckAge").is(':checked')){
        input_age =1;
    }

    if(hf_code == 0){
        MSG.Validation("សូមជ្រើសរើស មូលដ្ឋានសុខាភិបាល !!!");
    }
    else if(death_type.length == 0){
        MSG.Validation("សូមបញ្ចូល ករណីស្លាប់ !!!");
    }
    else if(death_info.length == 0){
        MSG.Validation("សូមបញ្ចូល ព័ត៌មានមរណភាព !!!");
    }
    else if(deceased_name == ""){
        MSG.Validation("សូមបញ្ចូល ឈ្មោះអ្នកស្លាប់ !!!");
    }
    else if(medical_file_id == ""){
        MSG.Validation("សូមបញ្ចូល អត្តលេខឯកសារពេទ្យ !!!");
    }
    else if(sex.length == 0){
        MSG.Validation("សូមបញ្ចូល ភេទ !!!");
    }
    else if(married_status.length == 0){
        MSG.Validation("សូមបញ្ចូល ស្ថានភាពគ្រួសារ !!!");
    }
        // else if(date_of_birth == ""){
        //     MSG.Validation("សូមបញ្ចូល ថ្ងៃខែឆ្នាំកំណើត !!!");
    // }
    else if(date_of_death == ""){
        MSG.Validation("សូមបញ្ចូល ថ្ងៃខែឆ្នាំ-មរណភាព !!!");
    }
    else if(time_of_death == ""){
        MSG.Validation("សូមបញ្ចូល ម៉ោង-មរណភាព !!!");
    }
    else if(deceased_province_code == 0){
        MSG.Validation("សូមបញ្ចូល រាជធានី-ខេត្ត !!!");
    }
    else if(age == ""){
        MSG.Validation("សូមបញ្ចូល អាយុ !!!");
    }
    else{
        $.ajax({
            type:'POST',
            url:"/EMRDeathSave",
            data:{
                death_id:death_id,
                hmis_code: hf_code,
                death_type:death_type[0].value,
                death_info:death_info[0].value,
                medical_file_id:medical_file_id,
                date_of_death:date_of_death,
                time_of_death:time_of_death,
                deceased_name:deceased_name,
                date_of_birth:date_of_birth,
                sex:sex[0].value,
                input_age: input_age,
                age: age,
                age_type_id: age_type_id,
                married_status:married_status[0].value,
                deceased_province_code:deceased_province_code,
                deceased_district_code:deceased_district_code,
                deceased_commune_code:deceased_commune_code,
                deceased_village:deceased_village,
                deceased_street:deceased_street,
                deceased_house:deceased_house,
            },
            success:function(result){
                console.log(result);
                if(result.code == 0){
                    MSG.Success();
                    location.href = "/emr_death";
                    // $("#frmAddNew").modal('hide');
                    // LoadData();
                }
            }
        });
    }
}
