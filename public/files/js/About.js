$(".container-fluid").scroll(function() {
    if ($(this).scrollTop() > 200) {
        $("#hacia-arriba").addClass('visible');

    } else {
        $("#hacia-arriba").removeClass('visible');
    }
});

$('#hacia-arriba').on('click', function() {
    $(".container-fluid").animate({scrollTop: 0}, 600);
});
