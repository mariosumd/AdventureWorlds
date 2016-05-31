<!DOCTYPE html>
<!--
	                 λλλλλ
	            λλλλλλλλλλλλλλλ
	         λλλλλλλλλ  λλλλλλλλλλ
	        λλλλλλ            λλλλλλ
	      λλλλλ                  λλλλ
	     λλλλ      λλλλλλ         λλλλ
	    λλλλ         λλλλλ         λλλλ
	   λλλλ           λλλλ          λλλλ
	   λλλλ           λλλλλ          λλλλ
	  λλλλ           λλλλλλ          λλλλ
	  λλλλ          λλλλλλλ          λλλλ
	  λλλλ         λλλλ λλλλ         λλλλ
	   λλλ        λλλλλ  λλλλ        λλλλ
	   λλλλ      λλλλλ    λλλλ       λλλλ
	   λλλλ     λλλλ      λλλλλλλ   λλλλ
	    λλλλ   λλλλλ       λλλλλλλ λλλλ
	     λλλλ                     λλλλ
	      λλλλλ                  λλλλ
	       λλλλλλ             λλλλλλ
	         λλλλλλλλλ    λλλλλλλλ
	            λλλλλλλλλλλλλλλλ
	                λλλλλλλλ
	-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= isset($title) ? $title : '' ?></title>
        <link href='https://fonts.googleapis.com/css?family=Press+Start+2P' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Candal' rel='stylesheet' type='text/css'>
        <?= link_tag('css/creator.css') ?>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet"
              href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
              integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
              crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet"
              href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
              integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r"
              crossorigin="anonymous">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!--<?= link_tag('css/star-rating.min.css') ?>-->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="<?= base_url() ?>js/jquery.color-2.1.2.min.js"></script>
        <script src="<?= base_url() ?>js/jquery.cookie.js"></script>
        <!--<script id="rating" src="<?= base_url() ?>js/star-rating.min.js" type="text/javascript"></script>-->
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    </head>
    <body>
        <script>
            var id_ficha;
            var id_juego;
            var id_usuario;
            <?= nuevo_juego() ?>

            $(document).ready(function() {
                $('#logout').on("click", delCookie);
                $('#formJuego button').on('click', nombreJuego);
                $('#form-otrojuego button').on('click', cargaJuego);
                $('#modalFicha button').on('click', nombreFicha);
                $('#form-fichanueva button:first-of-type').on('click', nuevaFicha);
                $('#form-otraficha button:first-of-type').on('click', ligarFicha);
                $('.modal-footer button').on('click', cancelaFicha);
                $('.colFon span').on('click', colorFondo);
                $('.colBot span').on('click', colorBotones);
                $('.numBot span').on('click', numBotones);
                $('.final span').on('click', fichaFinal);
                $('.img > span').on('click', imagen);
                $('#form-img').on('submit', subirImagen);
                $('.footer-img > button').on('click', cancelaImagen);
                $('.botones button:not(.siguiente)').on('click', contenidoBoton);
                $('h4.titulo').on('click', text);
                $('.ocultoTitl > button:first-of-type').on('click', titulo);
                $('.ocultoTitl > button:last-of-type').on('click', cancelaTitulo);
                $('#ficha > p').on('click', textarea);
                $('.ocultoText > button:first-of-type').on('click', contenido);
                $('.ocultoText > button:last-of-type').on('click', cancelaContenido);
                $('.siguiente').on('click', siguienteFicha);
                $('aside > div').on('click', cargaFichaLista);
                //$(window).on('beforeunload', confirmarSalida);
                //$(window).on('unload', borraJuego);
                cookie();
            });

            function cookie() {
                <?php if (logueado()): ?>
                    if (!$.cookie('usuario')) {
                        $.cookie('usuario', <?= usuario_id() ?>);
                    }

                    id_usuario = <?= usuario_id() ?>
                <?php endif; ?>
            }

            function delCookie() {
                $.removeCookie('usuario');
            }

            function borraJuego() {
                $.ajax({
                    url: "<?= base_url('creadores/borrar_juego') ?>",
                    method: 'POST',
                    data: {
                        'id_juego': id_juego
                    }
                });
            }

            function idFicha() {
                id_ficha = $.ajax({
                    async: false,
                    url: "<?= base_url('creadores/id_ficha') ?>"
                }).responseText;
            }

            function anadeFichaAside(idFicha, titulo) {
                titulo = titulo === null || titulo === '' ? '<Ficha sin título>' : titulo;

                var p = $('<p></p>').text(titulo);
                var div = $('<div></div>')
                .attr('id', idFicha)
                .append(p)
                .append($('<ul></ul>'));
                $('aside').append(div);
            }

            function cargaFichaAside(idFicha, titulo, siguiente1, siguiente2) {
                anadeFichaAside(idFicha, titulo);
                if (siguiente1 !== null && siguiente1 !== '') {
                    var li = $('<li></li>').text(siguiente1);
                    $(document.getElementById(idFicha)).find('ul').prepend(li);
                }
                if (siguiente2 !== null && siguiente2 !== '') {
                    var li = $('<li></li>').text(siguiente2);
                    $(document.getElementById(idFicha)).find('ul').append(li);
                }
            }

            function destacaAside(id) {
                var div = document.getElementById(id);
                $('aside > div').removeClass('destacado').on('click', cargaFichaLista);
                $(div).addClass('destacado').off('click');
            }

            function asideInicio(idFicha) {
                var span = $('<span></span>').text('[INICIO]');
                $(document.getElementById(idFicha)).prepend(span);
            }

            function asideFinal() {
                var span = $('<span></span>').text('[FINAL]');
                $(document.getElementById(idFicha)).prepend(span);
            }

            function fichaFinal() {
                $.ajax({
                    url: "<?= base_url('creadores/ficha_final') ?>",
                    method: 'POST',
                    data: {
                        'id_ficha': id_ficha
                    }
                });

                $('.botones').fadeOut();
            }

            function juego() {
                var juegos = $.ajax({
                    url: "<?= base_url('creadores/lista_juegos') ?>",
                    method: 'POST',
                    async: false,
                    dataType: 'json',
                    data: {
                        id_usuario: <?= usuario_id() ?>
                    }
                }).responseJSON;

                if (juegos.display === true) {
                    for (var i = 0; i < juegos.lista.length; i++) {
                        var option = $('<option></option>')
                        .text(juegos.lista[i].nombre)
                        .attr('value', juegos.lista[i].id_juego);
                        $('#nombre-otrojuego').append(option);
                    }
                    $('hr').fadeIn();
                    $('#form-otrojuego').fadeIn();
                } else {
                    $('hr').fadeOut();
                    $('#form-otrojuego').fadeOut();
                }

                $('#modalJuego').modal();
            }

            function cargaJuego(e) {
                e.preventDefault();
                id_juego = $('#nombre-otrojuego').val();
                nombre_juego = $('#nombre-otrojuego :selected').text();

                var fichas = $.ajax({
                    url: "<?= base_url('creadores/cargar_juego') ?>",
                    method: 'POST',
                    async: false,
                    dataType: 'json',
                    data: {
                        'id_juego': id_juego
                    }
                }).responseJSON;

                for (var i = 0; i < fichas.length; i++) {
                    cargaFichaAside(fichas[i].id_ficha, fichas[i].titulo,
                                    fichas[i].siguiente1, fichas[i].siguiente2);
                    if (fichas[i].final === 't') asideFinal(fichas[i].id_ficha);
                }

                $('header > h3').text(nombre_juego);
                id_ficha = fichas[0].id_ficha;
                asideInicio(id_ficha);
                cargaFicha(id_ficha);
                $('#modalJuego').modal('hide');
            }

            function nombreJuego(e) {
                e.preventDefault()
                var nombre_juego = $('#nombre-juego').val();
                var div = $('#nombre-juego').parent();

                if (nombre_juego.length > 50) {
                    $(div).find('span').css({color: '#a94446'});
                    $(div).addClass('has-error');
                    return;
                } else {
                    $(div).find('span').css({color: 'inherit'});
                    $(div).removeClass('has-error');
                }

                $('header > h3').text(nombre_juego);
                $('#modalJuego').modal('hide');

                id_juego = $.ajax({
                    async: false,
                    url: "<?= base_url('creadores/nuevo') ?>",
                    method: 'POST',
                    data: {
                        'nombre_juego': nombre_juego,
                        'usuario': <?= usuario_id() ?>
                    }
                }).responseText;

                $('#modalFicha').modal();
            }

            function nombreFicha(e) {
                e.preventDefault();
                var nombre_ficha = $('#nombre-ficha').val();

                var div = $('#nombre-ficha').parent();

                if (nombre_ficha.length > 50) {
                    $(div).find('span').css({color: '#a94446'});
                    $(div).addClass('has-error');
                    return;
                } else {
                    $(div).find('span').css({color: 'inherit'});
                    $(div).removeClass('has-error');
                }

                $('.titulo').text(nombre_ficha === '' || nombre_ficha === null ?
                                  'Clica aquí para cambiar el título' : nombre_ficha);
                $('#modalFicha').modal('hide');

                id_ficha = $.ajax({
                    async: false,
                    url: "<?= base_url('creadores/nueva') ?>",
                    method: 'POST',
                    data: {
                        'id_juego': id_juego,
                        'titulo': nombre_ficha
                    }
                }).responseText;

                nombre_ficha = nombre_ficha === null || nombre_ficha === '' ?
                                            '<Ficha sin título>' : nombre_ficha;

                var span = $('<span></span>').text(" [INICIO]").addClass('ficha-inicial');
                var p = $('<p></p>').text(nombre_ficha);
                var div = $('<div></div>').attr('id', id_ficha).append(span).append(p).append($('<ul></ul>'));
                $('aside').append(div);
                destacaAside(id_ficha);
            }

            function colorFondo() {
                var color = $(this).attr("value");

                $.ajax({
                    url: "<?= base_url('creadores/color_fondo') ?>",
                    method: 'POST',
                    data: {
                        'id_ficha': id_ficha,
                        'color': color
                    }
                });

                $('body').animate({backgroundColor: color}, 'fast');
                if (color === "#000000") {
                    $('#ficha p').animate({color: '#FFFFFF'}, 'fast');
                    $('#ficha h4').animate({color: '#0093c6'}, 'fast');
                } else if (color === "#4B698B") {
                    $('#ficha p').animate({color: '#FFFFFF'}, 'fast')
                    $('#ficha h4').animate({color: '#FFFFFF'}, 'fast');
                } else {
                    $('#ficha p').animate({color: '#000000'}, 'fast');
                    $('#ficha h4').animate({color: '#0093c6'}, 'fast');
                }
            }

            function numBotones() {
                var bool = $(this).attr("value");

                $.ajax({
                    url: "<?= base_url('creadores/numero_botones') ?>",
                    method: 'POST',
                    data: {
                        'id_ficha': id_ficha,
                        'bool': bool
                    }
                });

                if (bool === 'false') {
                    $(".botones > button:last-child")
                        .fadeIn();
                    $(".botones > button:nth-child(3)")
                        .fadeIn();
                } else {
                    $(".botones > button:last-child")
                        .fadeOut();
                    $(".botones > button:nth-child(3)")
                        .fadeOut();
                }
            }

            function colorBotones() {
                var color = $(this).attr("value");

                $.ajax({
                    url: "<?= base_url('creadores/color_botones') ?>",
                    method: 'POST',
                    data: {
                        'id_ficha': id_ficha,
                        'color': color
                    }
                });

                $('.botones > button:not(.siguiente)').animate({backgroundColor: color}, 'fast');
                if (color === "#000000" || color === "#4B698B") {
                    $('.botones > button:not(.siguiente)').animate({color: '#FFFFFF'}, 'fast');
                } else {
                    $('.botones > button:not(.siguiente)').animate({color: '#000000'}, 'fast');
                }
            }

            function contenidoBoton() {
                var boton = $(this).attr('value');
                var contenido = prompt('Introduce el contenido del botón');
                if (contenido === null) return;

                $.ajax({
                    url: "<?= base_url('creadores/contenido_boton') ?>",
                    method: 'POST',
                    data: {
                        'id_ficha': id_ficha,
                        'boton': boton,
                        'contenido': contenido
                    }
                });

                $(this).text(contenido);
            }

            function text() {
                $(this).fadeOut();
                $('.ocultoTitl :text').val($(this).text());
                $('.ocultoTitl')
                .css({
                    padding: "10px",
                    borderRadius: "15px 15px",
                    backgroundColor: "white"
                })
                .fadeIn();
            }

            function titulo() {
                var titulo = $('.ocultoTitl :text').val();

                if (titulo.length > 50) {
                    $('.ocultoTitl span').css({color: '#a94446'});
                    $('div.ocultoTitl').addClass('has-error');
                    return;
                } else {
                    $('.ocultoTitl span').css({color: 'inherit'});
                    $('div.ocultoTitl').removeClass('has-error');
                }

                $.ajax({
                    url: "<?= base_url('creadores/titulo') ?>",
                    method: 'POST',
                    data: {
                        'id_ficha': id_ficha,
                        'titulo': titulo
                    }
                });

                var div = document.getElementById(id_ficha);
                $(div).find('p').text(titulo === null || titulo === '' ?
                                      '<Ficha sin título>' : titulo);

                $('.ocultoTitl').fadeOut();
                $('h4.titulo').text(titulo === '' || titulo === null ?
                                    'Clica aquí para cambiar el título' : titulo)
                .fadeIn();
            }

            function cancelaTitulo() {
                $('.ocultoTitl span').css({color: 'inherit'});
                $('.ocultoTitl').removeClass('has-error');
                $('.ocultoTitl').fadeOut();
                $('#ficha > h4').fadeIn();
            }

            function textarea() {
                $(this).fadeOut();
                $('textarea').val($(this).text());
                $('.ocultoText')
                .css({
                    padding: "10px",
                    borderRadius: "15px 15px",
                    backgroundColor: "white"
                })
                .fadeIn();
            }

            function contenido() {
                var contenido = $('textarea').val();

                if (contenido.length > 500) {
                    $('.ocultoText span').css({color: '#a94446'});
                    $('div.ocultoText').addClass('has-error');
                    return;
                } else {
                    $('.ocultoText span').css({color: 'inherit'});
                    $('div.ocultoText').removeClass('has-error');
                }

                $.ajax({
                    url: "<?= base_url('creadores/contenido') ?>",
                    method: 'POST',
                    data: {
                        'id_ficha': id_ficha,
                        'contenido': contenido
                    }
                });

                $('.ocultoText').fadeOut();
                $('#ficha > p').text(contenido).fadeIn();
            }

            function cancelaContenido() {
                $('.ocultoText span').css({color: 'inherit'});
                $('.ocultoText').removeClass('has-error');
                $('.ocultoText').fadeOut();
                $('#ficha > p').fadeIn();
            }

            function siguienteFicha() {
                var siguiente = $(this).attr('value');

                if (siguiente === 'none') {
                    var boton = $(this).index()+1 === 1 ? 1 : 2;
                    ficha(boton);
                } else {
                    cargaFicha(siguiente);
                }
            }

            function cargaFichaLista() {
                var ficha = $(this).attr('id');
                cargaFicha(ficha);
            }

            function ficha(boton) {
                var res = $.ajax({
                    url: "<?= base_url('creadores/lista_fichas') ?>",
                    dataType: 'json',
                    method: 'POST',
                    async: false,
                    data: {
                        'id_juego': id_juego,
                        'id_ficha': id_ficha
                    }
                }).responseJSON;

                $('#nombre-otraficha').empty();
                if (res.display === true) {
                    for (var i = 0; i < res.lista.length; i++) {
                        var option = $('<option></option>')
                        .attr('value', res.lista[i].id_ficha)
                        .text(res.lista[i].titulo === '' ||
                              res.lista[i].titulo === null ?
                              '<ficha sin título>' : res.lista[i].titulo);
                        $('#nombre-otraficha').append(option);
                    }
                    $('hr').fadeIn();
                    $('#form-otraficha').fadeIn();
                } else {
                    $('hr').fadeOut();
                    $('#form-otraficha').fadeOut();
                }

                $('#hiddenFicha').val(boton);
                $('#nombre-fichanueva').val('');
                $('#modalFichaNueva').modal();
            }


            function nuevaFicha(e) {
                e.preventDefault();
                var titulo = $('#nombre-fichanueva').val();
                var div = $('#nombre-fichanueva').parent();

                if (titulo.length > 50) {
                    $(div).find('span').css({color: '#a94446'});
                    $(div).addClass('has-error');
                    return;
                } else {
                    $(div).find('span').css({color: 'inherit'});
                    $(div).removeClass('has-error');
                }

                var boton  = $('#hiddenFicha').val();
                $.ajax({
                    url: "<?= base_url('creadores/nueva_ficha') ?>",
                    method: 'POST',
                    data: {
                        'titulo': titulo,
                        'boton': boton
                    },
                    success: function() {
                        $('#modalFichaNueva').modal('hide');
                        var ficha = document.getElementById(id_ficha);
                        if (boton === "1") $(ficha).find('ul').prepend($('<li></li>').text(titulo));
                        else $(ficha).find('ul').append($('<li></li>').text(titulo));
                        $('#ficha').fadeOut(500, function(){
                            resetStyle();
                            idFicha();
                            $('.titulo').text(titulo === '' || titulo === null ?
                                              'Clica aquí para cambiar el título' : titulo);
                            $('#ficha').fadeIn(500);
                            anadeFichaAside(id_ficha, titulo);
                            destacaAside(id_ficha);
                        });
                    }
                });
            }

            function ligarFicha(e) {
                e.preventDefault();
                var id = $('#nombre-otraficha').val();
                var titulo = $('#nombre-otraficha').text();
                var boton = $('#hiddenFicha').val();

                $.ajax({
                    url: "<?= base_url('creadores/ligar_ficha') ?>",
                    method: 'POST',
                    data: {
                        'id': id,
                        'boton': boton
                    },
                    success: function() {
                        $('#modalFichaNueva').modal('hide');
                        var ficha = document.getElementById(id_ficha);
                        if (boton === "1") $(ficha).find('ul').prepend($('<li></li>').text(titulo));
                        else $(ficha).find('ul').append($('<li></li>').text(titulo));
                        $('#ficha').fadeOut(500, function(){
                            idFicha();
                            cargaFicha(id_ficha);
                            $('#ficha').fadeIn(500);
                            destacaAside(id_ficha);
                        });
                    }
                });
            }

            function cancelaFicha(e) {
                e.preventDefault();
                $('#modalFichaNueva').modal('hide');
            }

            function cargaFicha(id) {
                 var res = $.ajax({
                    async: false,
                    url: "<?= base_url('creadores/cargar_ficha') ?>",
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        'id': id
                    }
                }).responseJSON;

                $("#ficha").fadeOut(500, function() {
                    resetStyle();

                    var contenido = res.contenido === null || res.contenido === "" ?
                        "Clica aquí para cambiar el contenido" : res.contenido;
                    $("#ficha p").text(contenido);
                    var titulo = res.titulo === null ? '' : res.titulo;
                    $(".titulo").text(titulo);
                    var cont_boton1 = res.cont_boton1 === null ?
                        "Clica para cambiar el texto": res.cont_boton1;
                    $(".botones button:nth-child(2)").text(cont_boton1);
                    var cont_boton2 = res.cont_boton2 === null ?
                        "Clica para cambiar el texto": res.cont_boton2;
                    $(".botones button:nth-child(3)").text(cont_boton2);
                    var id_siguiente1 = res.id_siguiente1 === null ? 'none' : res.id_siguiente1;
                    $(".botones button:first-child").attr('value', id_siguiente1);
                    var id_siguiente2 = res.id_siguiente2 === null ? 'none' : res.id_siguiente2;
                    $(".botones button:last-child").attr('value', id_siguiente2);
                    id_ficha = id;

                    if (res.final === "t") {
                        $('.botones').fadeOut();
                    } else if (res.botones === "t") {
                        $('.botones button:last-child').fadeOut();
                        $('.botones button:nth-child(3)').fadeOut();
                    } else {
                        $('.botones button:last-child').fadeIn();
                        $('.fichas-siguientes button:last-child').fadeIn();
                    }

                    if (res.color_boton !== null) {
                        $('.botones > button:not(.siguiente)').animate({backgroundColor: res.color_boton}, 'fast');
                        if (res.color_boton === "#000000" || res.color_boton === "#4B698B") {
                            $('.botones > button:not(.siguiente)').animate({color: '#FFFFFF'}, 'fast');
                        } else {
                            $('.botones > button:not(.siguiente)').animate({color: '#000000'}, 'fast');
                        }
                    }

                    if (res.color_ficha !== null) {
                        $('body').animate({backgroundColor: res.color_ficha}, 'fast');
                        if (res.color_ficha === "#000000") {
                            $('#ficha p').animate({color: '#FFFFFF'}, 'fast');
                            $('#ficha h4').animate({color: '#0093c6'}, 'fast');
                        } else if (res.color_ficha === "#4B698B") {
                            $('#ficha p').animate({color: '#FFFFFF'}, 'fast')
                            $('#ficha h4').animate({color: '#FFFFFF'}, 'fast');
                        } else {
                            $('#ficha p').animate({color: '#000000'}, 'fast');
                            $('#ficha h4').animate({color: '#0093c6'}, 'fast');
                        }
                    }

                    if (res.imagen === "t") {
                        $('#ficha').css({
                            backgroundImage: "url(/images/juegos/"+id_ficha+".jpg)",
                            backgroundRepeat: "no-repeat",
                            backgroundPosition: "center"
                        });
                    }

                    $("#ficha").fadeIn(500).stop(true, true);
                    destacaAside(id);
                });

            }

            function resetStyle() {
                $('body').animate({backgroundColor: 'white'}, 'fast');
                $('*[style]').attr('style', '');
                $('.titulo').text('');
                $('#ficha p').text("Clica aquí para cambiar el contenido");
                $('.botones button:not(.siguiente)').text("Clica aquí para cambiar el texto");
            }

            function imagen() {
                $('#modalImagen').modal();
            }

            function subirImagen(e) {
                e.preventDefault();
                var fd = new FormData(this);

                $.ajax({
                    url: "<?= base_url('creadores/subir_imagen') ?>",
                    async: false,
                    type: 'post',
                    contentType: false,
                    processData: false,
                    data: fd,
                    success: function(res) {
                        if (res !== '') {
                            alert(typeof res);
                            $(".errores").html(res);
                            return;
                        }

                        $('#ficha').css({
                            backgroundImage: "url(/images/juegos/"+id_ficha+".jpg)",
                            backgroundRepeat: "no-repeat",
                            backgroundPosition: "center"
                        });
                        $('#modalImagen').modal('hide');
                    }
                });
            }

            function cancelaImagen(e) {
                e.preventDefault();
                $('#modalImagen').modal('hide');
            }
        </script>

        <header>
            <?= anchor('/portal/index', img(array('src' => 'images/logo.png',
                                                  'alt' => 'logo',
                                                  'class' => 'logo'))) ?>
            <h3><?= nombre_juego() ?></h3>
            <nav>
                <div class="group">
                    <h4>Fondo</h4>
                    <ul>
                        <li>
                            <span>Color</span>
                            <ul class="colFon">
                                <li><span value="#4B698B">Azul</span></li>
                                <li><span value="#D4D26A">Amarillo</span></li>
                                <li><span value="#FFFFFF">Blanco</span></li>
                                <li><span value="#000000">Negro</span></li>
                                <li><span value="#D46A6A">Rojo</span></li>
                                <li><span value="#55AA55">Verde</span></li>
                            </ul>
                        </li>
                        <li class="img"><span>Imagen<span></li>
                    </ul>
                </div>
                <div class="group">
                    <h4>Botones</h4>
                    <ul>
                        <li>
                            <span>Número</span>
                            <ul class="numBot">
                                <li><span value="true">1</span></li>
                                <li><span value="false">2</span></li>
                            </ul>
                        </li>
                        <li>
                            <span>Color</span>
                            <ul class="colBot">
                                <li><span value="#4B698B">Azul</span></li>
                                <li><span value="#D4D26A">Amarillo</span></li>
                                <li><span value="#FFFFFF">Blanco</span></li>
                                <li><span value="#000000">Negro</span></li>
                                <li><span value="#D46A6A">Rojo</span></li>
                                <li><span value="#55AA55">Verde</span></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="group">
                    <h4>Ficha</h4>
                    <ul>
                        <li class="final"><span>Final</span></li>
                    </ul>
                </div>
            </nav>
            <?= login() ?>
        </header>
        <!-- Modal -->
        <div class="modal fade" id="modalImagen" tabindex="-1" role="dialog"
            aria-labelledby="imagen" aria-hidden="true" data-backdrop="static"
            data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="cabeceraImagen">
                            Subir imagen
                        </h4>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <div class="errores"></div>
                        <form role="form" id="form-img">
                            <input type="file" accept="image/*" name="imagen" id="imagen" />
                            <button class="btn btn-success">Subir</button>
                        </form>
                    </div>
                    <div class="modal-footer footer-img">
                        <button class="btn btn-danger">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalJuego" tabindex="-1" role="dialog"
            aria-labelledby="nombre-juego" aria-hidden="true" data-backdrop="static"
            data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="cabeceraJuego">
                            Elige un nuevo juego, o un juego inacabado
                        </h4>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form role="form" id="formJuego">
                            <div class="form-group">
                                <label for="nombre-juego">Nombre del nuevo juego</label>
                                <br />
                                <span>Máximo 50 caracteres</span>
                                <input type="text" class="form-control"
                                    id="nombre-juego" pattern="^.+$" />
                            </div>
                            <button class="btn btn-success">Aceptar</button>
                        </form>
                        <hr />
                        <form role="form" id="form-otrojuego">
                            <div class="form-group">
                                <label for="nombre-otrojuego">Juego inacabado</label>
                                <select id="nombre-otrojuego"></select>
                            </div>
                            <button class="btn btn-success">Aceptar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalFicha" tabindex="-1" role="dialog"
            aria-labelledby="nombre-ficha" aria-hidden="true" data-backdrop="static"
            data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="cabeceraFicha">
                            Introduce el nombre de la primera ficha
                        </h4>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form role="form" id="form-ficha">
                            <div class="form-group">
                                <label for="nombre-ficha">Nombre de la ficha</label>
                                <br />
                                <span>Máximo 50 caracteres</span>
                                <input type="text" class="form-control" id="nombre-ficha" />
                            </div>
                            <button class="btn btn-success">Aceptar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalFichaNueva" tabindex="-1" role="dialog"
            aria-labelledby="nombre-fichanueva" aria-hidden="true" data-backdrop="static"
            data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="cabeceraFichaNueva">
                            Nueva ficha u otra anterior
                        </h4>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form role="form" id="form-fichanueva">
                            <input type=hidden id="hiddenFicha" />
                            <div class="form-group">
                                <label for="nombre-fichanueva">Nueva ficha</label>
                                <br />
                                <span>Máximo 50 caracteres</span>
                                <input type="text" class="form-control" id="nombre-fichanueva" />
                            </div>
                            <button class="btn btn-success">Aceptar</button>
                        </form>
                        <hr />
                        <form role="form" id="form-otraficha">
                            <div class="form-group">
                                <label for="nombre-otraficha">Otra ficha</label>
                                <select id="nombre-otraficha"></select>
                            </div>
                            <button class="btn btn-success">Aceptar</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="contenido">
            <aside><h4>Fichas</h4></aside>
            <div id="ficha">
                <?= mensajes() ?>
                <h4 class="titulo"></h4>
                <div class="ocultoTitl form-group">
                    <?= form_label('Titulo:', 'titulo') ?>
                    <br />
                    <span>Máximo 50 caracteres</span>
                    <?= form_input('titulo', set_value('titulo', '', FALSE),
                                    'class="form-control titulo"') ?>
                    <button class="btn btn-success">Cambiar contenido</button>
                    <button class="btn btn-danger">Cancelar</button>
                </div>

                <p class="contenido">Clica aquí para cambiar el contenido</p>
                <div class="ocultoText form-group">
                    <?= form_label('Contenido:', 'contenido') ?>
                    <br />
                    <span>Máximo 500 caracteres</span>
                    <?= form_textarea('contenido', set_value('contenido', '', FALSE),
                                      'class="form-control contenido"') ?>
                    <button class="btn btn-success">Cambiar contenido</button>
                    <button class="btn btn-danger">Cancelar</button>
                </div>
                <div class="botones">
                    <button class="btn btn-success siguiente" value="<?= ficha_siguiente(1) ?>">
                        <
                    </button>
                    <button class="btn btn-lg" value="1">Clica para cambiar el texto</button>
                    <button class="btn btn-lg" value="2">Clica para cambiar el texto</button>
                    <button class="btn btn-success siguiente" value="<?= ficha_siguiente(2) ?>">
                        >
                    </button>
                </div>
                <?= $contents ?>
            </div>
        </div>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
                integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
                crossorigin="anonymous"></script>
    </body>
</html>
