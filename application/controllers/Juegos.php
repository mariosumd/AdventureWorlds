<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Juegos extends CI_Controller{

    function index()
    {
        $data['id_juego'] = $this->input->post('id_juego');
        $data['nombre_juego'] = $this->Juego->nombre_juego($data['id_juego']);
        $data['id_ficha'] = $this->Juego->primera_ficha($data['id_juego']);
        $this->session->set_userdata('juego', array('id', $data['id_juego']));

        $this->game_template->load('juegos/index', $data);
    }

}
