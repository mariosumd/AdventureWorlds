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
        $(document).ready(function() {
            $('.colFon span').on('click', window.opener.colorFondo);
            $('.img > span').on('click', window.opener.imagen);
            $('.colBot span').on('click', window.opener.colorBotones);
            $('.numBot span').on('click', window.opener.numBotones);
            $('.final span').on('click', window.opener.fichaFinal);
            $('.borrar span').on('click', window.opener.confirmar);
            $('.borrar-juego > span').on('click', window.opener.confirmar);
            $('.final-juego > span').on('click', window.opener.confirmar);
            $('.unlock img').on('click', cierraVentana);

            function cierraVentana() {
                window.opener.recuperaNav();
                window.close();
            }
        });
        </script>
        <header>
            <?= img(array('src' => 'images/logo.png', 'alt' => 'logo', 'class' => 'logoWin')) ?>
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
                        <li class="final"><span value="f">Final</span></li>
                        <li class="borrar"><span value="borrar la ficha">Borrar</span></li>
                    </ul>
                </div>
                <div class="group">
                    <h4>Juego</h4>
                    <ul>
                        <li class="final-juego"><span value="finalizar el juego">Finalizar</span></li>
                        <li class="borrar-juego"><span value="borrar el juego">Borrar</span></li>
                    </ul>
                </div>
                <div class="group unlock">
                    <img src="<?= base_url() ?>images/unlock.png"
                        title="Devolver barra de edición a su posición"
                        alt="Devolver barra de edición a su posición" />
                </div>
            </nav>
        </header>
    </body>
</html>
