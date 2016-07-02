<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Juego extends CI_Model{
    public function existe_juego($id_juego) {
        $res = $this->db->query('select * from v_juegos_finalizados where id_juego = ?',
                            array($id_juego));

        return $res->num_rows() === 1;
    }

    public function nombre_juego($id_juego) {
        $res = $this->db->query('select nombre from juegos where id_juego = ?',
                            array($id_juego));

        return $res->row_array()['nombre'];
    }

    public function primera_ficha($id_juego) {
        $res = $this->db->query('select id_ficha
                                   from fichas
                                  where id_juego = ?
                               order by id_ficha
                                  limit 1', array($id_juego));

        return $res->row_array()['id_ficha'];
    }

    public function ficha($id_juego, $id_usuario) {
        $res = $this->db->query('select id_ficha
                                   from juegos_guardados
                                  where id_juego = ? and id_usuario = ?',
                                array($id_juego, $id_usuario));

        if ($res->num_rows() < 1) {
            return $this->Juego->primera_ficha($id_juego);
        } else {
            return $res->row_array()['id_ficha'];
        }
    }

    public function guardar_juego($id_juego, $id_usuario, $id_ficha) {
        $this->db->query('delete from juegos_guardados
                           where id_juego = ? and id_usuario = ?',
                          array($id_juego, $id_usuario));

        $this->db->query('insert into juegos_guardados(id_juego, id_usuario, id_ficha)
                            values (?, ?, ?)', array($id_juego, $id_usuario, $id_ficha));
    }
}
