

$(document).ready(function (){

    $(".datefield").pickadate({
        selectMonths: true,
        selectYears: true,
        format: 'dd-mm-yyyy',
        hiddenName: true,
        selectYears: 50,
        max: true
    });
    $(".select2").select2();

    $("#answer_2").prop("disabled",true);
    $("#answer_3").prop("disabled",true);

    $('input[name=answer_1]').change(function(){
        var value = $('input[name=answer_1]:checked' ).val();

        if(value == 1){
            $("#answer_2").prop("disabled",false);
            $("#answer_3").prop("disabled",false);
        }
        else{
            $("#answer_2").prop("disabled",true);
            $("#answer_3").prop("disabled",true);
        }
    });

    $('input[name=answer_5]').prop("disabled",true);
    $('input[name=answer_6]').prop("disabled",true);
    $('input[name=answer_7]').prop("disabled",true);
    $("#answer_8").prop("disabled",true);
    $("#answer_9").prop("disabled",true);
    $('input[name=answer_4]').change(function(){
        var value = $('input[name=answer_4]:checked').val();

        if(value == 1){
            $('input[name=answer_5]').prop("disabled",false);
            $('input[name=answer_6]').prop("disabled",false);
            $('input[name=answer_7]').prop("disabled",false);
            $("#answer_8").prop("disabled",false);
            $("#answer_9").prop("disabled",false);
        }
        else{
            $('input[name=answer_5]').prop("disabled",true);
            $('input[name=answer_5]').prop("checked",false);
            $('input[name=answer_6]').prop("disabled",true);
            $('input[name=answer_6]').prop("checked",false);
            $('input[name=answer_7]').prop("disabled",true);
            $('input[name=answer_7]').prop("checked",false);
            $("#answer_8").prop("disabled",true);
            $("#answer_9").prop("disabled",true);
        }
    });

    $("#btnSave").click(function (e){

        var index=0;
        var obj = {
            mccd_id: $("#mccd_id").val(),
            death_id: $("#death_id").val(),
            mccd_section_a:[],
            mccd_section_b:[]
        };
        var count_requird =0;

        //section_a
        var index_a = 0;
        for(i = 0; i < 4; i++){
            index_a++;
            var death_reason = $("#reason_"+index_a).val();
            var period = $("#period_"+index_a).val();
            var level_coder = $("#coder_"+index_a).val();
            var data = {
                id:0,
                mccd_id: $("#mccd_id").val(),
                order_no: index_a,
                death_reason:death_reason,
                period: period,
                level_coder: level_coder
            }
            if(index_a == 1 && death_reason == ""){
                count_requird++;
                $("#reason_"+index_a).css("border","solid 1px red");
            }
            else{
                $("#reason_"+index_a).css("border","solid 1px #ced4da");
            }
            obj.mccd_section_a.push(data);
        }

        //section_b
        for(i = 0; i < 23; i++){
            index++;
            var input_element_name = "answer_"+index;
            var type = $('input[name = ' + input_element_name + ']').attr('type');
            var question_id =0;
            question_id = $('input[name = ' + input_element_name + ']').data('id');
            var answer ="";
            var required =0;
            required = $('input[name = ' + input_element_name + ']').data('required');


            if(type == "text"){
                answer = $("#"+input_element_name).val();

                if($("#"+input_element_name).hasClass("datefield")){
                    var father_date_of_birth = "";
                    if(answer != ""){
                        var [day, month, year] = answer.split('-');
                        answer = [year, month, day].join('-');
                    }
                }

                if(required ==1 && answer ==""){
                    count_requird++;
                    $("#tr_"+index).css('background-color','#fac793');
                }
                else{
                    $("#tr_"+index).css('background-color','#ffffff');
                }
            }
            else{
                answer = $('input[name= ' + input_element_name + ']:checked').val();
                if(answer == undefined){
                    answer = 0;
                }
                if(required ==1 && answer == 0){
                    count_requird++;
                    $("#tr_"+index).css('background-color','#fac793');
                }
                else{
                    $("#tr_"+index).css('background-color','#ffffff');
                }
            }

            var data ={
                id:0,
                mccd_id: $("#mccd_id").val(),
                question_id: question_id,
                question_name: '',
                question_name_kh: '',
                answer_type_id: '',
                setting_type_id: '',
                order_no: '',
                answer: answer
            }
            obj.mccd_section_b.push(data);

        }
        count_requird=0;
        if(count_requird == 0){
            console.log(obj);
            $.ajax({
                type:'POST',
                url:"/MCCD_Save",
                data:JSON.stringify(obj),
                success:function(result){
                    console.log(result);
                    if(result.code == 0){
                        MSG.Success();
                        location.href = "/mccd";
                    }
                    else{
                        MSG.Error(result.msg);
                    }
                }
            });
        }
        else{
            MSG.Validation("សូមបំពេញចម្លើយ ចំពោះសំណួរដែលត្រូវឆ្លើយជាចាំបាច់ !!!");
        }

    })

    if($("#mccd_id").val() > 0){
        setValue();
    }

})

function setValue(){
    $("#answer_2").prop("disabled",true);
    $("#answer_3").prop("disabled",true);

    var value = $('input[name=answer_1]:checked' ).val();
    if(value == 1){
        $("#answer_2").prop("disabled",false);
        $("#answer_3").prop("disabled",false);
    }
    else{
        $("#answer_2").prop("disabled",true);
        $("#answer_3").prop("disabled",true);
    }

    $('input[name=answer_5]').prop("disabled",true);
    $('input[name=answer_6]').prop("disabled",true);
    $('input[name=answer_7]').prop("disabled",true);
    $("#answer_8").prop("disabled",true);
    $("#answer_9").prop("disabled",true);
    var value = $('input[name=answer_4]:checked').val();

    if(value == 1){
        $('input[name=answer_5]').prop("disabled",false);
        $('input[name=answer_6]').prop("disabled",false);
        $('input[name=answer_7]').prop("disabled",false);
        $("#answer_8").prop("disabled",false);
        $("#answer_9").prop("disabled",false);
    }
    else{
        $('input[name=answer_5]').prop("disabled",true);
        $('input[name=answer_5]').prop("checked",false);
        $('input[name=answer_6]').prop("disabled",true);
        $('input[name=answer_6]').prop("checked",false);
        $('input[name=answer_7]').prop("disabled",true);
        $('input[name=answer_7]').prop("checked",false);
        $("#answer_8").prop("disabled",true);
        $("#answer_9").prop("disabled",true);
    }
}
