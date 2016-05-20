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
                $('.colFon span').on('click', colorFondo);
                $('.colBot span').on('click', colorBotones);
                $('.numBot span').on('click', numBotones);
                $('.final span').on('click', fichaFinal);
                $('.botones button').on('click', contenidoBoton);
                $('#ficha > p').on('click', textarea);
                $('.oculto button').on('click', contenido);
                $('.fichas-siguientes button').on('click', siguienteFicha);
                $('.atras').on('click', anteriorFicha);
                $(window).on('beforeunload', confirmarSalida);
                $(window).on('unload', borraJuego);
                idFicha();
                botonAtras('none');
                cookie();
            });

            function cookie() {
                <?php if (logueado()): ?>
                    if (!$.cookie('usuario')) {
                        $.cookie('usuario', <?= $usuario_id ?>);
                    }

                    id_usuario = <?= $usuario_id ?>
                <?php endif; ?>
            }

            function delCookie() {
                $.removeCookie('usuario');
            }

            function confirmarSalida() {
                return 'Si sales de la página sin terminar el juego, se borrará.'+
                       ' ¿Estás seguro de que quieres salir?';
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

            function fichaFinal() {
                $.ajax({
                    url: "<?= base_url('creadores/ficha_final') ?>",
                    method: 'POST',
                    data: {
                        'id_ficha': id_ficha
                    }
                });

                $('.botones').fadeOut();
                $('.fichas-siguientes').fadeOut();
            }

            function nuevoJuego() {
                var nombre_juego;
                var nombre_ficha;

                do {
                    nombre_juego = prompt("Introduce el nombre del nuevo juego.");
                } while (!nombre_juego || /^\s+$/.test(nombre_juego));

                $('header > h3').text(nombre_juego);

                nombre_ficha = prompt("Introduce el nombre de la primera pantalla");

                $('.titulo').text(nombre_ficha);

                id_juego = $.ajax({
                    async: false,
                    url: "<?= base_url('creadores/nuevo') ?>",
                    method: 'POST',
                    data: {
                        'nombre_juego': nombre_juego,
                        'usuario': <?= usuario_id() ?>,
                        'nombre_ficha': nombre_ficha
                    }
                }).responseText;
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
                    $(".fichas-siguientes > button:last-child")
                        .fadeIn();
                } else {
                    $(".botones > button:last-child")
                        .fadeOut();
                    $(".fichas-siguientes > button:last-child")
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

                $('.botones > button').animate({backgroundColor: color}, 'fast');
                if (color === "#000000" || color === "#4B698B") {
                    $('.botones > button').animate({color: '#FFFFFF'}, 'fast');
                } else {
                    $('.botones > button').animate({color: '#000000'}, 'fast');
                }
            }

            function contenidoBoton() {
                var boton = $(this).attr('value');
                var contenido = prompt('Introduce el contenido del botón');
                contenido = contenido === null ? '' : contenido

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

            function textarea() {
                $(this).fadeOut();
                $('textarea').val($(this).text());
                $('.oculto').fadeIn();
            }

            function contenido() {
                contenido = $('textarea').val();

                $.ajax({
                    url: "<?= base_url('creadores/contenido') ?>",
                    method: 'POST',
                    data: {
                        'id_ficha': id_ficha,
                        'contenido': contenido
                    }
                });

                $('.oculto').fadeOut();
                $('#ficha > p').text(contenido).fadeIn();
            }

            function siguienteFicha() {
                var siguiente = $(this).attr('value');

                if (siguiente === 'none') {
                    var boton = $(this).index()+1;
                    nuevaFicha(boton);
                } else {
                    cargaFicha(siguiente);
                }
            }

            function nuevaFicha(boton) {
                var titulo = prompt("Introduce el nombre de la siguiente ficha");

                if (titulo === null) return;

                $.ajax({
                    url: "<?= base_url('creadores/nueva_ficha') ?>",
                    method: 'POST',
                    data: {
                        'titulo': titulo,
                        'boton': boton
                    },
                    success: function() {
                        $('#ficha').fadeOut(500, function(){
                            resetStyle();
                            botonAtras(id_ficha);
                            idFicha();
                            $('.titulo').text(titulo);
                            $('#ficha').fadeIn(500);
                        });
                    }
                });
            }

            function anteriorFicha() {
                var anterior = $(this).attr('value');
                cargaFicha(anterior);
            }

            var res;

            function cargaFicha(id) {
                 res = $.ajax({
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
                    $(".botones button:first-child").text(cont_boton1);
                    var cont_boton2 = res.cont_boton2 === null ?
                        "Clica para cambiar el texto": res.cont_boton2;
                    $(".botones button:last-child").text(cont_boton2);
                    var id_siguiente1 = res.id_siguiente1 === null ? 'none' : res.id_siguiente1;
                    $(".fichas-siguientes button:first-child").attr('value', id_siguiente1);
                    var id_siguiente2 = res.id_siguiente2 === null ? 'none' : res.id_siguiente2;
                    $(".fichas-siguientes button:last-child").attr('value', id_siguiente2);
                    botonAtras(res.id_anterior === null ? 'none' : res.id_anterior);
                    idFicha();

                    if (res.final === "t") {
                        $('.botones').fadeOut();
                        $('.fichas-siguientes').fadeOut();
                    } else if (res.botones === "t") {
                        $('.botones button:last-child').fadeOut();
                        $('.fichas-siguientes button:last-child').fadeOut();
                    } else {
                        $('.botones button:last-child').fadeIn();
                        $('.fichas-siguientes button:last-child').fadeIn();
                    }

                    if (res.color_boton !== null) {
                        $('.botones > button').animate({backgroundColor: res.color_boton}, 'fast');
                        if (res.color_boton === "#000000" || res.color_boton === "#4B698B") {
                            $('.botones > button').animate({color: '#FFFFFF'}, 'fast');
                        } else {
                            $('.botones > button').animate({color: '#000000'}, 'fast');
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
                    $("#ficha").fadeIn(500);
                });

            }

            function botonAtras(anterior) {
                if (anterior === 'none') {
                    $('.atras').fadeOut();
                } else {
                    $('.atras').attr('value', anterior).fadeIn();

                }
            }

            function resetStyle() {
                $('*[style]').attr('style', '');
                $('.titulo').text('');
                $('#ficha p').text("Clica aquí para cambiar el contenido");
                $('.botones button').text("Clica aquí para cambiar el texto");
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
                        <li class="img"><a href="">Imagen</a></li>
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
        <div id="ficha">
            <?= mensajes() ?>
            <h4 class="titulo"></h4>
            <p class="contenido">Clica aquí para cambiar el contenido</p>
            <div class="oculto form-group">
                <?= form_label('Contenido:', 'contenido') ?>
                <p class="small">Máximo 500 caracteres</p>
                <?= form_textarea('contenido', set_value('contenido', '', FALSE),
                                  'class="form-control contenido"') ?>
                <button class="btn btn-success">Cambiar contenido</button>
            </div>
            <div class="botones">
                <button class="btn btn-lg" value="1">Clica para cambiar el texto</button>
                <button class="btn btn-lg" value="2">Clica para cambiar el texto</button>
            </div>
            <div class="fichas-siguientes">
                <button class="btn btn-success" value="<?= ficha_siguiente(1) ?>">
                    Ir a siguiente ficha por aquí
                </button>
                <button class="btn btn-success" value="<?= ficha_siguiente(2) ?>">
                    Ir a siguiente ficha por aquí
                </button>
            </div>
            <button class="btn btn-danger atras">Atrás</button>
            <?= $contents ?>
        </div>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
                integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
                crossorigin="anonymous"></script>
    </body>
</html>
