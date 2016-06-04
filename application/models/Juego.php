<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Juego extends CI_Model{
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
}
