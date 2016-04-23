<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Portal extends CI_Controller {


    public function index()
    {
        $this->portal_template->load('portal/index');
    }

    public function sobre() {
        $this->portal_template->load('portal/sobre');
    }
}
