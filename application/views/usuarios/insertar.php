<?php template_set('title', 'Insertar un usuario') ?>

<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Insertar usuario</h3>
      </div>
      <div class="panel-body">
        <?php if (count(error_array()) > 0): ?>
          <div class="alert alert-danger" role="alert">
            <?= validation_errors() ?>
          </div>
        <?php endif ?>
        <?= form_open('usuarios/insertar') ?>
          <div class="form-group">
            <?= form_label('Nick:', 'nick') ?>
            <?= form_input('nick', set_value('nick', '', FALSE),
                           'id="nick" class="form-control"') ?>
          </div>
          <div class="form-group">
            <?= form_label('Email:', 'email') ?>
            <?= form_input(array(
                          'type' => 'email',
                          'name' => 'email',
                          'id' => 'email',
                          'value' => set_value('email', '', FALSE),
                          'class' => 'form-control'
            )) ?>
          </div>
          <div class="form-group">
            <?= form_label('Contraseña:', 'password') ?>
            <?= form_password('password', '',
                              'id="password" class="form-control"') ?>
          </div>
          <div class="form-group">
            <?= form_label('Confirmar contraseña:', 'password_confirm') ?>
            <?= form_password('password_confirm', '',
                              'id="password_confirm" class="form-control"') ?>
          </div>
          <div class="form-group">
            <?= form_label('Rol:', 'rol_id') ?>
            <?= form_dropdown('rol_id', $roles, set_value('rol_id'),
                              'id="password" class="form-control"') ?>
          </div>
          <?= form_submit('insertar', 'Insertar', 'class="btn btn-success"') ?>
          <?= anchor('/usuarios/index', 'Cancelar',
                     'class="btn btn-danger" role="button"') ?>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</div>
