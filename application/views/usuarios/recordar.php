<?php portal_template_set('title', 'Recordar') ?>

<div class="container-fluid" style="padding-top:20px">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-custom">
        <div class="panel-heading">
          <h3 class="panel-title">Login</h3>
        </div>
        <div class="panel-body">
          <?php if ( ! empty(error_array())): ?>
            <div class="alert alert-danger" role="alert">
              <?= validation_errors() ?>
            </div>
          <?php endif ?>
          <?= form_open('usuarios/recordar') ?>
            <div class="form-group">
              <?= form_label('Nombre:', 'nombre') ?>
              <?= form_input('nombre', set_value('nombre', '', FALSE),
                             'id="nombre" class="form-control"') ?>
            </div>
            <?= form_submit('recordar', 'Recordar Contraseña', 'class="btn btn-success"') ?>
            <?= anchor('/usuarios/login', 'Volver', 'class="btn btn-info" role="button"') ?>
          <?= form_close() ?>
        </div>
      </div>
    </div>
  </div>
</div>
