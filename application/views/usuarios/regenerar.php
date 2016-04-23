<?php portal_template_set('title', 'Regenerar') ?>

<div class="container-fluid" style="padding-top:20px">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-custom">
        <div class="panel-heading">
          <h3 class="panel-title">Regenerar</h3>
        </div>
        <div class="panel-body">
          <?php if ( ! empty(error_array())): ?>
            <div class="alert alert-danger" role="alert">
              <?= validation_errors() ?>
            </div>
          <?php endif ?>
          <?= form_open("usuarios/regenerar/$usuario_id/$token") ?>
            <div class="form-group">
              <?= form_label('Contraseña:', 'password') ?>
              <?= form_password('password', set_value('password', '', FALSE),
                             'id="password" class="form-control"') ?>
            </div>
            <div class="form-group">
              <?= form_label('Confirmar Contraseña:', 'password_confirm') ?>
              <?= form_password('password_confirm', set_value('password_confirm', '', FALSE),
                             'id="password_confirm" class="form-control"') ?>
            </div>
            <?= form_submit('regenerar', 'Regenerar Contraseña', 'class="btn btn-success"') ?>
            <?= anchor('/usuarios/login', 'Volver', 'class="btn btn-info" role="button"') ?>
          <?= form_close() ?>
        </div>
      </div>
    </div>
  </div>
</div>
