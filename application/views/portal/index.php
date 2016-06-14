<?php portal_template_set('title', 'Portal') ?>

<script>
    var busqueda = '';
    var offset   = 1;
    var totalScroll = <?= $total_scroll ?>;

    $(document).ready(function() {
        $('#buscar').on('submit', buscar);
        $('.mas').on('click', mas);
        if (offset >= totalScroll) $('.mas').hide();
    });

    function buscar(e) {
        e.preventDefault()
        busqueda = $("#buscar input:text").val();

        var lista = $.ajax({
            url: "<?= base_url('portal/buscar') ?>",
            method: 'POST',
            dataType: 'json',
            async: false,
            data: {
                'busqueda': busqueda,
                'offset': 0
            }
        }).responseJSON;
        offset = 1;
        if (lista.display === false) {
            $('#juegos > *').not('.mas').remove().prepend('<h3>No se encontraron juegos...</h3>');
            $('.mas').hide();
        } else {
            $('#juegos > *').not('.mas').remove();
            for (var i = 0; i < lista.juegos.length; i++) {
                var juego =
                $('<a href="<?= base_url('juegos/jugar') ?>/'+lista.juegos[i].id_juego+'">'+
                      '<h5>'+lista.juegos[i].nombre_juego+'</h5>'+
                      '<p>Creado por <span>'+lista.juegos[i].nombre_usuario+'</span></p>'+
                   '</a>')

                $('.mas').before(juego);
            }
            totalScroll = lista.total_scroll;
            if (offset >= totalScroll) $('.mas').hide();
            else $('.mas').show();
        }
    }

    function mas() {
        $('.mas').prop('disabled', true);
        var lista = $.ajax({
            url: "<?= base_url('portal/buscar') ?>",
            method: 'POST',
            dataType: 'json',
            async: false,
            data: {
                'busqueda': busqueda,
                'offset': offset
            }
        }).responseJSON;

        for (var i = 0; i < lista.juegos.length; i++) {
            var juego =
            $('<a href="<?= base_url('juegos/jugar') ?>/'+lista.juegos[i].id_juego+'">'+
                  '<h5>'+lista.juegos[i].nombre_juego+'</h5>'+
                  '<p>Creado por <span>'+lista.juegos[i].nombre_usuario+'</span></p>'+
               '</a>')

            $('.mas').before(juego);
        }
        offset++;

        if (offset >= totalScroll) {
            $('.mas').hide();
            $('.mas').prop('disabled', false);
        } else {
            $('.mas').prop('disabled', false);
        }
    }
</script>

<form role="form" id="buscar">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Buscar...">
        <span class="input-group-btn">
            <button class="btn btn-primary" type="button">Buscar</button>
        </span>
    </div>
</form>
<div id="juegos">
<?php if ($lista !== FALSE): ?>
    <?php foreach($lista as $juego): ?>
        <a href="<?= base_url('juegos/jugar').'/'.$juego['id_juego'] ?>">
            <h5><?= $juego['nombre_juego'] ?></h5>
            <p>Creado por <span><?= $juego['nombre_usuario'] ?></span></p>
        </a>
    <?php endforeach; ?>
    <button class="mas btn btn-primary">Cargar Más</button>
<?php else: ?>
    <h3>No se encontraron juegos...</h3>
<?php endif; ?>
</div>
