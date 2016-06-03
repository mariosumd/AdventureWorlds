<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Juegos extends CI_Controller{

  function index()
  {
      $this->Game_Template->load('juegos/index');
  }

}
