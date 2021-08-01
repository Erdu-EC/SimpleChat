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
    $(this).toggleClass("activo");
    $("#btn-guardar-perfil").toggleClass("activo");
    $(this).hasClass("activo")?   $("#btn-editar-perfil").html('<span class="material-icons" title="Cancelar">   close</span>'):$("#btn-editar-perfil").html('<span class="material-icons" title="Editar">edit</span>');

    $(".item-perfil-cuenta .atributo-perfil").each(function () {
       var elemento= $(this);
       var padre= elemento.parent();
           if(elemento.attr("contenteditable")=="true"){
               elemento.attr("contenteditable","false");
               padre.removeClass("editable");

           }else{
               elemento.attr("contenteditable","true");
               padre.addClass("editable");


           }

   }

   );

});
//Evento que se ejecuta al dar click en check para cambiar contrasena
$(document).on("click", "#check-cambiar-clave", function () {
    if($(this).val()){
        $(".item-cuenta .campo-cuenta").each(function () {
            var elemento= $(this);
            var padre = $(this).parent();
            elemento.attr("contenteditable","true");
            padre.addClass("editable")
        });
    }
});
$(document).on("click", ".item-cuenta.editable", function (){
    $(this).children("campo-cuenta").focus();
    console.log( $(this).children("campo-cuenta").className);
});
