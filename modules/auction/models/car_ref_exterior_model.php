<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class car_ref_exterior_model extends MY_Model {

	protected $table        = 'car_ref_exterior_color';
    protected $key          = 'id';
    protected $date_format  = 'datetime';
    protected $set_created  = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_exterior()
	{
		return $this->db->select('id, name, hexa')->from($this->table)->get()->result();
	}

}
