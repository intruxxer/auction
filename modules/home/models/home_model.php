<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class home_model extends MY_Model {

	protected $table        = 'home';
    protected $key          = 'id';
    protected $date_format  = 'datetime';
    protected $set_created  = true;

    public function __construct()
    {
        parent::__construct();
    }

}
