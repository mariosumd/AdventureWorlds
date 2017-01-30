<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include('K:\wamp64\bin\php\php5.6.25\gv.php');
include('K:\wamp64\bin\php\php5.6.25\pear\Image\GraphViz.php');

class Creadores extends CI_Controller {

    public function index() {
        if ($this->input->post('nuevo') === 'TRUE') {
            $this->session->set_flashdata('nuevo', 'TRUE');
            $this->creator_template->load('creador/index');
        } else {
            redirect('portal/index');
        }
    }

    public function ventana() {
        $this->load->view('creador/ventana');
    }

    public function lista_juegos() {
        $id_usuario = $this->input->post('id_usuario');
        $lista = $this->Creador->lista_juegos($id_usuario);

        header('Content-Type: application/json');
        echo json_encode($lista);
    }

    public function cargar_juego() {
        $id_juego = $this->input->post('id_juego');
        $nombre_juego = $this->input->post('nombre_juego');
        $fichas = $this->Creador->cargar_juego($id_juego);

        $this->session->set_userdata('juego', array(
            'id' => $id_juego,
            'nombre' => $nombre_juego));

        header('Content-Type: application/json');
        echo json_encode($fichas);
    }

    public function borrar_juego() {
        $id_juego = $this->input->post('id_juego');
        $this->Creador->borrar_juego($id_juego);
        $mensajes[] = array('info' => 'Juego borrado satisfactoriamente.');
        $this->flashdata->load($mensajes);
    }

    public function ficha_final() {
        $id_ficha = $this->input->post('id_ficha');
        $val = $this->input->post('val');
        $this->Creador->ficha_final($id_ficha, $val);
    }

    public function nuevo() {
        $id_usuario = $this->input->post('usuario');
        $nombre_juego = $this->input->post('nombre_juego');

        $id_juego = $this->Creador->nuevo_juego($id_usuario, $nombre_juego);
        $this->session->set_userdata('juego', array(
            'id' => $id_juego,
            'nombre' => $nombre_juego));

        echo $id_juego;
    }

    public function nueva() {
        $id_juego = $this->input->post('id_juego');
        $titulo   = $this->input->post('titulo');

        $id_ficha = $this->Creador->nueva_ficha($id_juego, $titulo);
        $this->session->set_userdata('ficha', array('actual' => $id_ficha));
        echo $id_ficha;
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

    public function titulo() {
        $id_ficha = $this->input->post('id_ficha');
        $titulo = $this->input->post('titulo');

        $this->Creador->titulo($id_ficha, $titulo);
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

        $this->Creador->ficha_siguiente($id_ficha, $id_anterior, $boton);
        echo $id_ficha;
    }

    public function ligar_ficha() {
        $boton = $this->input->post('boton');
        $id_ficha = $this->input->post('id');
        $id_anterior = $this->session->userdata('ficha')['actual'];

        $this->session->set_userdata('ficha', array(
                                                'actual' => $id_ficha,
                                                'anterior' => $id_anterior));

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

    public function lista_fichas() {
        $id_ficha = $this->input->post('id_ficha');
        $id_juego = $this->input->post('id_juego');

        $lista = $this->Creador->lista_fichas($id_juego, $id_ficha);

        header('Content-Type: application/json');
        echo json_encode($lista);
    }

    public function subir_imagen() {
        $id_ficha = $this->session->userdata('ficha')['actual'];

        $config['upload_path'] = './images/juegos/';
        $config['allowed_types'] = 'jpg';
        $config['overwrite'] = TRUE;
        $config['max_width'] = '1280';
        $config['max_height'] = '720';
        $config['max_size'] = '40000';
        $config['file_name'] = $id_ficha . '.jpg';

        $this->load->library('upload', $config);

        foreach ($_FILES as $key => $value);

        if (!$this->upload->do_upload($key)) {
            $errores = $this->upload->display_errors();
            echo $errores;
        } else {
            $this->upload->data();
            $this->Creador->imagen($id_ficha);
        }
    }

    public function eliminar_imagen() {
        $id_ficha = $this->session->userdata('ficha')['actual'];
        $this->Creador->eliminar_imagen($id_ficha);

        unlink('./images/juegos/'.$id_ficha.'.jpg');
    }

    public function borrar_ficha() {
        $id_ficha = $this->input->post('id_ficha');
        $this->Creador->borrar_ficha($id_ficha);
    }

    public function finalizar_juego() {
        $id_juego = $this->input->post('id_juego');

        $this->Creador->finalizar_juego($id_juego);
        $mensajes[] = array('info' => '¡Juego terminado!');
        $this->flashdata->load($mensajes);
    }

    public function mapa($id_juego) {
        $fichas   = $this->Creador->cargar_juego($id_juego);

        $gv = new Image_GraphViz();
        foreach ($fichas as $ficha) {
            if (isset($ficha['siguiente1'])) {
                $gv->addEdge(array($ficha['titulo'] => $ficha['siguiente1']));
            }
            if (isset($ficha['siguiente2'])) {
                $gv->addEdge(array($ficha['titulo'] => $ficha['siguiente2']));
            }
        }

        $gv->image('pdf');
    }
}
