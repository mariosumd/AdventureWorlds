<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function portal_template_set($clave, $valor)
{
    $CI =& get_instance();
    $CI->portal_template->set($clave, $valor);
}

function creator_template_set($clave, $valor)
{
    $CI =& get_instance();
    $CI->creator_template->set($clave, $valor);
}

function game_template_set($clave, $valor)
{
    $CI =& get_instance();
    $CI->game_template->set($clave, $valor);
}
