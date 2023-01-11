$(document).ready(function (){
    $(".datefield").pickadate({
        selectMonths: true,
        selectYears: true,
        format: 'dd-mm-yyyy',
        hiddenName: true,
        selectYears: 50,
        max: true
    });

    $('.timefield').bootstrapMaterialDatePicker({
        date: false,
        format: 'HH:mm'
    });

    $(".select2").select2();

    // $("#baby_name").focus(function() {
    //     if($("#baby_name").val() == ""){
    //         $("#baby_name").val("គ្មាន");
    //     }
    // });
    //
    // $("#baby_name").focusout(function() {
    //     if($("#baby_name").val() == "គ្មាន"){
    //         $("#baby_name").val("");
    //     }
    // });
    //
    // $("#mother_street").focus(function() {
    //     if($("#mother_street").val() == ""){
    //         $("#mother_street").val("គ្មាន");
    //     }
    // });
    //
    // $("#mother_street").focusout(function() {
    //     if($("#mother_street").val() == "គ្មាន"){
    //         $("#mother_street").val("");
    //     }
    // });
    //
    // $("#mother_house").focus(function() {
    //     if($("#mother_house").val() == ""){
    //         $("#mother_house").val("គ្មាន");
    //     }
    // });
    //
    // $("#mother_house").focusout(function() {
    //     if($("#mother_house").val() == "គ្មាន"){
    //         $("#mother_house").val("");
    //     }
    // });

})




function GetMotherAge(dob){
    dob = dob.split("-");
    dob = new Date(+dob[2], dob[1] - 1, +dob[0]);
    var ageDifMs = Date.now() - dob;
    var ageDate = new Date(ageDifMs); // miliseconds from epoch
    $("#motherAge").val(Math.abs(ageDate.getUTCFullYear() - 1970));
}

function GetFatherAge(dob){
    dob = dob.split("-");
    dob = new Date(+dob[2], dob[1] - 1, +dob[0]);
    var ageDifMs = Date.now() - dob;
    var ageDate = new Date(ageDifMs); // miliseconds from epoch
    $("#fatherAge").val(Math.abs(ageDate.getUTCFullYear() - 1970));
}

function isMotherAge(checked){
    if(checked == true){
        $("#motherAge").prop("disabled",false);
        $("#mother_date_of_birth").prop("disabled",true);
        $("#mother_date_of_birth").val("");
    }
    else{
        $("#motherAge").prop("disabled",true);
        $("#mother_date_of_birth").prop("disabled",false);
    }
}

function isFatherAge(checked){
    if(checked == true){
        $("#fatherAge").prop("disabled",false);
        $("#father_date_of_birth").prop("disabled",true);
        $("#father_date_of_birth").val("");
    }
    else{
        $("#fatherAge").prop("disabled",true);
        $("#father_date_of_birth").prop("disabled",false);
    }
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function Save(){
    var bid = $("#bid").val();
    var hfac_code = $("#hf_code").val();
    var medicalid ="";
    var medicalid_list = document.getElementsByName("medicalid");
    for(i = 0; i < medicalid_list.length; i++){
        medicalid += medicalid_list[i].value;
    }
    var birth_info = $("input[name='birth_info']:checked");
    var birth_type = $("input[name='birth_type']:checked");
    var attendant_at_delivery = $("input[name='attendant_at_delivery']:checked");
    var abandoned_baby=0;
    if ($("#abandoned_baby").is(':checked')) {
        abandoned_baby =1;
    }
    var baby_last_name = $("#baby_last_name").val();
    var baby_first_name = $("#baby_first_name").val();
    var sex = $("input[name='sex']:checked");
    var baby_weight = $("#baby_weight").val();
    var dob = $("#date_of_birth").val();
    var date_of_birth = "";
    if(dob != ""){
        var [day, month, year] = dob.split('-');
        date_of_birth = [year, month, day].join('-');
    }
    var time_of_birth = $("#time_of_birth").val();
    var mother_name = $("#mother_name").val();
    var m_dob = $("#mother_date_of_birth").val();
    var mother_date_of_birth = "";
    if(m_dob != ""){
        var [day, month, year] = m_dob.split('-');
        mother_date_of_birth = [year, month, day].join('-');
    }
    var father_name = $("#father_name").val();
    var f_dob = $("#father_date_of_birth").val();
    var father_date_of_birth = "";
    if(f_dob != ""){
        var [day, month, year] = f_dob.split('-');
        father_date_of_birth = [year, month, day].join('-');
    }
    var numofchildalive = $("#numofchildalive").val();
    var mother_province = $("#mother_province").val();
    var mother_district = $("#mother_district").val();
    var mother_commune = $("#mother_commune").val();
    var mother_village = $("#mother_village").val();
    var mother_street = $("#mother_street").val();
    var mother_house = $("#mother_house").val();
    var contact_phone = $("#contact_phone").val();
    var motherage = $("#motherAge").val();
    var fatherage = $("#fatherAge").val();
    if(hfac_code == 0){
        MSG.Validation("សូមជ្រើសរើស មូលដ្ឋានសុខាភិបាល !!!");
    }
    else if(medicalid == ""){
        MSG.Validation("សូមបញ្ចូល អត្តលេខសំណុំឯកសារសេវាសម្រាលកូន !!!");
    }
    else if(birth_info.length == 0){
        MSG.Validation("សូមជ្រើសរើស ព័ត៌មានកំណើត !!!");
    }
    else if(birth_type.length == 0){
        MSG.Validation("សូមជ្រើសរើស ប្រភេទកំណើត !!!");
    }
    else if(attendant_at_delivery.length == 0){
        MSG.Validation("សូមជ្រើសរើស សម្រាលដោយ !!!");
    }
    else if(sex.length == 0){
        MSG.Validation("សូមជ្រើសរើស ភេទ !!!");
    }
    else if(baby_weight == ""){
        MSG.Validation("សូមបញ្ចូល ទម្ងន់ទារក !!!");
    }
    else if(date_of_birth == ""){
        MSG.Validation("សូមបញ្ចូល ថ្ងៃខែឆ្នាំកំណើត !!!");
    }
    else if(time_of_birth == ""){
        MSG.Validation("សូមបញ្ចូល ម៉ោងកំណើត !!!");
    }
    else if(abandoned_baby == 0 && mother_name == ""){
        MSG.Validation("សូមបញ្ចូល ឈ្មោះម្ដាយ !!!");
    }
    else if(abandoned_baby == 0 && motherage ==""){
        MSG.Validation("សូមបញ្ចូល អាយុ(ម្ដាយ) !!!");
    }
    else if(abandoned_baby == 0 && father_name == ""){
        MSG.Validation("សូមបញ្ចូល ឈ្មោះឪពុក !!!");
    }
    else if(abandoned_baby == 0 && fatherage == ""){
        MSG.Validation("សូមបញ្ចូល អាយុ(ឪពុក) !!!");
    }
    else if(numofchildalive == ""){
        MSG.Validation("សូមបញ្ចូល ចំនួនកូនកើតរស់ (មកទល់បច្ចុប្បន្ន) !!!");
    }
    else if(mother_province == ""){
        MSG.Validation("សូមបញ្ចូល ទីលំនៅប្រក្រតីរបស់ម្ដាយ !!!");
    }
    else{
        $.ajax({
            type:'POST',
            url:"/BirthSave",
            data:{
                bid:bid,
                hfac_code: hfac_code,
                medicalid:medicalid,
                birth_info:birth_info[0].value,
                typeofbirth:birth_type[0].value,
                Atdelivery:attendant_at_delivery[0].value,
                abandoned:abandoned_baby,
                baby_last_name:baby_last_name,
                baby_first_name:baby_first_name,
                sex:sex[0].value,
                baby_weight: baby_weight,
                dateofbirth: date_of_birth,
                time_of_birth: time_of_birth,
                mothername: mother_name,
                motherdofbirth:mother_date_of_birth,
                fathername:father_name,
                fatherdofbirth:father_date_of_birth,
                numofchildalive:numofchildalive,
                mPCode:mother_province,
                mDCode:mother_district,
                mCCode:mother_commune,
                mVCode:mother_village,
                mStreet:mother_street,
                mHouse:mother_house,
                contact_phone: contact_phone,
                motherage: motherage,
                fatherage: fatherage
            },
            success:function(result){
                console.log(result);
                if(result.code == 0){
                    MSG.Success();
                    location.href = "/emr_birth";
                }
            }
        });
    }
}
