
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
        });
        $(".form-conf-acceso .row div .error").remove();
    }
});
$(document).on("click", ".item-cuenta.editable", function (){
    $(this).children("campo-cuenta").focus();

});

$(document).on("click", "#btn-opciones-perfil", function (e) {
    $("#list-opciones").remove();
    var posX = (e.pageX - $(this).parent().offset().left)+20;
    var posY = (e.pageY - $(this).parent().offset().top)+80;
           var caja = '<div class="contenedor-opciones" id="list-opciones"><ul> <li id="opc-ver-foto">Ver foto</li> <li id="opc-subir-foto">Subir foto</li></ul> </div>';

        $(this).after(caja);
    $("#list-opciones").css("left",posX);
    $("#list-opciones").css("top",posY);

});

$(document).on("click",function(e) {

    var container = $("#btn-opciones-perfil");

    if (!container.is(e.target) && container.has(e.target).length === 0 && container.length) {
        if ($("#list-opciones").length){   $("#list-opciones").remove();
        }
    }
});

$(document).on("click", "#opc-ver-foto", function (){
    var imagen = $("#foto-perfil-cuenta").attr("data-fuente");
    MostrarModal("Mike Ross", '<img src="'+imagen+'" alt="" />',"", 'modal-fullscreen', "btn-close-white");
});

$(document).on('click',"#opc-subir-foto" ,function () {
    $("#nueva-foto-perfil").trigger("click");
});
$(document).on('change',"#nueva-foto-perfil" ,function () {
        $imagenPrevisualizacion =  $("#foto-perfil-cuenta");
        const archivos = document.getElementById('nueva-foto-perfil').files;

        if (archivos.length != 0 ) {

            let reader = new FileReader();
            reader.readAsDataURL(archivos[0]);

            reader.onload = function () {
                $imagenPrevisualizacion.attr("src", reader.result);
            };

            return;
        }
});


$("#clave-nuev-rep").on("input",  function () {
    if ($("#clave-nuev").val() != ""){
        ClavesIguales();
    }
});
$("#clave-nuev").on("input",  function () {
    if ($("#clave-nuev-rep").val() != ""){
        ClavesIguales();
    }
});
function ClavesIguales() {
    var clave = $("#clave-nuev");
    var clave_rep = $("#clave-nuev-rep");
    $("#error-claves").remove();
    if(clave.val()!= clave_rep.val()){
        if($("#error-claves").length == 0){
        $("#cont-clave-nuev-rep").after(' <div class="error" id="error-claves"> <span class="material-icons">error</span><span>Las contraseñas ingresadas no coinciden</span></div>');
   }
        return false;
    }
    if(clave.val().length < 8 || clave_rep.val().length < 8){
        if($("#error-claves").length == 0){
            $("#cont-clave-nuev-rep").after(' <div class="error" id="error-claves"> <span class="material-icons">error</span><span>La contraseña debe tener 8 caracteres mín.</span></div>');
        }
        return false;
    }
    if(clave.val().length > 60 || clave_rep.val().length > 60){
        if($("#error-claves").length == 0){
            $("#cont-clave-nuev-rep").after(' <div class="error" id="error-claves"> <span class="material-icons">error</span><span>La contraseña debe tener 60 caracteres máx.</span></div>');
        }
        return false;
    }

    return true;
}
//manejando evento INPUT y CHANGE de los input de formularios
$("#nombres").on("input", function () {
    ValidarNombreApellido($(this), "nombre");
});
$("#apellidos").on("input", function () {
    ValidarNombreApellido($(this), "apellido");
});
$("#fecha_nac").on("change", function () {
    ValidarFechaNacimiento();
});
$("#genero").on("change", function () {
    ValidaGenero();
});
$("#correo_usuario").on("input", function () {
    ValidarCorreo();
});
$("#telefono_usuario").on("input", function () {
    ValidarTelefono();
});
$("#telefono_usuario").keydown( function (e) {
    var key =  e.key.charCodeAt(0);
    if ((key == 8 ||
            key == 9 ||
            key == 66 ||
            key == 13 ||
            key == 65 ) ||
        (key >= 48 && key <= 57))
    {
        return key;
    }else{
        e.preventDefault();
    };
});

//Funciones para validacion de los campos



function AgregarMensajeError(elemento, mensaje) {
    elemento.parent().addClass("no-valido");
    if(elemento.siblings(".notif-error")!=0){
        elemento.after('<div  class="notif-error">'+mensaje+'</div>');
    }

}

function ValidarNombreApellido(elemento, campo_nombre) {
    if(elemento.val().length < 2 || elemento.val().length > 100){
        AgregarMensajeError(elemento, "Su "+campo_nombre+" debe tener 2 caract. mín.");
        return false;
    }
    elemento.siblings(".notif-error").remove();
    elemento.parent().removeClass("no-valido");
    return true;
}
function ValidarFechaNacimiento() {
    var elemento = $("#fecha_nac");
    var fecha_seleccionada = new Date(elemento.val()+ " 00:00:00");
    var fecha_actual = new Date();

    var fecha_minima = new Date("1900-01-01");

    if(elemento.val()== null ||elemento.val()=="" ){
        AgregarMensajeError(elemento, "Ingrese una fecha válida.");
        return false;
    }
    else if(fecha_seleccionada < fecha_minima){
        AgregarMensajeError(elemento, "Ingrese una fecha válida.");
        return false;
    }
    else if(fecha_seleccionada > fecha_actual)
    {
        AgregarMensajeError(elemento, "Ingrese una fecha válida.");

        return false;
    }
    elemento.siblings(".notif-error").remove();
    elemento.parent().removeClass("no-valido");
    return true;
}
function ValidaGenero() {
    var elemento = $("#genero");
   if (!(elemento.val=='M' || elemento.val()=='F'|| elemento.val()=='O'|| elemento.val()=='D')){
       AgregarMensajeError(elemento, "Seleccione una opción válida");
       return false;
   }
    elemento.siblings(".notif-error").remove();
    elemento.parent().removeClass("no-valido");
   return true;
}
function ValidarCorreo(){
    var elemento=  $("#correo_usuario");
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if(elemento.val().length == 0 || (elemento.val().length > 255)){
        AgregarMensajeError(elemento,'El formato de correo no es válido');
        return  false;
    }
    else if(!regex.test(elemento.val()) ){
        AgregarMensajeError(elemento,'El formato de correo no es válido');
        return  false;
    }
    elemento.siblings(".notif-error").remove();
    elemento.parent().removeClass("no-valido");
    return true;
}
function ValidarTelefono() {
    var elemento = $("#telefono_usuario");
    if((elemento.val().length > 0 && elemento.val().length < 8) || elemento.val().length > 15){
        AgregarMensajeError(elemento, "Ingrese un número de teléfono válido.");
        return false;
    }
    elemento.siblings(".notif-error").remove();
    elemento.parent().removeClass("no-valido");
    return true;
}

//Enviar datos al servidor 
$("#btn-guardar-perfil").on("click", function () {
    if($("#btn-editar-perfil").hasClass("activo")){
        var continuar= true;
        if(!ValidarNombreApellido($("#nombres"),"nombre")){
            continuar= false;
        }
        if(!ValidarNombreApellido($("#apellidos"), "apellido")){
            continuar= false;
        }

        if (!ValidarGenero()){
            continuar= false;
        }
        if(!ValidarFechaNacimiento()){
            continuar= false;
        }
        if(!ValidarEmail()){
            continuar= false;
        }
        if(!ValidarTelefono()){
            continuar= false;
        }

if(continuar){
    //codigo para enviar los datps al sercvidor
}


    }
    if($("#check-cambiar-clave").is(':checked')){
        var continuar = true;
       continuar= ClavesIguales();

    }
});