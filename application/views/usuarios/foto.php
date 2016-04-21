<?php template_set('title', 'Subir Foto') ?>

<div class="container-fluid" style="padding-top:20px">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Subir Foto</h3>
        </div>
        <div class="panel-body">
          <?php if ( ! empty($error)): ?>
            <div class="alert alert-danger" role="alert">
              <?= $error ?>
            </div>
          <?php endif ?>
          <div class="alert alert-success" role="alert">
              <p>Formatos Admitidos: jpeg, jpg y jpe</p>
              <p>Tamaño Maximo: 100 Kbytes</p>
              <p>Alto Maximo: 250 pixeles</p>
              <p>Ancho Maximo: 250 pixeles</p>
          </div>
          <?= form_open_multipart('usuarios/foto/' . $id) ?>
            <div class="form-group">
              <?= form_label('Foto:', 'foto') ?>
              <?= form_upload('foto', set_value('foto', '', FALSE),
                             'id="foto" accept="image/*" class="form-control"') ?>
            </div>
            <?= form_submit('insertar', 'Insertar', 'class="btn btn-success"') ?>
            <?= anchor('/usuarios/login', 'Volver', 'class="btn btn-info" role="button"') ?>
          <?= form_close() ?>
        </div>
      </div>
    </div>
  </div>
</div>
