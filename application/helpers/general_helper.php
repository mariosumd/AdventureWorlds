<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function mensajes() {
    $CI =& get_instance();
    $mensajes = $CI->session->flashdata('mensajes');
    $out = "";
    if($mensajes !== NULL) {
        foreach ($mensajes as $mensaje) {
            foreach ($mensaje as $clave => $valor) break;
            $clase = ($clave === 'error') ? 'alert-danger' : 'alert-success';
            $out .= '<div class="row">';
                $out .= '<div class="col-md-12 col-md-offset-0">';
                    $out .= '<div class="alert ' . $clase . '" role="alert">';
                        $out .= $valor;
                    $out .= '</div>';
                $out .= "</div>";
            $out .= '</div>';
        }
    }

    return $out;
}

function nombre_juego() {
    $CI =& get_instance();
    $nombre = $CI->session->flashdata('mensajes');

    if ($nombre != NULL) {
        return $nombre;
    }

    return '';
}

function id_ficha() {
    $CI =& get_instance();
    return $CI->session->userdata('ficha')['actual'];
}

function ficha_siguiente($boton) {
    $CI =& get_instance();
    $boton = 'siguiente'.$boton;

    if (isset($CI->session->userdata('ficha')[$boton]) &&
            $CI->session->userdata('ficha')[$boton] !== NULL) {
        return $CI->session->userdata('ficha')[$boton];
    } else {
        return 'none';
    }
}
