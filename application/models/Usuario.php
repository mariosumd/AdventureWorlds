<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Model
{
    public function todos()
    {
        return $this->db->get('v_usuarios_roles')->result_array();
    }

    public function borrar($id)
    {
        return $this->db->delete('usuarios', array('id_usuario' => $id));
    }

    public function por_id($id)
    {
        $res = $this->db->get_where('usuarios', array('id_usuario' => $id));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }

    public function por_nombre($nombre)
    {
        $res = $this->db->get_where('usuarios', array('nombre' => $nombre));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }

    public function por_nombre_registrado($nombre) {
        $res = $this->db->get_where('v_usuarios_verificados', array('nombre' => $nombre));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }

    public function por_email($email)
    {
        $res = $this->db->get_where('usuarios', array('email' => $email));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }

    public function existe_nombre($nombre)
    {
        return $this->por_nombre($nombre) !== FALSE;
    }

    public function existe_email($email)
    {
        return $this->por_email($email) !== FALSE;
    }

    public function existe_nombre_registrado($nombre) {
        return $this->por_nombre_registrado($nombre) !== FALSE;
    }

    public function logueado()
    {
        return $this->session->has_userdata('usuario');
    }

    public function es_admin() {
        $usuario = $this->session->userdata("usuario");
        return $usuario['admin'] === TRUE;
    }

    public function insertar($valores)
    {
        return $this->db->insert('usuarios', $valores);
    }

    public function editar($valores, $id)
    {
        return $this->db->where('id_usuario', $id)->update('usuarios', $valores);
    }

    public function actualizar_password($id, $nueva_password) {
        return $this->db->query("update usuarios set password = ? where id_usuario::text = ?",
                          array($nueva_password, $id));
    }

    public function password($id)
    {
        $res = $this->db->query('select password from usuarios where id_usuario = ?',
                                array($id));
        return $res->num_rows() > 0 ? $res->row_array() : FALSE;
    }
}
