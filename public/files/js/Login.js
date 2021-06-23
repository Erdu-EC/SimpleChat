
$("#user_form").submit(function (e){
    const user = $("#user_name").val();
    const pass = $("#user_pass").val();
    const action_alert = $("#action_alert");

    const color_info = "alert-info";
    const color_error = "alert-danger";

    $.ajax('/Login.json',{
        method: 'post',
        dataType: 'json',
        mimeType: 'application/json',
        data: {u: user, p: pass},
        beforeSend: () => action_alert.removeClass(color_error).addClass(color_info).text("Cargando..."),
        error: () => action_alert.removeClass(color_info).addClass(color_error).text("No fue posible iniciar sesion."),
        success: function (json){
            if (json === true){
                action_alert.removeClass(color_error).addClass(color_info).text('Sesion iniciada.');
                window.location = "/";
            }else
                action_alert.removeClass(color_info).addClass(color_error).text('Usuario o contraseña incorrecta.');
        }
    });

    return false;
});


$(document).on('input', '#user_pass', null, function (event){
    const input = $('#user_pass')[0];
    if (input.validity.tooLong || input.validity.tooShort)
        input.setCustomValidity("La contraseña debe tener un minimo de 8 caracteres y un maximo de 60.");
    else
        input.setCustomValidity('');
});


$("#btn-navbar-toggler").click(function (){
    $("nav.menu-navegacion ul.nav-lista").toggleClass("activo");
    $("nav.menu-navegacion ul.nav-lista").toggleClass("inactivo");
});