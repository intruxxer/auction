<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class car_trim_model extends MY_Model {

	protected $table        = 'car_ref_trim';
    protected $key          = 'model_id';
    protected $date_format  = 'datetime';
    protected $set_created  = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function find_all_trims_by($conditions=array())
	{
		if(empty($conditions) || !is_array($conditions)){ return false; }
		foreach($conditions as $k => $v){ $this->db->where($k,$v); }
		$query = $this->db->select('model_id, model_trim')->from($this->table)->get();
		if (!empty($query) && $query->num_rows() > 0){ return $query->result(); }
		else{ return false; }
	}

}
