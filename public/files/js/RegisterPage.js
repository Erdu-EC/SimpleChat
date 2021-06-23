/*-----------------------------------------------
Accione para estilos de la página
-----------------------------------------------*/
$(document).ready(function () {
    $("input[type=date]").val("");
});
$(".input-group input#birth_date").focus(function (){
    $(this).css("color","#868580");
    var elemento =  $(this).parent().parent();
    elemento.addClass("activo");
    elemento.removeClass("error");
    $(this).removeClass("error");
});
$(".input-group input#birth_date").blur(function () {
    var elemento =  $(this).parent().parent();

    if($(this).val()==""){
        elemento.removeClass("activo");
        elemento.addClass("error");
        $(this).addClass("error");
        $(this).css("color","transparent");
    }else
    {
        $(this).addClass("valorado");
        $(".input-group input#birth_date").css("color","#171a1d");
    }

});

$(".item-form .input-group input").focus(function () {
    var elemento =  $(this).parent().parent();
    elemento.addClass("activo");
    elemento.removeClass("error");
    $(this).removeClass("error");
});

$(".item-form .input-group input").blur(function () {
    var elemento =  $(this).parent().parent();

    if($(this).val()==""){
        elemento.removeClass("activo");
        elemento.addClass("error");
        $(this).addClass("error");
    }else
    {
        $(this).addClass("valorado");
    }

});
$(".item-form .input-group #gender").click(function () {
    var elemento =  $(this).parent().parent();
    elemento.addClass("activo");
    elemento.removeClass("error");
    $(this).removeClass("error");
});
$(".item-form .input-group #gender").blur(function () {
    var elemento =  $(this).parent().parent();

    if($(this).val()==""){
        elemento.removeClass("activo");
        elemento.addClass("error");
        $(this).addClass("error");
    }

});
/*-----------------------------------------------
Fin accione para estilos de la página
-----------------------------------------------*/