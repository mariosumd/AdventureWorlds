<?php portal_template_set('title', 'Contacta') ?>
<script>
    $(document).ready(function() {
        $('textarea').on('input', caracteres);
        caracteres();
    });

    function caracteres() {
        var caracteres = 500;
        var restante = caracteres - $('textarea').val().length;
        $('p > span').text(restante);
        if (restante < 0) {
            $('p.small').css({color: 'red'});
            $('textarea').addClass('has-error has-danger');
            $(':submit').prop('disabled', true);
        }
        else {
            $('p.small').css({color: 'black'});
            $('textarea').removeClass('has-error has-danger');
            $(':submit').prop('disabled', false);
        }
    }
</script>
<div class="contacta">
    <div class="form">
        <h3>Completa el siguiente formulario para contactar</h3>
        <?php if ( ! empty(error_array())): ?>
          <div class="alert alert-danger" role="alert">
            <?= validation_errors() ?>
          </div>
        <?php endif ?>
        <?= form_open('portal/contacta', 'data-toggle="validator"') ?>
          <div class="form-group">
            <?= form_label('Nombre:', 'nombre') ?>
            <?= form_input('nombre', set_value('nombre', '', FALSE),
                           'id="nombre" pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}$"'.
                           ' required class="form-control contacta"') ?>
          </div>

          <div class="form-group">
            <?= form_label('Email:', 'email') ?>
            <?= form_email('email', set_value('email', '', FALSE),
                           'id="email" required class="form-control contacta"') ?>
          </div>

          <div class="form-group">
            <?= form_label('Comentario:', 'comentario') ?>
            <p class="small"><span>500</span> caracteres restantes</p>
            <?= form_textarea('comentario', set_value('comentario', '', FALSE),
                              'id="comentario" pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,500}$"'.
                              ' required class="form-control contacta"') ?>
          </div>
          <?= form_submit('enviar', 'Enviar', 'class="btn btn-success"') ?>
        <?= form_close() ?>
    </div>

    <div class="feedback">
        <h3>¡Necesitamos tus comentarios!</h3>
        <p>
            El "feedback" siempre es necesario. Si tienes alguna idea, comentario,
            o has encontrado un bug, no dudes en hacérnoslo saber.
        </p>
        <p>
            Construyamos una comunidad de apasionados por las aventuras y las
            historias.
        </p>
        <?= img("images/logo.png") ?>
    </div>
</div>
