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
                $('#modalJuego button').on('click', nombreJuego);
                $('#modalFicha button').on('click', nombreFicha);
                $('#modalFichaNueva button:first-of-type').on('click', ficha);
                $('#modalFichaNueva button:last-of-type').on('click', cancelaFicha);
                $('.colFon span').on('click', colorFondo);
                $('.colBot span').on('click', colorBotones);
                $('.numBot span').on('click', numBotones);
                $('.final span').on('click', fichaFinal);
                $('.botones button:not(.siguiente)').on('click', contenidoBoton);
                $('h4.titulo').on('click', text);
                $('.ocultoTitl > button:first-of-type').on('click', titulo);
                $('.ocultoTitl > button:last-of-type').on('click', cancelaTitulo);
                $('#ficha > p').on('click', textarea);
                $('.ocultoText > button:first-of-type').on('click', contenido);
                $('.ocultoText > button:last-of-type').on('click', cancelaContenido);
                $('.siguiente').on('click', siguienteFicha);
                $('.atras').on('click', anteriorFicha);
                $('aside > p').on('click', cargaFichaLista);
                //$(window).on('beforeunload', confirmarSalida);
                //$(window).on('unload', borraJuego);
                botonAtras('none');
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

            function anadeFichaAside(id_ficha, titulo) {
                titulo = titulo === null || titulo === '' ? '<Ficha sin título>' : titulo;

                var p = $('<p></p>')
                    .text(titulo)
                    .attr('id', id_ficha)
                    .on('click', cargaFichaLista);;
                $('aside').append(p);
            }

            function destacaAside(id) {
                var p = document.getElementById(id);
                $('aside > p').removeClass('destacado').on('click', cargaFichaLista);;
                $(p).addClass('destacado').off('click');
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

            function nuevoJuego() {
                $('#modalJuego').modal();
            }

            function nombreJuego(e) {
                e.preventDefault()
                var nombre_juego = $('#nombre-juego').val();
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
                $('.titulo').text(nombre_ficha === '' || nombre_ficha === null
                                ? 'Clica aquí para cambiar el título' : nombre_ficha);
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
                var p = $('<p></p>').text(nombre_ficha).attr('id', id_ficha).append(span);
                $('aside').append(p);
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

            function text() {
                $(this).fadeOut();
                $('.ocultoTitl :text').val($(this).text());
                $('.ocultoTitl').fadeIn();
            }

            function titulo() {
                var titulo = $('.ocultoTitl :text').val();

                $.ajax({
                    url: "<?= base_url('creadores/titulo') ?>",
                    method: 'POST',
                    data: {
                        'id_ficha': id_ficha,
                        'titulo': titulo
                    }
                });

                var aside = document.getElementById(id_ficha);
                var span = $(aside).find("span.ficha-inicial").length != 0 ?
                    $('<span></span>').text(' [INICIO]').addClass('ficha-inicial') :
                    '';
                $(aside).text(titulo).append(span);

                $('.ocultoTitl').fadeOut();
                $('h4.titulo').text(titulo).fadeIn();
            }

            function cancelaTitulo() {
                $('.ocultoTitl').fadeOut();
                $('#ficha > h4').fadeIn();
            }

            function textarea() {
                $(this).fadeOut();
                $('textarea').val($(this).text());
                $('.ocultoText').fadeIn();
            }

            function contenido() {
                alert('hola');
                var contenido = $('textarea').val();

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
                $('.ocultoText').fadeOut();
                $('#ficha > p').fadeIn();
            }

            function siguienteFicha() {
                var siguiente = $(this).attr('value');

                if (siguiente === 'none') {
                    var boton = $(this).index()+1 === 1 ? 1 : 2;
                    nuevaFicha(boton);
                } else {
                    cargaFicha(siguiente);
                }
            }

            function cargaFichaLista() {
                var ficha = $(this).attr('id');
                cargaFicha(ficha);
            }

            function nuevaFicha(boton) {
                $('#hiddenFicha').val(boton);
                $('#nombre-fichanueva').val('');
                $('#modalFichaNueva').modal();
            }


            function ficha(e) {
                e.preventDefault();
                var titulo = $('#nombre-fichanueva').val();
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
                        $('#ficha').fadeOut(500, function(){
                            resetStyle();
                            botonAtras(id_ficha);
                            idFicha();
                            $('.titulo').text(titulo);
                            $('#ficha').fadeIn(500);
                            anadeFichaAside(id_ficha, titulo);
                            destacaAside(id_ficha);
                        });
                    }
                });
            }

            function cancelaFicha(e) {
                e.preventDefault();
                $('#modalFichaNueva').modal('hide');
            }

            function anteriorFicha() {
                var anterior = $(this).attr('value');
                cargaFicha(anterior);
                destacaAside(anterior);
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
                    botonAtras(res.id_anterior === null ? 'none' : res.id_anterior);
                    idFicha();

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
                    $("#ficha").fadeIn(500).stop(true, true);
                    destacaAside(id);
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
                $('.botones button:not(.siguiente)').text("Clica aquí para cambiar el texto");
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
        <!-- Modal -->
        <div class="modal fade" id="modalJuego" tabindex="-1" role="dialog"
            aria-labelledby="nombre-juego" aria-hidden="true" data-backdrop="static"
            data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="cabeceraJuego">
                            Introduce el nombre del juego
                        </h4>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form role="form" id="formJuego">
                            <div class="form-group">
                                <label for="nombre-juego">Nombre del juego</label>
                                <input type="text" class="form-control"
                                    id="nombre-juego" pattern="^.+$" />
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
                            Introduce el nombre de la ficha
                        </h4>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form role="form" id="form-ficha">
                            <div class="form-group">
                                <label for="nombre-ficha">Nombre de la ficha</label>
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
                            Introduce el nombre de la ficha
                        </h4>
                    </div>
                    <!-- Modal Body -->
                    <div class="modal-body">
                        <form role="form" id="form-fichanueva">
                            <input type=hidden id="hiddenFicha" />
                            <div class="form-group">
                                <label for="nombre-fichanueva">Nombre de la ficha</label>
                                <input type="text" class="form-control" id="nombre-fichanueva" />
                            </div>
                            <button class="btn btn-success">Aceptar</button>
                            <button class="btn btn-danger">Cancelar</button>
                        </form>
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
                    <?= form_input('titulo', set_value('titulo', '', FALSE),
                                    'class="form-control titulo"') ?>
                    <button class="btn btn-success">Cambiar contenido</button>
                    <button class="btn btn-danger">Cancelar</button>
                </div>
                <p class="contenido">Clica aquí para cambiar el contenido</p>
                <div class="ocultoText form-group">
                    <?= form_label('Contenido:', 'contenido') ?>
                    <p class="small">Máximo 500 caracteres</p>
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
                <button class="btn btn-danger atras">Atrás</button>
                <?= $contents ?>
            </div>
        </div>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
                integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
                crossorigin="anonymous"></script>
    </body>
</html>
