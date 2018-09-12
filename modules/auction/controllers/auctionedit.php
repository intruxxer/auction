<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auctionedit extends Front_Controller {

  protected $seller_profile;
  protected $seller_login;
  protected $dealer_profile;
  protected $dealer_login;
  protected $sidebar_auction;
  protected $sidebar_auction_edit;
  protected $authorized_seller_auctions;
  protected $authorized_seller_cars;
  
  public function __construct() {
      parent::__construct();
      $this->load->library('guzzle');

      $this->seller_profile = $this->session->userdata('seller_profile');
      if($this->seller_profile){
        $this->seller_login = $this->session->userdata('login');
        $this->template->set('user_name', $this->seller_profile->first_name . ' ' . $this->seller_profile->last_name);
        $this->template->set('profile_link', site_url('seller/profile'));
        $this->template->set('payment_link', site_url('seller/payment'));
        $this->template->set('setting_link', site_url('seller/setting'));
        $this->authorized_seller_auctions = $this->set_authorized_auctions($this->seller_profile->id);
        $this->authorized_seller_cars     = $this->set_authorized_cars($this->seller_profile->id);
      }
      else{
        $this->dealer_profile = $this->session->userdata('dealer_profile');
        $this->dealer_login = $this->session->userdata('login');
        $this->template->set('user_name', $this->dealer_profile->company_name);
        $this->template->set('profile_link', site_url('dealer/profile'));
        $this->template->set('payment_link', site_url('dealer/payment'));
        $this->template->set('setting_link', site_url('dealer/setting'));
      }
      $this->template->set('signout_link', site_url('logout'));
      $this->is_login();
  }

  public function edit($auction_id='', $auction_type='new', $car_sale_id=''){
      //PROTECTION AGAINST BRUTE FORCE ID Auction & ID Car
      $key_auction = array_search($auction_id, $this->authorized_seller_auctions);
      $key_car     = array_search($car_sale_id, $this->authorized_seller_cars);
      if(false === $key_auction || false === $key_car){ redirect('seller', 'refresh'); die; }
      
      //END PROTECTION
      $url            = $this->config->item('api_url');
      $resource       = 'car_sale';
      try{ $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]); } catch(Exception $e){ echo $e; }

      if($auction_type=='condition'){
          $query     = '/get_vehicle_conditions?auction_id='.$auction_id.'&car_sale_id='.$car_sale_id;
          $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
          $api_url   = $url . $resource . $query . $key;

          try{
              $response   = $client->request('GET', $api_url);
              $condition  = $response->getBody()->getContents();
              $condition  = json_decode($condition);
              $condition  = $condition->data; 
          }
          catch(Exception $e){
              echo $e;
          }

          //Set Repairing Condition
          $repairing_elements = array(); $repairing_elements_arr = array();
          foreach($condition->needs_repair as $key => $c) {
              $found = array_search($c->name, $condition->car_condition->needs_repair);
              if($found !== false){ 
                $c->orange = 'orange'; 
                array_push($repairing_elements, $c->name);
              }
              else{ 
                $c->orange = ''; 
              }
              array_push($repairing_elements_arr, $c->name);
          }

          //Set Windshield Condition
          $windshield_elements = array(); $windshield_elements_arr = array();
          foreach($condition->windshield as $key => $c) {
              $found = array_search($c->name, $condition->car_condition->windshield);
              if($found !== false){ 
                $c->orange = 'orange'; 
                array_push($windshield_elements, $c->name);
              }
              else{ 
                $c->orange = ''; 
              }
              array_push($windshield_elements_arr, $c->name);
          }

          //Set Tire Condition
          foreach($condition->tire_condition as $key => $c) {
              $difference = strcmp($c->name, $condition->car_condition->tire_condition);
              if(!$difference){ 
                $c->orange = 'orange';
              }
              else{ 
                $c->orange = ''; 
              }
          }
          
          //Set Airbag Condition
          foreach($condition->airbags_condition as $key => $c) {
              $difference = strcmp($c->name, $condition->car_condition->airbags_condition);
              if(!$difference){ 
                $c->orange = 'orange';
              }
              else{ 
                $c->orange = ''; 
              }
          }

          //Set ABS Antilock Condition
          foreach($condition->antilock_condition as $key => $c) {
              $difference = strcmp($c->name, $condition->car_condition->antilock_condition);
              if(!$difference){ 
                $c->orange = 'orange';
              }
              else{ 
                $c->orange = ''; 
              }
          }

          $query                = '/update_vehicle_conditions?';
          $key                  = 'key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';      
          $update_condition_url = $url . $resource . $query . $key;

          $this->template->set('title', 'Auction | Edit Condition');
          $this->template->set('body_class', 'seller-auction-edit-condition');
          $this->template->set('type', 'normal');
          $this->set_sidebar_auction_edit($auction_id, $car_sale_id);
          $this->template->set('sidebar', $this->sidebar_auction_edit);
          $this->template->set('data', $condition);
          $this->template->set('car_sale_id', $car_sale_id);
          $this->template->set('update_condition_url', $update_condition_url);
          $this->template->build('edit_condition');
      }
      elseif($auction_type=='declaration'){
          $query     = '/get_declarations?auction_id='.$auction_id.'&car_sale_id='.$car_sale_id;
          $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
          $api_url   = $url . $resource . $query . $key;

          try{
              $response     = $client->request('GET', $api_url);
              $declaration  = $response->getBody()->getContents();
              $declaration  = json_decode($declaration);
              $declaration  = $declaration->data; 

          }
          catch(Exception $e){
              echo $e;
          }

          $answer_collections = array(); $answers_array = array();
          foreach ($declaration->car_declaration as $key => $cd) {
              if($cd->answer=='1')
                $answer_collections[$key]->true_orange = 'orange';
              elseif($cd->answer=='2')
                $answer_collections[$key]->false_orange = 'orange';
              elseif($cd->answer=='3')
                $answer_collections[$key]->unknown_orange = 'orange';

              $answers_array[$key] = (int) $cd->answer;
          }
          
          $query                = '/update_declarations?';
          $key                  = 'key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';      
          $update_declaration_url = $url . $resource . $query . $key;

          $answers_array = json_encode($answers_array);
          $this->template->set('title', 'Auction | Edit Declaration');
          $this->template->set('body_class', 'seller-auction-edit-declaration');
          $this->template->set('type', 'normal');
          $this->set_sidebar_auction_edit($auction_id, $car_sale_id);
          $this->template->set('sidebar', $this->sidebar_auction_edit);
          $this->template->set('answer', $answer_collections);
          $this->template->set('answers_array', $answers_array);
          $this->template->set('data', $declaration);
          $this->template->set('car_sale_id', $car_sale_id);
          $this->template->set('update_declaration_url', $update_declaration_url);
          $this->template->build('edit_declaration');
      }
      elseif($auction_type=='detail'){
          $query     = '/get_details?auction_id='.$auction_id.'&car_sale_id='.$car_sale_id;
          $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
          $api_url   = $url . $resource . $query . $key;

          try{
              $response   = $client->request('GET', $api_url);
              $detail     = $response->getBody()->getContents();
              $detail     = json_decode($detail);
              $detail     = $detail->data;
          }
          catch(Exception $e){
              echo $e;
          }

          $query              = '/update_details?';
          $key                = 'key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';     
          $update_detail_url  = $url . $resource . $query . $key ;

          $this->template->set('title', 'Auction | Edit Detail');
          $this->template->set('body_class', 'seller-auction-edit-detail');
          $this->template->set('type', 'normal');
          $this->set_sidebar_auction_edit($auction_id, $car_sale_id);
          $this->template->set('sidebar', $this->sidebar_auction_edit);
          $this->template->set('data', $detail);
          $this->template->set('auction_id', $auction_id);
          $this->template->set('car_sale_id', $car_sale_id);
          $this->template->set('update_detail_url', $update_detail_url);
          $this->template->build('edit_detail');
      }
      elseif($auction_type=='exterior'){
          $query     = '/get_exterior?auction_id='.$auction_id.'&car_sale_id='.$car_sale_id;
          $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
          $api_url   = $url . $resource . $query . $key;

          try{
              $response  = $client->request('GET', $api_url);
              $exterior  = $response->getBody()->getContents();
              $exterior  = json_decode($exterior);
              $exterior  = $exterior->data;
          }
          catch(Exception $e){
              echo $e;
          }

          $query                = '/update_exterior?';
          $key                  = 'key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';      
          $update_exterior_url  = $url . $resource . $query . $key;

          $this->template->set('title', 'Auction | Edit Exterior');
          $this->template->set('body_class', 'seller-auction-edit-exterior');
          $this->template->set('type', 'normal');
          $this->set_sidebar_auction_edit($auction_id, $car_sale_id);
          $this->template->set('sidebar', $this->sidebar_auction_edit);
          $this->template->set('data', $exterior);
          $this->template->set('car_sale_id', $car_sale_id);
          $this->template->set('update_exterior_url', $update_exterior_url);
          $this->template->build('edit_exterior');
      }
      elseif($auction_type=='interior'){
          $query     = '/get_interior?auction_id='.$auction_id.'&car_sale_id='.$car_sale_id;
          $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
          $api_url   = $url . $resource . $query . $key;

          try{
              $response  = $client->request('GET', $api_url);
              $interior  = $response->getBody()->getContents();
              $interior  = json_decode($interior);
              $interior  = $interior->data;
          }
          catch(Exception $e){
              echo $e;
          }

          //GET Car For Sale's Interior Materials STRINGS
          $interior_materials = array();
          if(!empty($interior->car_interior_material)){
              foreach ($interior->car_interior_material as $key => $material) {
                array_push($interior_materials, "'".$material."'");
              }
              $interior_materials = implode(',', $interior_materials);
          }

          //GET All Car Interior Materials
          $material_references = array();
          foreach ($interior->interior_material as $key => $m) {
            $m->name = trim($m->name);
            array_push($material_references, "'".$m->name."'");
            $found = array_search($m->name, $interior->car_interior_material);
            if($found > -1){
                $m->orange = 'orange';
            }
            else{
                $m->orange = '';
            }
          }

          $query                = '/update_interior?';
          $key                  = 'key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';      
          $update_interior_url  = $url . $resource . $query . $key;

          $material_references = implode(",", $material_references);
          $this->template->set('title', 'Auction | Edit Interior');
          $this->template->set('body_class', 'seller-auction-edit-interior');
          $this->template->set('type', 'normal');
          $this->set_sidebar_auction_edit($auction_id, $car_sale_id);
          $this->template->set('sidebar', $this->sidebar_auction_edit);
          $this->template->set('data', $interior);
          $this->template->set('car_sale_id', $car_sale_id);
          $this->template->set('interior_materials', $interior_materials);
          $this->template->set('material_references', $material_references);
          $this->template->set('update_interior_url', $update_interior_url);
          $this->template->build('edit_interior');
      }
      elseif($auction_type=='mechanical'){
          $query     = '/get_mechanical?auction_id='.$auction_id.'&car_sale_id='.$car_sale_id;
          $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
          $api_url   = $url . $resource . $query . $key;

          try{
              $response    = $client->request('GET', $api_url);
              $mechanical  = $response->getBody()->getContents();
              $mechanical  = json_decode($mechanical);
              $mechanical  = $mechanical->data; 
          }
          catch(Exception $e){
              echo $e;
          }

          //Set Transmission
          foreach($mechanical->transmission as $t){
              if(strtolower($mechanical->car_mechanical->transmission) == strtolower($t->name))
                $t->orange = 'orange';
              else
                $t->orange = '';
          }
          if(empty($mechanical->car_mechanical->transmission)){ $mechanical->car_mechanical->transmission = '-'; }

          //Set Drivetrain
          foreach($mechanical->drivetrain as $d){
              if(strtolower($mechanical->car_mechanical->drivetrain) == strtolower($d->name))
                $d->orange = 'orange';
              else
                $d->orange = '';
          }
          if(empty($mechanical->car_mechanical->drivetrain)){ $mechanical->car_mechanical->drivetrain = '-'; }

          //Set Cylinders
          foreach($mechanical->cylinders as $c){
              if($mechanical->car_mechanical->cylinders == $c->name)
                $c->orange = 'orange';
              else
                $c->orange = '';
          }
          if(empty($mechanical->car_mechanical->cylinders)){ $mechanical->car_mechanical->cylinders = '0'; }

          //Set Displacement
          if(empty($mechanical->car_mechanical->displacement)){ $mechanical->car_mechanical->displacement = ''; }

          //Set Fuel Type
          $on_fuel_list = false;
          foreach($mechanical->fuel_type as $f){
              if(strtolower($mechanical->car_mechanical->fuel_type) == strtolower($f->name)){
                $f->orange    = 'orange';
                $on_fuel_list = true;
              }
              else
                $f->orange = '';
          }
          if(empty($mechanical->car_mechanical->fuel_type)){ $mechanical->car_mechanical->fuel_type = '-'; }
          elseif(!$on_fuel_list){
              $new_fuel_type_idx = count($mechanical->fuel_type);
              $new_fuel_type     = array(
                'id'      => $new_fuel_type_idx, 
                'name'    => $mechanical->car_mechanical->fuel_type . ' Gasoline', 
                'orange'  => 'orange' 
              );
              array_push($mechanical->fuel_type, (object) $new_fuel_type);
          }

          $query                  = '/update_mechanical?';
          $key                    = 'key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';      
          $update_mechanical_url  = $url . $resource . $query . $key;

          $this->template->set('title', 'Auction | Edit Mechanical');
          $this->template->set('body_class', 'seller-auction-edit-mechanical');
          $this->template->set('type', 'normal');
          $this->set_sidebar_auction_edit($auction_id, $car_sale_id);
          $this->template->set('sidebar', $this->sidebar_auction_edit);
          $this->template->set('data', $mechanical);
          $this->template->set('car_sale_id', $car_sale_id);
          $this->template->set('update_mechanical_url', $update_mechanical_url);
          $this->template->build('edit_mechanical');
      }
      elseif($auction_type=='option'){
          $query     = '/get_options?auction_id='.$auction_id.'&car_sale_id='.$car_sale_id;
          $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
          $api_url   = $url . $resource . $query . $key;
          
          try{
              $response = $client->request('GET', $api_url);
              $options  = $response->getBody()->getContents();
              $options  = json_decode($options);
              $options  = $options->data; 
          }
          catch(Exception $e){
              echo $e;
          }

          //Set Car Options
          $car_options = array();
          if(!empty($options->car_options)){
            foreach ($options->car_options as $co) { array_push($car_options, "'".$co."'"); }
          }
          else{ $car_options = ""; }

          //Set Car Option Refs
          $car_option_refs = array();
          if(!empty($options->option)){
            foreach ($options->option as $o) { array_push($car_option_refs, "'".$o->name."'"); }
          }
          else{ $car_option_refs = ""; }

          //Set Orange  Button for Car Reference
          if(!empty($options->car_options)){
            foreach ($options->car_options as $co) { 
                $found = array_search("'".$co."'", $car_option_refs);
                if(false !== $found){ 
                  $options->option[$found]->orange = 'orange'; 
                }
                else{ 
                  $new_option_idx = count($options->option);
                  $new_option     = array(
                      'id'      => $new_option_idx, 
                      'name'    => $co, 
                      'orange'  => 'orange' 
                  );
                  array_push($options->option, (object) $new_option);
               }
            }
          }

          $query              = '/update_options?';
          $key                = 'key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';      
          $post_update_option_url  = $url . $resource . $query . $key;

          $car_options     = implode(",", $car_options);
          $car_option_refs = implode(",", $car_option_refs);
          $this->template->set('title', 'Auction | Edit Option');
          $this->template->set('body_class', 'seller-auction-edit-option');
          $this->template->set('type', 'normal');
          $this->set_sidebar_auction_edit($auction_id, $car_sale_id);
          $this->template->set('sidebar', $this->sidebar_auction_edit);
          $this->template->set('data', $options);
          $this->template->set('car_sale_id', $car_sale_id);
          $this->template->set('car_options', $car_options);
          $this->template->set('car_option_refs', $car_option_refs);
          $this->template->set('post_update_option_url', $post_update_option_url);
          $this->template->build('edit_option');
      }
      else{
        $this->set_sidebar_auction_pending();
        $this->template->set('sidebar', $this->sidebar_pending);
        $this->template->build('edit');
      }
  }


  }
?>