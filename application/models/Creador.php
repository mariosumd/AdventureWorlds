<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Creador extends CI_Model{

    public function lista_juegos($id_usuario) {
        $res = $this->db->query('select *
                                   from v_juegos_pendientes
                                  where id_usuario = ?', array($id_usuario));

        if ($res->num_rows() < 1) {
            return array('display' => FALSE);
        } else {
            $lista = $res->result_array();
            return array('display' => TRUE, 'lista' => $lista);
        }
    }

    public function cargar_juego($id_juego) {
        $res = $this->db->query('select *
                                   from v_fichas_formateadas
                                  where id_juego = ?
                               order by id_ficha', array($id_juego));

        return $res->result_array();
    }

    public function borrar_juego($id_juego) {
        $id = array($id_juego);
        $this->db->query('delete from fichas where id_juego = ?', $id);
        $this->db->query('delete from juegos where id_juego = ?', $id);
    }

    public function nuevo_juego($id_usuario, $nombre_juego) {
        $res = $this->db->query('insert into juegos (id_usuario, nombre) '.
                                'values (?, ?) returning id_juego',
                                array($id_usuario, $nombre_juego));

        return $res->row_array()['id_juego'];
    }

    public function ficha_final($id_ficha, $val) {
        $this->db->query('update fichas
                             set final = ?
                           where id_ficha = ?', array($val, $id_ficha));
    }

    public function nueva_ficha($id_juego, $nombre_ficha) {
        $res = $this->db->query('insert into fichas (id_juego, titulo) '.
                         'values(?, ?) returning id_ficha',
                         array($id_juego, $nombre_ficha));

        return $res->row_array()['id_ficha'];
    }

    public function color_fondo($id_ficha, $color) {
        $this->db->query('update fichas
                             set color_ficha = ?
                           where id_ficha = ?', array($color, $id_ficha));
    }

    public function numero_botones($id_ficha, $num) {
        $this->db->query('update fichas
                             set botones = ?
                           where id_ficha = ?', array($num, $id_ficha));
    }

    public function color_botones($id_ficha, $color) {
        $this->db->query('update fichas
                             set color_boton = ?
                           where id_ficha = ?', array($color, $id_ficha));
    }

    public function contenido_boton($id_ficha, $boton, $contenido) {
        $columna = $boton === "1" ? 'cont_boton1' : 'cont_boton2';

        $this->db->query('update fichas
                             set '.$columna.' = ?
                           where id_ficha = ?', array($contenido, $id_ficha));
    }

    public function titulo($id_ficha, $titulo) {
        $this->db->query('update fichas
                             set titulo = ?
                           where id_ficha = ?', array($titulo, $id_ficha));
    }

    public function contenido($id_ficha, $contenido) {
        $this->db->query('update fichas
                             set contenido = ?
                           where id_ficha = ?', array($contenido, $id_ficha));
    }

    public function ficha_siguiente($id_ficha, $id_siguiente, $boton) {
        $boton = 'id_siguiente'.$boton;

        $this->db->query('update fichas
                             set '.$boton.' = ?
                           where id_ficha = ?', array($id_ficha, $id_siguiente));
    }

    public function cargar_ficha($id_ficha) {
        $res = $this->db->query('select * from fichas where id_ficha = ?',
                                    array($id_ficha));

        return $res->row_array();
    }

    public function lista_fichas($id_juego, $id_ficha) {
        $res = $this->db->query('select id_ficha, titulo
                                   from fichas
                                  where id_juego = ? and id_ficha != ?',
                                  array($id_juego, $id_ficha));

        if ($res->num_rows() < 1) {
            return array('display' => FALSE);
        } else {
            $lista = $res->result_array();
            return array('display' => TRUE, 'lista' => $lista);
        }
    }

    public function imagen($id_ficha) {
        $this->db->query('update fichas
                             set imagen = true
                           where id_ficha = ?', array($id_ficha));
    }

    public function borrar_ficha($id_ficha) {
        $this->db->query('delete from fichas where id_ficha = ?', array($id_ficha));
    }

    public function finalizar_juego($id_juego) {
        $this->db->query('update juegos set finalizado = true where id_juego = ?',
                            array($id_juego));
    }

    public function nombre_juego($id_juego) {
        $res = $this->db->query('select nombre from juegos where id_juego = ?',
                            array($id_juego));

        return $res->row_array()['nombre'];
    }
}
