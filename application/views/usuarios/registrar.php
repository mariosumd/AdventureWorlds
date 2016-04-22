<?php template_set('title', 'Registro') ?>

<div class="container-fluid" style="padding-top:20px">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-custom">
        <div class="panel-heading">
          <h3 class="panel-title">Registro</h3>
        </div>
        <div class="panel-body">
          <?php if ( ! empty(error_array())): ?>
            <div class="alert alert-danger" role="alert">
              <?= validation_errors() ?>
            </div>
          <?php endif ?>
          <?= form_open('usuarios/registrar') ?>
            <div class="form-group">
              <?= form_label('Nombre:', 'nombre') ?>
              <?= form_input('nombre', set_value('nombre', '', FALSE),
                             'id="nombre" class="form-control"') ?>
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
              <?= form_label('Confirmar Contraseña:', 'password_confirm') ?>
              <?= form_password('password_confirm', '',
                                'id="password_confirm" class="form-control"') ?>
            </div>
            <?= form_submit('registrar', 'Registrar', 'class="btn btn-success"') ?>
            <?= anchor('/usuarios/login', 'Volver', 'class="btn btn-info" role="button"') ?>
          <?= form_close() ?>
        </div>
      </div>
    </div>
  </div>
</div>
