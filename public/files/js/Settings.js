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
        $("#btn-editar-perfil").html('<span class="material-icons" title="Editar">edit</span>');
        $("#valor-genero").removeClass("ocultar");
        $("#genero").addClass("ocultar");
        $("#valor-fecha_nac").removeClass("ocultar");
        $("#fecha_nac").addClass("ocultar");

        elemento.attr("readonly", true);
        padre.removeClass("editable");

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
    $("#list-opciones").css("left", posX);
    $("#list-opciones").css("top", posY);

});

$(document).on("click", function (e) {

    var container = $("#btn-opciones-perfil");

    if (!container.is(e.target) && container.has(e.target).length === 0 && container.length) {
        if ($("#list-opciones").length) {
            $("#list-opciones").remove();
        }
    }
});

$(document).on("click", "#opc-ver-foto", function () {
    var imagen = $("#foto-perfil-cuenta").attr("data-fuente");
    MostrarModal("Mike Ross", '<img src="' + imagen + '" alt="" />', null, 'modal-fullscreen', "btn-close-white");
});

$(document).on('click', "#opc-subir-foto", function () {
    $("#nueva-foto-perfil").trigger("click");
});
$(document).on('change', "#nueva-foto-perfil", function () {
    $imagenPrevisualizacion = $("#foto-perfil-cuenta");
    const archivos = document.getElementById('nueva-foto-perfil').files;

    if (archivos.length !== 0) {
        const reader = new FileReader();
        reader.readAsDataURL(archivos[0]);

        reader.onload = function () {
            $imagenPrevisualizacion.attr("src", reader.result);
        };
    }
});


$("#clave-nuev-rep").on("change", function () {
    if ($("#clave-nuev").val() != "") {
        ClavesIguales();
    }
});
$("#clave-nuev").on("change", function () {
    if ($("#clave-nuev-rep").val() != "") {
        ClavesIguales();
    }
});

function ClavesIguales() {
    var clave = $("#clave-nuev");
    var clave_rep = $("#clave-nuev-rep");

    if (clave.val() != clave_rep.val()) {
        if ($("#error-claves").length == 0) {
            $("#cont-clave-nuev-rep").after(' <div class="error" id="error-claves"> <span class="material-icons">error</span><span>Las contraseñas ingresadas no coinciden</span></div>');
        }
        return false;
    } else {
        $("#error-claves").remove();

        return true;
    }
}