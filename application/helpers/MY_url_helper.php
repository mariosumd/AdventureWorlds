<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function portal_template_set($clave, $valor)
{
    $CI =& get_instance();
    $CI->portal_template->set($clave, $valor);
}
