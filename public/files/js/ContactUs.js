$("#btn-navbar-toggler").click(function () {
    $("nav.menu-navegacion ul.nav-lista").toggleClass("activo").toggleClass("inactivo");
});

// validando nombre del remitente
$("#nombre-remitente").on("input", function (){
    ValidarNombre();
});
function ValidarNombre() {
    var elemento = $("#nombre-remitente");
    var resp = true;
    elemento.removeClass("error");
    elemento.siblings(".caja-informacion").remove();

    if(elemento.val().length == 0){

        elemento.removeClass("validado");
        resp = false;
    }
    else if(elemento.val().length == 1){
        AgregarMensajeError(elemento, 'El nombre debe contener al menos 2 caracteres');
        resp = false;
    }
    else{
        elemento.addClass("validado");
        resp = true;
    }
    HabilitarEnvio();
    return resp;
}
//validando correo del remitente

$("#correo-remitente").on("input",function (){
    ValidarEmail()
});
function ValidarEmail(){
    var elemento=  $("#correo-remitente");
    var resp = true;
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    elemento.siblings(".caja-informacion").remove();
    elemento.removeClass("error");

    if(elemento.val().length == 0 ){
        elemento.removeClass("validado");
        var resp = false;
    }
    else if(!regex.test(elemento.val()) ){
        AgregarMensajeError(elemento,'El formato de correo no es válido');
        var resp = false;
    }
    else {

        elemento.addClass("validado");
        var resp = true;

    }
    HabilitarEnvio();
    return resp;
}
//validando telefono

$("#telefono-remitente").keydown( function (e) {
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


$("#telefono-remitente").on("input", function (){
    ValidarTelefono();
});

function ValidarTelefono(param = false) {
    var elemento = $("#telefono-remitente");
    var resp = true;
    elemento.removeClass("error");
    elemento.siblings(".caja-informacion").remove();
    if(elemento.val().length == 0 && !param){
        elemento.removeClass("validado");
        resp = true;
    }
    else if((elemento.val().length < 8 || elemento.val().length > 15) || param){
        AgregarMensajeError(elemento,'Número de teléfono no válido');


        resp = false;
    }else {
        elemento.addClass("validado");
        resp = true;
    }
    HabilitarEnvio();
    return resp;
}

//validando Mensaje
$("#mensaje").on("input",function () {
    ValidarMensaje();
});

function ValidarMensaje() {
    var elemento = $("#mensaje");
    var resp = true;
    elemento.siblings(".caja-informacion").remove();
    elemento.removeClass("validado");
    elemento.removeClass("error");
    if(elemento.val().length == 0){
        AgregarMensajeError(elemento, 'Debe escribir un mensaje');
        resp = false;

    }
    else{
        elemento.addClass("validado");
    }
    HabilitarEnvio();
    return resp;
}
function HabilitarEnvio(){
    $(".formulario-contacto .alert-error").remove();
    if ($("#nombre-remitente").hasClass("validado" )  && $("#correo-remitente").hasClass("validado" )  && $("#mensaje").hasClass("validado" ) && (!$("#telefono-remitente").hasClass("error" )) )
    {
        $("#enviar").addClass("habilitado")}
    else
    {
        $("#enviar").removeClass("habilitado")
    }
}

function AgregarMensajeError(elemento, mensaje) {
    elemento.addClass("error");
    elemento.removeClass("validado");
    if(elemento.siblings(".caja-informacion").length == 0){
        elemento.after('<div class="caja-informacion"><span>'+mensaje+'</span></div>');
    }
}


$("#enviar").on("click",function (e){
    var continuar = true;
    e.preventDefault();
    if(!ValidarNombre()){
        AgregarMensajeError($("#nombre-remitente"), 'El nombre debe contener al menos 2 caracteres');
        continuar= false;
    }
   if(!ValidarEmail()){
       AgregarMensajeError($("#correo-remitente"), 'El formato de correo no es válido');
       continuar= false;
   }
   if(!ValidarTelefono()){
       AgregarMensajeError($("#telefono-remitente"), 'Número de teléfono no válido');
       continuar= false;
   }
   if(!ValidarMensaje()){
       AgregarMensajeError($("#mensaje"), 'Debe escribir un mensaje');
       continuar= false;
   }

 if(continuar){
     //sentencias para enviar formulario
     swal({

         text: "Gracias por escribirnos, su mensaje ha sido recibido.",
         icon: "/files/icon/logo-bk.png?h=50",
     });
 }
 else{
     if($(".formulario-contacto .alert-error").length == 0){
         $(".contenedor-enviar").before('<div class="alert-error"><div class="icon-error"> <i class="fas fa-exclamation-circle"></i></div><div class="mensaje-error">Por favor, verifique todos los campos</div></div>');
     }

}
});