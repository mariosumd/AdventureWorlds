<?php portal_template_set('title', 'Contacta') ?>
<div class="contacta">
    <div class="form">
        <h4>Completa el siguiente formulario para contactar</h4>
        <?php if ( ! empty(error_array())): ?>
          <div class="alert alert-danger" role="alert">
            <?= validation_errors() ?>
          </div>
        <?php endif ?>
        <?= form_open('portal/contacta') ?>
          <div class="form-group">
            <?= form_label('Nombre:', 'nombre') ?>
            <?= form_input('nombre', set_value('nombre', '', FALSE),
                           'id="nombre" class="form-control contacta"') ?>
          </div>

          <div class="form-group">
            <?= form_label('Email:', 'email') ?>
            <?= form_input('email', set_value('email', '', FALSE),
                           'id="nombre" class="form-control contacta"') ?>
          </div>

          <div class="form-group">
            <?= form_label('Comentario:', 'comentario') ?>
            <p class="small">Máximo 500 caracteres</p>
            <?= form_textarea('comentario', set_value('comentario', '', FALSE),
                              'id="comentario" class="form-control contacta"') ?>
          </div>
          <?= form_submit('enviar', 'Enviar', 'class="btn btn-success"') ?>
        <?= form_close() ?>
    </div>

    <div class="feedback">
        <h4>¡Necesitamos tus comentarios!</h4>
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
