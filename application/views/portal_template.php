<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= isset($title) ? $title : '' ?></title>
        <link href='https://fonts.googleapis.com/css?family=Press+Start+2P' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Candal' rel='stylesheet' type='text/css'>
        <?= link_tag('css/style.css') ?>
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
        <script src="<?= base_url() ?>js/jquery.cookie.js"></script>
        <script src="<?= base_url() ?>js/validator.js"></script>
        <!--<script id="rating" src="<?= base_url() ?>js/star-rating.min.js" type="text/javascript"></script>-->
    </head>
    <body>
	<script>
  	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
 		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
 		 })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  		ga('create', 'UA-79820500-1', 'auto');
  		ga('send', 'pageview');

	</script>
        <script>
            $(document).ready(function() {
                $('#logout').on("click", delCookie);
                $('.creador').on("click", function() { $(this).parent().submit() });
                cookie();
            });

            function cookie() {
                <?php if (logueado()): ?>
                    if (!$.cookie('usuario')) {
                        $.cookie('usuario', <?= usuario_id() ?>);
                    }
                <?php endif; ?>
            }

            function delCookie() {
                $.removeCookie('usuario');
            }
        </script>
        <header>
            <?= anchor('/portal/index', img(array('src' => 'images/logo.png',
                                                  'alt' => 'logo',
                                                  'class' => 'logo'))) ?>
            <?= anchor('/portal/index', img(array('src' => 'images/logo_letras.png',
                                                  'alt' => 'logo',
                                                  'class' => 'logoletras'))) ?>
            <a href="/portal/index">
                <div>
                    <h1>ADVENTURE WORLDS</h1>
                    <h2>Crea tu propia aventura</h2>
                </div>
            </a>
            <?= login() ?>
        </header>
        <div id="contenido">
            <?= mensajes() ?>
            <div class="div-buttons">
                <?= crear() ?>
                <?= tutorial() ?>
            </div>
            <?= $contents ?>
        </div>
        <footer>
            <?= anchor('/portal/sobre', 'Sobre nosotros') ?>
            <?= anchor('/portal/contacta', 'Contacta') ?>
        </footer>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
                integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
                crossorigin="anonymous"></script>
    </body>
</html>
