<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Model
{
    public function todos()
    {
        return $this->db->get('v_usuarios_roles')->result_array();
    }

    public function borrar($id)
    {
        return $this->db->delete('usuarios', array('id' => $id));
    }

    public function por_id($id)
    {
        $res = $this->db->get_where('v_usuarios_roles', array('id' => $id));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }

    public function por_nick($nick)
    {
        $res = $this->db->get_where('usuarios', array('nick' => $nick));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }

    public function por_nick_registrado($nick) {
        $res = $this->db->get_where('v_usuarios_valido', array('nick' => $nick));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }

    public function por_email($email)
    {
        $res = $this->db->get_where('usuarios', array('email' => $email));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }

    public function existe_nick($nick)
    {
        return $this->por_nick($nick) !== FALSE;
    }

    public function existe_email($email)
    {
        return $this->por_email($email) !== FALSE;
    }

    public function existe_nick_registrado($nick) {
        return $this->por_nick_registrado($nick) !== FALSE;
    }

    public function logueado()
    {
        return $this->session->has_userdata('usuario');
    }

    public function es_admin() {
        $usuario = $this->session->userdata("usuario");
        return $usuario['rol_id'] === '1';
    }

    public function insertar($valores)
    {
        return $this->db->insert('usuarios', $valores);
    }

    public function editar($valores, $id)
    {
        return $this->db->where('id', $id)->update('usuarios', $valores);
    }

    public function actualizar_password($id, $nueva_password) {
        return $this->db->query("update usuarios set password = ? where id::text = ?",
                          array($nueva_password, $id));
    }

    public function password($id)
    {
        $res = $this->db->query('select password from usuarios where id = ?',
                                array($id));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }

    public function juegos_comprados($id) {
        $res = $this->db->query('select * from v_usuarios_carrito_compra '.
                                'where id_usuario = ?', array($id));

        $total = $this->db->query('select sum(v_usuarios_carrito_compra.precio) '.
                                  'from v_usuarios_carrito_compra where id_usuario = ?',
                                  array($id))->row_array();

        $resultado = $res->num_rows() > 0 ? $res->result_array() : FALSE;

        if ($resultado !== FALSE) {
            $resultado['total'] = $total;
        }

        return $resultado;
    }

    public function juego_comprado($id_usuario, $id_juego) {
        $res = $this->db->query('select * from carrito_compra '.
                                'where id_usuario = ? and id_juego = ?',
                                array($id_usuario, $id_juego));
        return $res->num_rows() > 0 ? TRUE : FALSE;
    }
}
