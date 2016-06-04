<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Portal extends CI_Controller {

    public function index()
    {
        $data['lista'] = $this->General->lista_juegos();
        $data['id_usuario'] = $this->session->userdata('usuario')['id'];

        $this->portal_template->load('portal/index', $data);

    }

    public function buscar() {
        $busqueda = $this->input->post('busqueda');

        $res = $this->General->buscar($busqueda);
        echo json_encode($res);
    }

    public function sobre() {
        $this->portal_template->load('portal/sobre');
    }

    public function contacta() {
        if ($this->input->post('enviar')) {

            $reglas_contacta = array(
                array(
                    'field' => 'nombre',
                    'label' => 'Nombre',
                    'rules' => 'trim|required|max_length[15]'
                ),
                array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'comentario',
                    'label' => 'Comentario',
                    'rules' => 'trim|required|max_length[500]'
                )
            );

            $this->form_validation->set_rules($reglas_contacta);
            if ($this->form_validation->run() === TRUE) {
                $nombre = $this->input->post('nombre');
                $email  = $this->input->post('email');
                $coment = $this->input->post('comentario');

                $mensaje  = '<p>Comentario de '.$nombre.'</p>';
                $mensaje .= '<p>Email: '.$email.'</p>';
                $mensaje .= '<p>Comentario:<br />'.$coment.'</p>';

                $this->load->library('email');
                $this->email->from('adventureworldsdaw@gmail.com');
                $this->email->to('adventureworldsdaw@gmail.com');
                $this->email->subject('Nuevo comentario de '.$nombre);
                $this->email->message($mensaje);
                if (!$this->email->send()) {
                    show_error($this->email->print_debugger());
                }
                else {
                    $mensajes[] = array('info' =>
                            "Comentario enviado satisfactoriamente. ¡Muchas gracias por tu comentario!");
                    $this->flashdata->load($mensajes);

                    redirect('portal/contacta');
                }
            }
        }

        $this->portal_template->load('portal/contacta');
    }
}
