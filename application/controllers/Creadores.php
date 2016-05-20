<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Creadores extends CI_Controller {

    function index() {
        if ($this->input->post('nuevo') === 'TRUE') {
            $this->session->set_flashdata('nuevo', 'TRUE');
            $this->creator_template->load('creador/index');
        } else {
            redirect('portal/index');
        }
    }

    public function borrar_juego() {
        $id_juego = $this->input->post('id_juego');
        $this->Creador->borrar_juego($id_juego);
    }

    public function ficha_final() {
        $id_ficha = $this->input->post('id_ficha');
        $this->Creador->ficha_final($id_ficha);
    }

    public function nuevo() {
        $id_usuario = $this->input->post('usuario');
        $nombre_juego = $this->input->post('nombre_juego');
        $nombre_ficha = $this->input->post('nombre_ficha');

        $id_juego = $this->Creador->nuevo_juego($id_usuario, $nombre_juego);
        $this->session->set_userdata('juego', array(
            'id' => $id_juego,
            'nombre' => $nombre_juego));
        $id_ficha = $this->Creador->nueva_ficha($id_juego, $nombre_ficha);
        $this->session->set_userdata('ficha', array('actual' => $id_ficha));
        echo $id_juego;
    }

    public function color_fondo() {
        $id_ficha = $this->input->post('id_ficha');
        $color = $this->input->post('color');

        $this->Creador->color_fondo($id_ficha, $color);
    }

    public function numero_botones() {
        $id_ficha = $this->input->post('id_ficha');
        $bool = $this->input->post('bool');

        $num = $bool === 'true' ? TRUE : FALSE;

        $this->Creador->numero_botones($id_ficha, $num);
    }

    public function color_botones() {
        $id_ficha = $this->input->post('id_ficha');
        $color = $this->input->post('color');

        $this->Creador->color_botones($id_ficha, $color);
    }

    public function contenido_boton() {
        $id_ficha = $this->input->post('id_ficha');
        $boton = $this->input->post('boton');
        $contenido = $this->input->post('contenido');

        $this->Creador->contenido_boton($id_ficha, $boton, $contenido);
    }

    public function contenido() {
        $id_ficha = $this->input->post('id_ficha');
        $contenido = $this->input->post('contenido');

        $this->Creador->contenido($id_ficha, $contenido);
    }

    public function id_ficha() {
        echo $this->session->userdata('ficha')['actual'];
    }

    public function nueva_ficha() {
        $boton = $this->input->post('boton');
        $nombre_ficha = $this->input->post('titulo');
        $id_anterior = $this->session->userdata('ficha')['actual'];
        $id_juego = $this->session->userdata('juego')['id'];

        $id_ficha = $this->Creador->nueva_ficha($id_juego, $nombre_ficha);
        $this->session->set_userdata('ficha', array(
                                                'actual' => $id_ficha,
                                                'anterior' => $id_anterior));

        $this->Creador->ficha_anterior($id_ficha, $id_anterior);
        $this->Creador->ficha_siguiente($id_ficha, $id_anterior, $boton);
    }

    public function cargar_ficha() {
        $id = $this->input->post('id');
        $fila = $this->Creador->cargar_ficha($id);
        $ficha = $this->session->userdata('ficha');

        if ($fila['id_anterior'] !== NULL) {
            $ficha['anterior'] = $fila['id_anterior'];
        } else {
            unset($ficha['anterior']);
        }

        if ($fila['id_siguiente1'] !== NULL) {
            $ficha['id_siguiente1'] = $fila['id_siguiente1'];
        } else {
            unset($ficha['id_siguiente1']);
        }

        if ($fila['id_siguiente2'] !== NULL) {
            $ficha['id_siguiente2'] = $fila['id_siguiente2'];
        } else {
            unset($ficha['id_siguiente2']);
        }

        $ficha['actual'] = $id;
        $this->session->set_userdata('ficha', $ficha);

        header('Content-Type: application/json');
        echo json_encode($fila);
    }
}
