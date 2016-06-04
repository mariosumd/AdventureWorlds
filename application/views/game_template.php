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
        <?= link_tag('css/game.css') ?>
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
            var id_ficha = <?= $id_ficha ?>;
            var id_juego = <?= $id_juego ?>;
            var id_usuario;

            $(document).ready(function() {
                $('#logout').on('click', delCookie);
                $(document).on('beforeunload', confirmaSalida);
                $('.botones button').on('click', siguienteFicha);
                cargaFicha(<?= $id_ficha ?>);
                cookie();
            });

            function confirmaSalida() {
                return '¿Estás seguro de que quieres salir?';
            }

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

            function idFicha() {
                id_ficha = $.ajax({
                    async: false,
                    url: "<?= base_url('creadores/id_ficha') ?>"
                }).responseText;
            }

            function siguienteFicha() {
                idSiguiente = $(this).val();

                if (idSiguiente !== 'none') cargaFicha(idSiguiente);
                else alert('El creador ha dejado este botón sin salida.');
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
                        "" : res.contenido;
                    $("#ficha p").text(contenido);
                    var titulo = res.titulo === null ? '' : res.titulo;
                    $(".titulo").text(titulo);
                    var cont_boton1 = res.cont_boton1 === null ?
                        "": res.cont_boton1;
                    $(".botones button:first-child").text(cont_boton1);
                    var cont_boton2 = res.cont_boton2 === null ?
                        "": res.cont_boton2;
                    $(".botones button:last-child").text(cont_boton2);
                    var id_siguiente1 = res.id_siguiente1 === null ? 'none' : res.id_siguiente1;
                    $(".botones button:first-child").attr('value', id_siguiente1);
                    var id_siguiente2 = res.id_siguiente2 === null ? 'none' : res.id_siguiente2;
                    $(".botones button:last-child").attr('value', id_siguiente2);
                    id_ficha = id;

                    if (res.final === "t") {
                        $('.botones').fadeOut();
                    } else if (res.botones === "t") {
                        $('.botones button:last-child').fadeOut();
                    } else {
                        $('.botones button:last-child').fadeIn();
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
                            $('header h4').animate({color: '#0093c6'}, 'fast');
                            $('header label').animate({color: '#FFFFFF'}, 'fast');
                        } else if (res.color_ficha === "#4B698B") {
                            $('#ficha p').animate({color: '#FFFFFF'}, 'fast')
                            $('#ficha h4').animate({color: '#FFFFFF'}, 'fast');
                            $('header h4').animate({color: '#FFFFFF'}, 'fast');
                            $('header label').animate({color: '#FFFFFF'}, 'fast');
                        } else {
                            $('#ficha p').animate({color: '#000000'}, 'fast');
                            $('#ficha h4').animate({color: '#0093c6'}, 'fast');
                            $('header h4').animate({color: '#0093c6'}, 'fast');
                            $('header label').animate({color: '#000000'}, 'fast');
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
                });

            }

            function resetStyle() {
                $('body').animate({backgroundColor: 'white'}, 'fast');
                $('*[style]').attr('style', '');
                $('.titulo').text('');
                $('#ficha p').text("Clica aquí para cambiar el contenido");
                $('.botones button:not(.siguiente)').text("Clica aquí para cambiar el texto");
            }
        </script>

        <header>
            <a href="<?= base_url('portal/index') ?>">
                <img src="<?= base_url() ?>images/logo_letras.png" class="logo" alt="logo" />
            </a>
            <h3><?= $nombre_juego ?></h3>
            <?= login() ?>
        </header>

        <div id="contenido">
            <?= mensajes() ?>
            <div>
                <div id="ficha">
                    <h4 class="titulo"></h4>
                    <p class="contenido"></p>
                    <div class="botones">
                        <button class="btn btn-lg" value="1"></button>
                        <button class="btn btn-lg" value="2"></button>
                    </div>
                    <?= $contents ?>
                </div>
            </div>
        </div>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
                integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
                crossorigin="anonymous"></script>
    </body>
</html>
