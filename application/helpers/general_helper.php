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
                $out .= '<div class="col-md-11 col-md-offset-0">';
                    $out .= '<div class="alert ' . $clase . '" role="alert">';
                        $out .= $valor;
                    $out .= '</div>';
                $out .= "</div>";
            $out .= '</div>';
        }
    }

    return $out;
}
