function TerosAlert(event) {

    var titulo = event.detail.title;
    var tipo = event.detail.tipo;
    var icono = "";

    switch (tipo) {
        case 'success':
            var bg = 'apl-notificacion-success';
            break;
        case 'info':
            var bg = 'apl-notificacion-info';
            break;
        case 'warning':
            var bg = 'apl-notificacion-warning';
            break;
        case 'error':
            var bg = 'apl-notificacion-danger';
            break;
        default:
            var bg = 'apl-notificacion-secondary';
            break;
    }

    $('.apl-notificacion').fadeIn(200);
    $('.apl-notificacion').addClass(bg);
    $('#apl-notificacion-icon').addClass(icono);
    $('#apl-notificacion-titulo').html(titulo);

    //Cerrar
    setTimeout(function() {
        $('.apl-notificacion').hide();
    }, 3000);

    $('.apl-notificacion').on('click', function() {
        $('.apl-notificacion').fadeOut(200);
        setTimeout(function() {
            $('.apl-notificacion').hide();
        }, 200);
    });

}