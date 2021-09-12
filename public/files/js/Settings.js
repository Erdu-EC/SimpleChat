//Evento que se ejecuta al dar click sobre Editar informacion de perfil
$(document).on("click", "#btn-editar-perfil", function () {
    if (!$("#btn-guardar-perfil").hasClass("activo")) {
        $("#btn-guardar-perfil").addClass("activo");
    } else {
        if (!$("#check-cambiar-clave").is(':checked')) {
            $("#btn-guardar-perfil").removeClass("activo");
        }
    }
    $(this).toggleClass("activo");
    var elemento = $(".item-perfil-cuenta .atributo-perfil");
    var padre = elemento.parent();
    if ($(this).hasClass("activo")) {
        $("#btn-editar-perfil").html('<span class="material-icons" title="Cancelar">   close</span>')
        $("#valor-genero").addClass("ocultar");
        $("#genero").removeClass("ocultar");
        $("#valor-fecha_nac").addClass("ocultar");
        $("#fecha_nac").removeClass("ocultar");
        padre.addClass("editable");
        elemento.removeAttr("readonly");
    } else {

        ValoresPorDefecto();

    }

});
//Evento que se ejecuta al dar click en check para cambiar contrasena
$(document).on("change", "#check-cambiar-clave", function () {

    if ($("#check-cambiar-clave").is(':checked')) {
        $("#btn-guardar-perfil").addClass("activo");
        $(".item-cuenta .campo-cuenta").each(function () {
            var elemento = $(this);
            var padre = $(this).parent();
            elemento.removeAttr("readonly");
            padre.addClass("editable")
        });
    } else {
        ValoresPorDefectoContrasenas();
    }
});
$(document).on("click", ".item-cuenta.editable", function () {
    $(this).children("campo-cuenta").focus();

});

$(document).on("click", "#btn-opciones-perfil", function (e) {
    $("#list-opciones").remove();
    var posX = (e.pageX - $(this).parent().offset().left) + 20;
    var posY = (e.pageY - $(this).parent().offset().top) + 80;
    var caja = '<div class="contenedor-opciones" id="list-opciones"><ul> <li id="opc-ver-foto">Ver foto</li> <li id="opc-subir-foto">Subir foto</li></ul> </div>';

    $(this).after(caja);
    $("#list-opciones").css("left", posX).css("top", posY);

});



$(document).on("click", "#opc-ver-foto", function () {
    MostrarModal("Mike Ross", '<img src="' + ObtenerUrlImagen($("#foto-perfil-cuenta")) + '" alt="" />', "", 'modal-fullscreen', "btn-close-white");
});

$(document).on('click', "#opc-subir-foto", function () {
    $("#nueva-foto-perfil").trigger("click");
});


$(document).on("input", "#clave-nuev-rep" ,function () {
    if ($("#clave-nuev").val() != "") {
        ClavesIguales();
    }
});
$(document).on("input","#clave-nuev", function () {
    if ($("#clave-nuev-rep").val() != "") {
        ClavesIguales();
    }
});

function ClavesIguales() {
    var clave = $("#clave-nuev");
    var clave_rep = $("#clave-nuev-rep");

    $("#error-claves").remove();
    if (clave.val() != clave_rep.val()) {
        if ($("#error-claves").length == 0) {
            $("#cont-clave-nuev-rep").after(' <div class="error" id="error-claves"> <span class="material-icons">error</span><span>Las contraseñas ingresadas no coinciden</span></div>');
        }
        return false;
    }
    if (clave.val().length < 8 || clave_rep.val().length < 8) {
        if ($("#error-claves").length == 0) {
            $("#cont-clave-nuev-rep").after(' <div class="error" id="error-claves"> <span class="material-icons">error</span><span>La contraseña debe tener 8 caracteres mín.</span></div>');
        }
        return false;
    }
    if (clave.val().length > 60 || clave_rep.val().length > 60) {
        if ($("#error-claves").length == 0) {
            $("#cont-clave-nuev-rep").after(' <div class="error" id="error-claves"> <span class="material-icons">error</span><span>La contraseña debe tener 60 caracteres máx.</span></div>');
        }
        return false;
    }

    return true;
}

//manejando evento INPUT y CHANGE de los input de formularios
$(document).on("input","#nombres", function () {
    ValidarNombreApellido($(this), "nombre");

});
$(document).on("input", "#apellidos",function () {
    ValidarNombreApellido($(this), "apellido");
});
$(document).on("change","#fecha_nac", function () {
    ValidarFechaNacimiento();
});
$(document).on("change","#genero", function () {
    ValidarGenero();
});
$(document).on("input","#correo_usuario", function () {
    ValidarCorreo();
});
$(document).on("input", "#telefono_usuario",function () {
    ValidarTelefono();
});
$(document).on("keydown","#telefono_usuario",function (e) {
    var key = e.key.charCodeAt();
    if ((e.key == "Backspace") ||(e.key == "ArrowRight")|| (e.key == "ArrowLeft")|| (e.key == "Tab")|| (e.key == "Enter")||
        (key >= 48 && key <= 57)) {
        return key;
    } else {
        e.preventDefault();
    }

});

//Funciones
function ValoresPorDefecto(){
    nombres= $("#nombres");
    apellidos = $("#apellidos");
   cont_fecha= $("#valor-fecha_nac");
    genero= $("#genero");
    telefono = $("#telefono_usuario");
correo = $("#correo_usuario");

    nombres.val(nombres.attr("data-src"));
    apellidos.val(apellidos.attr("data-src"));
    cont_fecha.text( ObtenerFecha($("#fecha_nac").attr("data-src")));
    $("#fecha_nac").val($("#fecha_nac").attr("data-src"));

    $("#valor-genero").text($('#genero option[value="'+genero.attr("data-src")+'"]').html());
    $("#genero option:selected").attr("selected",false);
   genero.val(genero.attr("data-src"));

    console.log($("#genero option:selected").val());
    telefono.val(telefono.attr("data-src"));
    correo.val(correo.attr("data-src"));

    $(".item-perfil-cuenta .atributo-perfil").siblings(".notif-error").remove();
    $(".contenedor-telefono-cuenta").siblings(".error").remove();

    var elemento = $(".item-perfil-cuenta .atributo-perfil");
    var padre = elemento.parent();
    $("#btn-editar-perfil").removeClass("activo").html('<span class="material-icons" title="Editar">edit</span>');
    $("#valor-genero").removeClass("ocultar");
    $("#genero").addClass("ocultar");
    $("#valor-fecha_nac").removeClass("ocultar");
    $("#fecha_nac").addClass("ocultar");
    elemento.attr("readonly", true);
    padre.removeClass("editable");

}
//una vez que se ha modificado la informacion de perfil se cambia el data-src con los datos nuevos
function AsignarValoresNuevos(){

$(".item-perfil-cuenta .atributo-perfil").each (function (index, element) {
$(this).attr("data-src", $(this).val());
});
    /*genero= $("#genero");
    genero.attr("data-src", $("#genero option:selected").val());*/
}

function ValoresPorDefectoContrasenas() {
    $("#check-cambiar-clave").prop('checked', false);
    if (!$("#btn-editar-perfil").hasClass("activo")) {

        $("#btn-guardar-perfil").removeClass("activo")
    }
    $(".item-cuenta .campo-cuenta").each(function () {
        var elemento = $(this);
        var padre = $(this).parent();
        elemento.attr("readonly", true).val("");
        padre.removeClass("editable");
    });
    $(".form-conf-acceso .row div .error").remove();
    $("#clave-ant").val("");
    $("#clave-nuev").val("");
    $("#clave-nuev_rep").val("");
}
//Funciones para validacion de los campos


function AgregarMensajeError(elemento, mensaje) {
    elemento.parent().addClass("no-valido");
    if (elemento.siblings(".notif-error") != 0) {
        elemento.after('<div  class="notif-error">' + mensaje + '</div>');
    }

}

function ValidarNombreApellido(elemento, campo_nombre) {
    if (elemento.val().length < 2 || elemento.val().length > 100) {
        AgregarMensajeError(elemento, "Su " + campo_nombre + " debe tener 2 caract. mín.");
        return false;
    }
    elemento.siblings(".notif-error").remove();
    elemento.parent().removeClass("no-valido");
    return true;
}

function ValidarFechaNacimiento() {
    var elemento = $("#fecha_nac");
    var fecha_seleccionada = new Date(elemento.val() + " 00:00:00");
    var fecha_actual = new Date();

    var fecha_minima = new Date("1900-01-01");

    if (elemento.val() == null || elemento.val() == "") {
        AgregarMensajeError(elemento, "Ingrese una fecha válida.");
        return false;
    } else if (fecha_seleccionada < fecha_minima) {
        AgregarMensajeError(elemento, "Ingrese una fecha válida.");
        return false;
    } else if (fecha_seleccionada > fecha_actual) {
        AgregarMensajeError(elemento, "Ingrese una fecha válida.");

        return false;
    }
    elemento.siblings(".notif-error").remove();
    elemento.parent().removeClass("no-valido");
    return true;
}

function ValidarGenero() {

    var elemento = $("#genero");
    if (!(elemento.val() == 'M' || elemento.val() == 'F' || elemento.val() == 'O' || elemento.val() == 'D')) {
        AgregarMensajeError(elemento, "Seleccione una opción válida");
        return false;
    }
    elemento.siblings(".notif-error").remove();
    elemento.parent().removeClass("no-valido");
    return true;
}

function ValidarCorreo() {
    var elemento = $("#correo_usuario");
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (elemento.val().length == 0 || (elemento.val().length > 255)) {
        AgregarMensajeError(elemento, 'El formato de correo no es válido');
        return false;
    } else if (!regex.test(elemento.val())) {
        AgregarMensajeError(elemento, 'El formato de correo no es válido');
        return false;
    }
    elemento.siblings(".notif-error").remove();
    elemento.parent().removeClass("no-valido");
    return true;
}

function ValidarTelefono() {
    var elemento = $("#telefono_usuario");
    if ((elemento.val().length > 0 && elemento.val().length < 8) || elemento.val().length > 15) {
        AgregarMensajeError(elemento, "Ingrese un número de teléfono válido.");
        return false;
    }
    elemento.siblings(".notif-error").remove();
    elemento.parent().removeClass("no-valido");
    return true;
}

//Código para enviar los datos al servidor
$(document).on("click","#btn-guardar-perfil", function () {
    $("#faltan-campos").remove();
    if ($("#btn-editar-perfil").hasClass("activo")) {
        var continuar = true;
        if (!ValidarNombreApellido($("#nombres"), "nombre")) {
            continuar = false;
        }
        if (!ValidarNombreApellido($("#apellidos"), "apellido")) {
            continuar = false;
        }

        if (!ValidarGenero()) {
            continuar = false;
        }
        if (!ValidarFechaNacimiento()) {
            continuar = false;
        }
        if (!ValidarCorreo()) {
            continuar = false;
        }
        if (!ValidarTelefono()) {
            continuar = false;
        }

        if (continuar) {

            swal("¿Estás seguro que deseas cambiar la información?", {
                buttons: ["Cancelar", "Aceptar"],
            }).then((r) => {
                if (r) {
                    EnviarInformacionPerfil();
                }
            });
        } else {
            $(".contenedor-telefono-cuenta").after('<div id="faltan-campos" class="error"><span class="material-icons">error</span>Verifique todos los campos</div>');
        }


    }
    if ($("#check-cambiar-clave").is(':checked')) {
        var continuar = true;
        continuar = ClavesIguales();
        if (continuar) {
            swal("¿Estás seguro que deseas cambiar tu contraseña?", {
                buttons: ["Cancelar", "Aceptar"],
            }).then((r) => {
                 if (r) {
                    EnviarClaveNueva();
                }
            });
        }
    }
});


let imagen_edicion;
var img_result= $("#contenedor-editor #img-tmp");
var my_cropper;
$(document).on('change', "#nueva-foto-perfil", function () {
    const archivos = document.getElementById('nueva-foto-perfil').files;

     //El navegador debe soportar la lectura de archivos
if (!window.FileReader) {
        swal({
            title: "¡Ha ocurrido un error!",
            text: "El navegador no soporta la lectura de archivos.",
            icon: "info",
        });
        return;
    }
//El archivo debe ser una imagen

    if (!(/\.(jpg|png|gif|jpeg)$/i).test(archivos[0].name)) {
        swal({
            title: "¡Ha ocurrido un error!",
            text: "El archivo seleccionado no es un archivo de imágen. Por favor, seleccione un archivo de imágen válido.",
            icon: "warning",
        });
        return;
    }
    //El tamano del archivo no debe ser mayor a 15 MB

    if((archivos[0].size /1048576) > 15){
        swal({
            title: "¡Ha ocurrido un error!",
            text: "El peso de la imágen no debe superar los 15 MB. Por favor, seleccione una imágen válida.",
            icon: "warning",
        });
        return;
    }

    AgregarBotonesEdicion();
    var imagenPrevisualizacion = document.getElementById("img-tmp");
    if (archivos.length != 0 ) {

        let reader = new FileReader();
        reader.readAsDataURL(archivos[0]);

        reader.onload = function () {
            imagenPrevisualizacion.src =reader.result;
           LanzarEditor(imagenPrevisualizacion);
        };

        return;
    }

});

function EnviarImagen() {

    const archivo = document.getElementById('nueva-foto-perfil').files;

   my_cropper.getCroppedCanvas().toBlob(function (blob) {
        const formData = new FormData();
        formData.append('img', blob, archivo[0].name);

        // Use `jQuery.ajax` method for example
        $.ajax({
            url: '/action/users/profile/upload_img',
            type: 'post',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            mimeType: 'application/json',
            success:function (response) {
                if (response[0]) {
                    const reader = new FileReader();
                    reader.readAsDataURL(archivo[0]);

                    reader.onload = function () {
                        $("#foto-perfil-cuenta").attr("src", reader.result);
                        $('#mi-perfil-sidepanel img').attr("src", reader.result);
                        $('#profile-img').attr("src", reader.result);

                    };
                } else {
                    alert('No fue posible subir la imagen.');
                }
            }
        });
    });
}

function LanzarEditor(imagenPrevisualizacion) {
    my_cropper = new Cropper( imagenPrevisualizacion, {
        aspectRatio: 1/1,
        viewMode: 1,
        crop: function(event) {
        },
    });
}

function EnviarInformacionPerfil() {
    $.ajax({
        url: "/action/user/Setting",
        type: "POST",
        mimeType: 'application/json',
        dataType: "json",
        data: {
            fn: $("#nombres").val(),
            ln: $("#apellidos").val(),
            bt: $("#fecha_nac").val(),
            gn: $("#genero").val(),
            em: $("#correo_usuario").val(),
            tf: $("#telefono_usuario").val(),
        },
        beforeSend: () => {

        },
        success: function (json) {
            if (json[0] === true) {
                swal(
                    {
                        text: 'La información de su perfil ha sido modificada correctamente',
                        icon: "success",
                    }).then(
                    function () {
                        AsignarValoresNuevos();
                        ValoresPorDefecto();
                    }
                );
            }
            else{
                switch (json[1]) {
                    case 1:
                        IndicarError("Uno de los campos está vacío. Por favor, verifique todos los campos.");
                        break;
                    case 2:
                        IndicarError("Ingrese un nombre válido. 2 caracteres mín.");
                        break;
                   case 3:
                        IndicarError("Ingrese un apellido válido. 2 caracteres mín.");
                        break;
                   case 4:
                        IndicarError("Ingrese una fecha de nacimiento válida.");
                        break;
                   case 5:
                        IndicarError("Seleccione una opción de género válido.");
                        break;
                   case 6:
                        IndicarError("Ingrese un número de teléfono válido.");
                        break;
                   case 7:
                        IndicarError("Ingrese una dirección de correo válida.");
                        break;
                   case 8:
                           swal({
                                    title: "Ha ocurrido un error",
                                    text: "No se han podido efectuar los cambios",
                                    icon: "info",
                                    buttons: {
                                        retry: "Reintentar",
                                        defeat: "Cerrar",
                                    },
                                })
                           .then((value)=> {
                               if(value == "retry"){

                               }else{
                                   return;
                               }
                           });
                        break;
                }
            }
        },
        error: () => {
            DatosNoEnviados();
        }
    });
}

function EnviarClaveNueva() {
    $.ajax({
        url: "/action/user/NewPassword",
        method: 'POST',
        dataType: 'json',
        data: {
            ca: $("#clave-ant").val(),
            cn: $("#clave-nuev").val(),
            cnr: $("#clave-nuev-rep").val()
        },
        mimeType: 'application/json',
        beforeSend: () => {
        },
        error: () => {
          DatosNoEnviados();
        },
        success: function (json) {
            if(json[0]=== true){
                swal(
                    {
                        text: 'La contraseña de  su cuenta ha sido modificada correctamente.',
                        icon: "success",
                    }).then(
                    function () {
                        ValoresPorDefectoContrasenas();
                    }
                );
            }else{

                switch (json[1]) {
                    case 1:
                        IndicarError("Por favor, verifique que las contraseñas introducidas sean válidas.", "No se ha podido cambiar su contraseña");
                        break;
                    case 2:
                        IndicarError("Verifique que ambas contraseñas coinciden e intente nuevamente", "No se ha podido cambiar su contraseña");
                        break;
                    case 3:
                        IndicarError("La contraseña introducida en el campo \"Contraseña actual\" es incorrecta.","No se ha podido cambiar su contraseña");
                        break;
                    case 4:
                        swal({
                            title:"Restablecer la contrase",
                            text:"La nueva contraseña no puede ser igual que la anterior.",
                            icon: "info",
                            button: "Ok"
                        });
                        break;
                    default:
                        swal({
                            title: "Ha ocurrido un error",
                            text: "No se ha podido efectuar el cambio de contraseña.",
                            icon: "info",
                            buttons: {
                                retry: "Reintentar",
                                defeat: "Cerrar",
                            },
                        })
                            .then((value)=> {
                                if(value == "retry"){
                                    EnviarClaveNueva();

                                }else{
                                    return;
                                }
                            });
                        break;
                }
            }

         }
    });
}
function DatosNoEnviados(){
    swal({
        title: "Datos no enviados",
        text:"No se ha podido completar su solicitud. Revise su conexión a Internet",
        icon:"error",
        dangerMode: true,
        button: "OK"

    });
}

function IndicarError($mensaje, $titulo="") {
    swal({
        title: $titulo,
        text: $mensaje,
        icon: "error",
        button: "Ok",
        dangerMode: true
    });
}
