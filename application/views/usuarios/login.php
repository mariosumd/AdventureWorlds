<?php portal_template_set('title', 'Login') ?>

<script>
    $(document).ready(function() {
        $('#login').on('submit', validaLogin);
    });

    function validaLogin(e) {
        e.preventDefault()
        $.ajax({
            url: "<?= base_url('usuarios/validar_login') ?>",
            method: 'POST',
            data: {
                'nombre': $('#nombre').val(),
                'passwd': $('#password').val()
            },
            success: function(r) {
                if (r === 'TRUE') {
                    $('#login > span').fadeOut();
                    $('.form-group').removeClass('has-error');
                    $('form#login').off('submit').submit({'login': true});
                } else {
                    $('#login > span').fadeIn();
                    $('.form-group').addClass('has-error');
                }
            }
        });
    }
</script>

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
          <?= form_open('usuarios/login', array('id' => 'login')) ?>
            <span>El usuario o la contraseña no es correcta</span>
            <div class="form-group">
              <?= form_label('Nombre:', 'nombre') ?>
              <?= form_input('nombre', set_value('nombre', '', FALSE),
                             'id="nombre" class="form-control"') ?>
            </div>
            <div class="form-group">
              <?= form_label('Contraseña:', 'password') ?>
              <?= form_password('password', '',
                                'id="password" class="form-control"') ?>
            </div>
            <?= form_submit('login', 'Login', 'class="btn btn-success"') ?>
            <?= anchor('/usuarios/recordar', 'Recordar Contraseña', 'class="btn btn-info" role="button"') ?>
            <?= anchor('/usuarios/registrar', 'Registrarse', 'class="btn btn-info" role="button"') ?>
          <?= form_close() ?>
        </div>
      </div>
    </div>
  </div>
</div>
