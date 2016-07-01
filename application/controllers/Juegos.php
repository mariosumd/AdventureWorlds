<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Juegos extends CI_Controller{

    function index() {
        redirect('portal/index');
    }

    function jugar($id_juego)
    {
        if (preg_match('/^\d+$/', $id_juego) && $this->Juego->existe_juego($id_juego)) {
            $id_usuario = $this->session->userdata('usuario')['id'];
            $data['id_juego'] = $id_juego;
            $data['nombre_juego'] = $this->Juego->nombre_juego($data['id_juego']);
            $data['primera_ficha'] = $this->Juego->primera_ficha($id_juego);
            $data['id_ficha'] = $this->Juego->ficha($data['id_juego'], $id_usuario);
            $this->session->set_userdata('juego', array(
                                                        'id'     => $data['id_juego'],
                                                        'nombre' => $data['nombre_juego']
                                                    ));

            $this->game_template->load('juegos/jugar', $data);
        } else {
            redirect('portal/index');
        }
    }

    function guardar_juego() {
        $id_juego =   $this->input->post('id_juego');
        $id_usuario = $this->input->post('id_usuario');
        $id_ficha =   $this->input->post('id_ficha');

        $this->Juego->guardar_juego($id_juego, $id_usuario, $id_ficha);
    }

}
