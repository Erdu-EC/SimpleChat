$(document).on("click", "#btn-configuraciones", function () {
    CargarEspacioConfiguraciones();
});

function CargarEspacioConfiguraciones(){
    $("body").addClass("sb-sidenav-toggled");
    $('#espacio-de-chat').html(
        ObtenerContenedorHtmlDeAnimacionDeCarga('4.5em', '4.5em', 'text-primary')
    ).load(`/Settings`);

};
//Evento que se ejecuta al dar click sobre Editar informacion de perfil
$(document).on("click", "#btn-editar-perfil", function () {
    if(!$("#btn-guardar-perfil").hasClass("activo")){
        $("#btn-guardar-perfil").addClass("activo");
    }
    else{
        if(!$("#check-cambiar-clave").is(':checked')){
            $("#btn-guardar-perfil").removeClass("activo");
        }
    }
    $(this).toggleClass("activo");
    var elemento= $(".item-perfil-cuenta .atributo-perfil");
    var padre= elemento.parent();
    if($(this).hasClass("activo")){
        $("#btn-editar-perfil").html('<span class="material-icons" title="Cancelar">   close</span>')
        $("#valor-genero").addClass("ocultar");
        $("#genero").removeClass("ocultar");
        $("#valor-fecha_nac").addClass("ocultar");
        $("#fecha_nac").removeClass("ocultar");
        padre.addClass("editable");
        elemento.removeAttr("readonly");
    }
    else
    {
        $("#btn-editar-perfil").html('<span class="material-icons" title="Editar">edit</span>');
        $("#valor-genero").removeClass("ocultar");
        $("#genero").addClass("ocultar");
        $("#valor-fecha_nac").removeClass("ocultar");
        $("#fecha_nac").addClass("ocultar");

        elemento.attr("readonly",true);
        padre.removeClass("editable");

    }

});
//Evento que se ejecuta al dar click en check para cambiar contrasena
$(document).on("change", "#check-cambiar-clave", function () {

    if($("#check-cambiar-clave").is(':checked')){
        $("#btn-guardar-perfil").addClass("activo");
        $(".item-cuenta .campo-cuenta").each(function () {
            var elemento= $(this);
            var padre = $(this).parent();
            elemento.removeAttr("readonly");
            padre.addClass("editable")
        });
    }else
    {
        if(!$("#btn-editar-perfil").hasClass("activo")){

        $("#btn-guardar-perfil").removeClass("activo")
        }
        $(".item-cuenta .campo-cuenta").each(function () {
            var elemento= $(this);
            var padre = $(this).parent();
            elemento.attr("readonly",true).val("");
            padre.removeClass("editable");
            console.log("El checkbox esta a false");
        });
    }
});
$(document).on("click", ".item-cuenta.editable", function (){
    $(this).children("campo-cuenta").focus();
    console.log( $(this).children("campo-cuenta").className);
});
