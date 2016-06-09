<?php portal_template_set('title', 'Inicio') ?>

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
<?php else: ?>
    <h3>No se encontraron juegos...</h3>
<?php endif; ?>
</div>
