<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class car_ref_preferences_model extends MY_Model {

    protected $table_styles = 'car_ref_body_styles';
	protected $table_brands = 'car_ref_brands';
    protected $key          = 'id';
    protected $date_format  = 'datetime';
    protected $set_created  = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function all_styles()
	{
		return $this->db->select('id, name')->from($this->table_styles)->get()->result();
	}

    public function all_brands()
    {
        return $this->db->select('id, name, type')->from($this->table_brands)->get()->result();
    }

}