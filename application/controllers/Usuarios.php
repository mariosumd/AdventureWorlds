<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {
    private $reglas_comunes = array(
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
            'field' => 'password',
            'label' => 'Contraseña',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password_confirm',
            'label' => 'Confirmar contraseña',
            'rules' => 'trim|required|matches[password]'
        )
    );

    private $array_password_anterior = array(
        'field' => 'password_anterior',
        'label' => 'Contraseña Antigua',
        'rules' => 'required'
    );

    public function login() {
        if ($this->Usuario->logueado()) {
            redirect('portal/index');
        }

        if ($this->input->post('login') !== NULL)
        {
            $nombre = $this->input->post('nombre');

            $reglas = array(
                array(
                    'field' => 'nombre',
                    'label' => 'nombre',
                    'rules' => array(
                        'trim', 'required',
                        array('existe_nombre', array($this->Usuario, 'existe_nombre')),
                        array('existe_nombre_registrado', array($this->Usuario, 'existe_nombre_registrado'))
                    ),
                    'errors' => array(
                        'existe_nombre' => 'El nombre debe existir.',
                        'existe_nombre_registrado' => 'Esta cuenta todavia no ha sido validada por' .
                                                    ' los medios correspondientes. Por favor, ' .
                                                    'valide su cuenta.'
                    ),
                ),
                array(
                    'field' => 'password',
                    'label' => 'Contraseña',
                    'rules' => "trim|required|callback__password_valido[$nombre]"
                )
            );

            $this->form_validation->set_rules($reglas);
            if ($this->form_validation->run() === TRUE)
            {
                $usuario = $this->Usuario->por_nombre($nombre);
                $this->session->set_userdata('usuario', array(
                    'id' => $usuario['id_usuario'],
                    'nombre' => $nombre
                ));

                if($this->session->has_userdata('last_uri'))
                {
                    $uri = $this->session->userdata('last_uri');
                    $this->session->unset_userdata('last_uri');
                    redirect($uri);
                }
                else
                {
                    redirect('portal/index');
                }
            }
        }

        if (isset($_SERVER['HTTP_REFERER']) && !$this->session->has_userdata('last_uri'))
        {
            $this->session->set_userdata('last_uri',
                            parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH));
        }
        $this->output->delete_cache('/portal/index');
        $this->portal_template->load('usuarios/login');
    }

    public function logout() {
        $this->output->delete_cache('/portal/index');
        $this->session->sess_destroy();
        redirect('usuarios/login');
    }

    public function __construct() {
        parent::__construct();

        $accion = $this->uri->rsegment(2);

        if ( ! in_array($accion, array('login', 'recordar', 'regenerar', 'registrar', 'validar')) &&
             ! $this->Usuario->logueado()) {
            redirect('usuarios/login');
        }

        if ( ! in_array($accion, array('login', 'logout', 'recordar', 'regenerar', 'registrar',
                                       'validar', 'perfil', 'foto'))) {
            if ( ! $this->Usuario->es_admin())
            {
                $mensajes[] = array('error' =>
                    "No tiene permisos para acceder a esta parte de la aplicación");
                $this->flashdata->load($mensajes);

                redirect('portal/index');
            }
        }
    }

    public function index() {
        $data['filas'] = $this->Usuario->todos();
        $this->portal_template->load('usuarios/index', $data);
    }

    public function perfil($id = NULL) {
        if($id === NULL) {
            $mensajes[] = array('error' =>
                    "Parámetros incorrectos para acceder a su perfil de usuario, por favor, intentelo de nuevo.");
            $this->flashdata->load($mensajes);
            redirect('usuarios/login');
        }
        $usuario = $this->Usuario->por_id($id);
        $this->portal_template->load('usuarios/perfil', $usuario);
    }

    public function foto($id = NULL) {
        if($id === NULL) {
            $mensajes[] = array('error' =>
                    "Parámetros incorrectos para acceder a subida de foto de perfil, por favor, intentelo de nuevo.");
            $this->flashdata->load($mensajes);
            redirect('usuarios/login');
        }
        $data['id'] = $id;
        $data['error'] = array();

        if ($this->input->post('insertar') !== NULL) {
            $config['upload_path'] = 'images/usuarios/';
            $config['allowed_types'] = 'jpeg|jpg|jpe';
            $config['overwrite'] = TRUE;
            $config['max_width'] = '250';
            $config['max_height'] = '250';
            $config['max_size'] = '100';
            $config['file_name'] = $id . '.jpeg';

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('foto')) {
                $data['error'] = $this->upload->display_errors();
            }
            else {
                $data = array('upload_data' => $this->upload->data());

                $imagen = new Imagick($data['upload_data']['full_path']);
                $imagen->adaptiveResizeImage(70, 70);
                $imagen->writeImageFile(fopen("images/usuarios/" . $id . "_thumbnail.jpeg", "w"));

                redirect('usuarios/perfil/' . $id);
            }
        }
        $this->portal_template->load('usuarios/foto', $data);
    }

    public function validar($usuario_id = NULL, $token = NULL) {
        if($usuario_id === NULL || $token === NULL) {
            redirect('/usuarios/login');
        }

        $usuario_id = trim($usuario_id);
        $token = trim($token);
        $this->load->model('Token');
        $res = $this->Token->comprobar($usuario_id, $token);

        if ($res === FALSE) {
            $mensajes[] = array('error' =>
                "Parametros incorrectos para la validación de la cuenta.");
            $this->flashdata->load($mensajes);

            redirect('/usuarios/login');
        }

        ######################################################

        $valores = array(
            'registro_verificado' => TRUE
        );

        $this->Usuario->editar($valores, $usuario_id);
        $this->Token->borrar($usuario_id);

        $mensajes[] = array('info' =>
            "Cuenta validada. Ya puede logear en el sistema.");
        $this->flashdata->load($mensajes);

        redirect('/usuarios/login');
    }
    public function registrar() {

        if ($this->input->post('registrar') !== NULL)
        {
            $reglas = $this->reglas_comunes;
            $reglas[0] = array(
                            'field' => 'nombre',
                            'label' => 'nombre',
                            'rules' => array(
                                'trim', 'required',
                                array('existe_nombre', function ($nombre) {
                                        return !$this->Usuario->existe_nombre($nombre);
                                    }
                                )
                            ),
                            'errors' => array(
                                'existe_nombre' => 'El nombre ya existe, por favor, escoja otro.',
                            )
                        );
            $reglas[1] = array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => array(
                    'trim', 'required',
                    array('existe_email', function ($email) {
                            return !$this->Usuario->existe_email($email);
                        }
                    )
                ),
                'errors' => array(
                    'existe_email' => 'El email ya existe, por favor, escoja otro.',
                )
            );
            $this->form_validation->set_rules($reglas);
            if ($this->form_validation->run() === TRUE) {

                $valores = $this->input->post();

                unset($valores['registrar']);
                unset($valores['password_confirm']);

                $valores['password'] = password_hash($valores['password'], PASSWORD_DEFAULT);
                $valores['registro_verificado'] = FALSE;
                $valores['activado'] = TRUE;

                $this->Usuario->insertar($valores);

                $this->load->model('Token');
                # Prepara correo
                $usuario = $this->Usuario->por_nombre($valores['nombre']);
                $usuario_id = $usuario['id_usuario'];

                ################################################################

                # Mandar correo
                $enlace = anchor('/usuarios/validar/' . $usuario_id . '/' .
                                 $this->Token->generar($usuario_id));

                $this->load->library('email');
                $this->email->from('adventureworldsdaw@gmail.com');
                $this->email->to($valores['email']);
                $this->email->subject('Confirmar Registro');
                $this->email->message($enlace);
                if (!$this->email->send()) {
                    show_error($this->email->print_debugger());
                }
                else {
                    $mensajes[] = array('info' =>
                            "Confirme su cuenta a traves de su correo electrónico.");
                    $this->flashdata->load($mensajes);

                    redirect('usuarios/login');
                }
            }
        }
        $this->portal_template->load('usuarios/registrar');
    }

    public function recordar() {
        if ($this->input->post('recordar') !== NULL) {
            $reglas = array(
                array(
                    'field' => 'nombre',
                    'label' => 'nombre',
                    'rules' => array(
                        'trim',
                        'required',
                        array('existe_usuario', array($this->Usuario, 'existe_nombre')
                        )
                    ),
                    'errors' => array(
                        'existe_usuario' => 'Ese usuario no existe.'
                    )
                )
            );
            $this->form_validation->set_rules($reglas);
            if ($this->form_validation->run() !== FALSE) {
                # Preparar correo

                $nombre = $this->input->post('nombre');
                $usuario = $this->Usuario->por_nombre($nombre);
                $usuario_id = $usuario['id_usuario'];
                $email = $usuario['email'];

                $this->load->model('Token');
                $enlace = anchor('/usuarios/regenerar/' . $usuario_id . '/' .
                                 $this->Token->generar($usuario_id));

                # Mandar correo

                $this->load->library('email');
                $this->email->from('adventureworldsdaw@gmail.com');
                $this->email->to($email);
                $this->email->subject('Regenerar Contraseña');
                $this->email->message($enlace);
                $this->email->send();

                ################################################################

                $mensajes[] = array('info' =>
                    "Se ha enviado un correo a su dirección de email.");
                $this->flashdata->load($mensajes);

                redirect('/usuarios/login');
            }
        }

        $this->portal_template->load('/usuarios/recordar');
    }

    public function regenerar($usuario_id = NULL, $token = NULL) {
        if($usuario_id === NULL || $token === NULL) {
            redirect('/usuarios/login');
        }

        $usuario_id = trim($usuario_id);
        $token = trim($token);
        $this->load->model('Token');
        $res = $this->Token->comprobar($usuario_id, $token);

        if ($res === FALSE) {
            $mensajes[] = array('error' =>
                "Párametros incorrectos para la regeneración de contraseña.");
            $this->flashdata->load($mensajes);

            redirect('/usuarios/login');
        }

        ######################################################

        if ($this->input->post('regenerar') !== NULL) {
            $reglas = array(
                $this->reglas_comunes[2], $this->reglas_comunes[3]
            );

            $this->form_validation->set_rules($reglas);
            if ($this->form_validation->run() !== FALSE) {
                $password = $this->input->post('password');
                $nueva_password = password_hash($password, PASSWORD_DEFAULT);
                $this->Usuario->actualizar_password($usuario_id, $nueva_password);
                $this->Token->borrar($usuario_id);

                $mensajes[] = array('info' =>
                    "Su contraseña se ha regenerado correctamente");
                $this->flashdata->load($mensajes);

                redirect('/usuarios/login');
            }
        }

        ########################################################

        $data = array(
            'usuario_id' => $usuario_id,
            'token' => $token
        );
        $this->portal_template->load('usuarios/regenerar', $data);
    }

    public function insertar()
    {
        if ($this->input->post('insertar') !== NULL)
        {
            $reglas = $this->reglas_comunes;
            $reglas[0]['rules'] .= '|is_unique[usuarios.nombre]';
            $this->form_validation->set_rules($reglas);
            if ($this->form_validation->run() !== FALSE)
            {
                $valores = $this->limpiar('insertar', $this->input->post());
                $valores['registro_verificado'] = TRUE;
                $this->Usuario->insertar($valores);
                redirect('usuarios/index');
            }
        }
        $data['roles'] = $this->Rol->lista();
        $this->portal_template->load('usuarios/insertar', $data);
    }

    public function editar($id = NULL)
    {
        if ($id === NULL)
        {
            redirect('usuarios/index');
        }

        $id = trim($id);

        if ($this->input->post('editar') !== NULL)
        {
            $reglas = $this->reglas_comunes;
            $reglas[0]['rules'] .= "|callback__nombre_unico[$id]";
            $reglas[] = $this->array_password_anterior;
            $reglas[sizeof($reglas)-1]['rules'] .= "|callback__password_anterior_correcto[$id]";
            $this->form_validation->set_rules($reglas);
            if ($this->form_validation->run() !== FALSE)
            {
                $valores = $this->limpiar('editar', $this->input->post());
                unset($valores['password_anterior']);
                $this->Usuario->editar($valores, $id);
                redirect('usuarios/index');
            }
        }
        $valores = $this->Usuario->por_id($id);
        if ($valores === FALSE)
        {
            redirect('usuarios/index');
        }
        $data = $valores;
        if (isset($data['password']))
        {
            unset($data['password']);
        }
        $data['roles'] = $this->Rol->lista();
        $this->portal_template->load('usuarios/editar', $data);
    }

    public function borrar($id = NULL)
    {
        if ($this->input->post('borrar') !== NULL)
        {
            $id = $this->input->post('id');
            if ($id !== NULL)
            {
                $this->Usuario->borrar($id);
            }
            redirect('usuarios/index');
        }
        else
        {
            if ($id === NULL)
            {
                redirect('usuarios/index');
            }
            else
            {
                $res = $this->Usuario->por_id($id);
                if ($res === FALSE)
                {
                    redirect('usuarios/index');
                }
                else
                {
                    $data = $res;
                    $this->portal_template->load('usuarios/borrar', $data);
                }
            }
        }
    }

    public function _password_valido($password, $nombre) {
        $usuario = $this->Usuario->por_nombre($nombre);

        if ($usuario !== FALSE &&
            password_verify($password, $usuario['password']) === TRUE)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('_password_valido',
                'La {field} no es válida.');
            return FALSE;
        }
    }

    private function limpiar($accion, $valores)
    {
        unset($valores[$accion]);
        $valores['password'] = password_hash($valores['password'], PASSWORD_DEFAULT);
        unset($valores['password_confirm']);

        return $valores;
    }

    public function _password_anterior_correcto($password_anterior, $id)
    {
        $valores = $this->Usuario->password($id);
        if (password_verify($password_anterior, $valores['password']) === TRUE)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('_password_anterior_correcto',
                'La {field} no es correcta.');
            return FALSE;
        }
    }

    public function _nombre_unico($nombre, $id)
    {
        $res = $this->Usuario->por_nombre($nombre);

        if ($res === FALSE || $res['id'] === $id)
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('_nombre_unico',
                'El {field} debe ser único.');
            return FALSE;
        }
    }
}
