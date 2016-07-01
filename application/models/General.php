<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Model{
    function lista_juegos() {
        $res = $this->db->query('select * from v_juegos_finalizados');
        return ($res->num_rows() < 1) ? FALSE : $res->result_array();
    }

    function total_scroll($busqueda) {
        if ($busqueda === '') {
            $res = $this->db->query("select *
                                       from v_juegos_finalizados
                                      where true");
        }
        else {
            $res = $this->db->query("select *
                                       from v_juegos_finalizados
                                      where upper(nombre_juego) like upper(concat('%', ?, '%'))",
                                      array($busqueda));
        }

        return ceil($res->num_rows()/5);
    }

    function buscar($busqueda, $offset) {
        $offset = $offset * 5;

        if ($busqueda === '') {
            $res = $this->db->query("select *
                                       from v_juegos_finalizados
                                      where true
				   order by id_juego desc
                                      limit 5 offset ?",
                                      array($offset));
        }
        else {
            $res = $this->db->query("select *
                                       from v_juegos_finalizados
                                      where upper(nombre_juego) like upper(concat('%', ?, '%'))
                                   order by id_juego desc
				      limit 5 offset ?",
                                      array($busqueda, $offset));
        }



        if ($res->num_rows() < 1) return array('display' => FALSE);
        else {
            return array(
                'display' => TRUE,
                'total_scroll' => $this->General->total_scroll($busqueda),
                'juegos'  => $res->result_array()
            );
        }
    }
}
