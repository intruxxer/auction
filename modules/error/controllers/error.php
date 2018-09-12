<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Error extends Front_Controller {

  public function __construct() {
        parent::__construct();
        $this->template->set('title', '123Quanto | Error');
        $this->template->set('type', 'registration');
  }

  public function index(){ $this->template->build('index'); }
  public function custom_404(){ $this->template->build('index'); }

}