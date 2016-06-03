<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function login()
{
    $CI =& get_instance();

    $out = "";

    if ($CI->Usuario->logueado()):
        $usuario = $CI->session->userdata('usuario');
        $out .= form_open('usuarios/logout', 'class="form-inline"');
            $out .= '<div class="user">';
                $out .= form_label($usuario['nombre']);
                $out .= form_submit('logout', 'Logout',
                                    'id="logout" class="btn btn-primary btn-xs"');
            $out .= '</div>';
        $out .= form_close();
    else:
        $out .= '<div class="user">';
            $out .= anchor('/usuarios/login', 'Iniciar sesión',
                            'class="btn btn-primary btn-xs" role="button"');
        $out .= '</div>';
    endif;

    return $out;
}

function crear() {
  $CI =& get_instance();

  $div = "";

  if ($CI->Usuario->logueado()):
      $usuario = $CI->session->userdata('usuario');
      $div .= form_open('creadores/index');
        $div .= form_hidden('nuevo', 'TRUE');
        $div  .= '<div class="creador">';
            $div .= '<h3>Crea YA tu aventura</h3>';
            $div .= '<h4>Clica aquí para empezar</h4>';
        $div .= '</div>';
      $div .= form_close();
  endif;

  return $div;
}

function tutorial() {
  $CI =& get_instance();

  $div = "";

  if ($CI->Usuario->logueado()):
      $div .= '<a href="'.base_url('creadores/tutorial').'">';
        $div  .= '<div class="creador">';
            $div .= '<h3>¿Cómo creo mi aventura?</h3>';
            $div .= '<h4>Tutorial aquí</h4>';
        $div .= '</div>';
      $div .= '</a>';
  endif;

  return $div;
}

function nuevo_juego() {
    $CI =& get_instance();

    $script = '';

    if ($CI->session->flashdata('nuevo') === 'TRUE') {
        $script .= '$(document).ready(juego);';
    }
    return $script;
}

function usuario_id()
{
        $CI =& get_instance();
        return $CI->session->userdata('usuario')['id'];
}

function logueado()
{
    $CI =& get_instance();
    return $CI->Usuario->logueado();
}

function nick($usuario_id)
{
    $CI =& get_instance();
    $usuario =  $CI->Usuario->por_id($usuario_id);
    if ($usuario !== FALSE)
    {
        return $usuario['nick'];
    }
}
