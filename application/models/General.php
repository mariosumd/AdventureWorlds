<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Model{
    function lista_juegos() {
        $res = $this->db->query('select * from v_juegos_finalizados');
        return ($res->num_rows() < 1) ? FALSE : $res->result_array();
    }

    function buscar($busqueda) {
        /*
        $res = $this->db->query("select *
                                   from v_juegos_finalizados
                                  where nombre_juego like '%?%'", array($busqueda));
*/
        $this->db->like('nombre_juego', $busqueda);
        $res = $this->db->get('v_juegos_finalizados');

        if ($res->num_rows < 1) return array('display' => FALSE);
        else {
            return array(
                'display' => TRUE,
                'juegos'  => $res->result_array()
            );
        }
    }
}
