<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Auction extends Front_Controller {

  protected $seller_profile;
  protected $seller_login;
  protected $dealer_profile;
  protected $dealer_login;
  protected $sidebar_profile;
  protected $sidebar_auction;
  protected $sidebar_auction_dealer; 
  protected $sidebar_contact_seller;
  protected $sidebar_contact_dealer;
  protected $sidebar_pending;
  protected $sidebar_active;
  protected $sidebar_auction_edit;
  protected $authorized_seller_auctions;
  protected $authorized_seller_cars;
	
	public function __construct() {
      parent::__construct();
      $this->load->library('guzzle');
      $this->load->model('auction/car_trim_model', 'car_trim');
      $this->load->model('auction/car_ref_exterior_model', 'car_ref_exterior');
      $this->load->model('auction/car_ref_interior_model', 'car_ref_interior');

      $this->seller_profile = $this->session->userdata('seller_profile');
      if($this->seller_profile){
        $this->seller_login = $this->session->userdata('login');
        $this->template->set('title', "123Quanto | Seller's Auctions");
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
        $this->template->set('title', '123Quanto | Auctions for Dealer');
        $this->template->set('user_name', $this->dealer_profile->company_name);
        $this->template->set('profile_link', site_url('dealer/profile'));
        $this->template->set('payment_link', site_url('dealer/payment'));
        $this->template->set('setting_link', site_url('dealer/setting'));
      }
      $this->template->set('signout_link', site_url('logout'));
      $this->is_login();
  }

  public function index($auction_id=''){
      //Unset Previous Auction Data
      $this->session->unset_userdata('auction_data_photos');
      $this->session->unset_userdata('auction_data_result');
      
	    $this->template->set('body_class', 'seller-auction-create');
      $this->template->set('type', 'normal');
      $this->set_sidebar_default();
      $this->template->set('sidebar', $this->sidebar_auction);
      $this->template->build('vin_entry'); 
  }

  public function edit($auction_id='', $car_sale_id=''){
      //PROTECTION AGAINST BRUTE FORCE ID Auction & ID Car
      $key_auction = array_search($auction_id, $this->authorized_seller_auctions);
      $key_car     = array_search($car_sale_id, $this->authorized_seller_cars);
      if(false === $key_auction || false === $key_car){ 
        $next = 'next=auction/'.$auction_id.'/edit/'.$car_sale_id;
        redirect('seller?'.$next, 'refresh'); die; 
      }
      //END PROTECTION
      
      $seller_filters = $this->input->get('filters');
      if($seller_filters)
        $this->template->set('seller_filters', $seller_filters);

      $url       = $this->config->item('api_url');
      $resource  = 'car_sale';
      $query     = '/get_review?car_sale_id='.$car_sale_id;
      $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
      $api_url   = $url . $resource . $query . $key; 

      try{ 
        $client     = new GuzzleHttp\Client([ 'base_uri' => $url ]); 
        $response   = $client->request('GET', $api_url);
        $an_auction = $response->getBody()->getContents();
        $an_auction = json_decode($an_auction);
        $an_auction = $an_auction->data; 
      }
      catch(Exception $e){ 
        //echo "Auction: ".$e; 
      }
    
      $this->template->set('an_auction', $an_auction);
      
      $exterior_ref = $this->car_ref_exterior->get_all_exterior();
      $this->template->set('exterior_car', $an_auction->sale->exterior_color);
      $this->template->set('exterior_ref', $exterior_ref); 
      
      $interior_ref = $this->car_ref_interior->get_all_interior();
      $this->template->set('interior_car', $an_auction->sale->interior_color);
      $this->template->set('interior_ref', $interior_ref); 

      //Trim
      $trim_options    = $an_auction->sale->trim_options;
      if($trim_options == array()){ $trim_options = $an_auction->sale->trim_options; }
      $this->template->set('trim_options', $trim_options); 

      //GET CAR OPTIONS
      $options      = $an_auction->conditions->options; 
      $ref_option   = $an_auction->conditions->options_reference; 

      $car_options = array();
      if(!empty($options)){
        foreach ($options as $co) { array_push($car_options, "'".$co."'"); }
      }
      else{ $car_options = ""; } 

      $car_option_refs = array();
      $car_option_refs_2 = array();
      if(!empty($ref_option)){
        foreach ($ref_option as $o) { 
          $ref = array(
                'id' => $o->id,
                'name' => $o->name,
                'green' => '',
            );
          $ref = (object) $ref;
          array_push($car_option_refs, $ref); 
          array_push($car_option_refs_2, "'".$o->name."'"); 
        }
      }else{ $car_option_refs = ""; }

      //SET GREEN BUTTON TO OPTION REFS
      if(!empty($car_options)){
        foreach ($car_options as $co) { 
            $found = array_search($co, $car_option_refs_2); 
            if(false !== $found){ 
              $car_option_refs[$found]->green = 'green'; 
            }
            else{ 
              $new_option_idx = count($car_option_refs);
              $new_option     = array(
                  'id'      => $new_option_idx, 
                  'name'    => $co, 
                  'green'   => 'green' 
              );
              array_push($car_option_refs, (object) $new_option); 
            }
        } 
      }

      $this->template->set('options', $car_option_refs);
      $car_options     = implode(", ", $car_options); 
      $car_option_refs = implode(", ", $car_option_refs); 
      $this->template->set('car_options', $car_options);
      $this->template->set('car_option_refs', $car_option_refs);

      // ================== NEEDS REPAIR =================================
      $needs_repair      = $an_auction->conditions->needs_repair; 
      $needs_repair_refs = $an_auction->conditions->needs_repair_reference; 
      
      //GET CAR NEEDS REPAIR
      $car_needs_repair = array();
      if(!empty($needs_repair)){
        foreach ($needs_repair as $co) { array_push($car_needs_repair, "'".$co."'"); }
      }
      else{ $car_needs_repair = ""; } 

      //SET CAR NEDDS REPAIR REFS
      $car_needs_repair_refs = array();
      $car_needs_repair_refs_2 = array();
      if(!empty($needs_repair_refs)){
        foreach ($needs_repair_refs as $o) { 
          $ref = array(
                'id' => $o->id,
                'name' => $o->name,
                'green' => '',
            );
          $ref = (object) $ref;
          array_push($car_needs_repair_refs, $ref); 
          array_push($car_needs_repair_refs_2, "'".$o->name."'"); 
        }
      }else{ $car_needs_repair_refs = ""; } 

      //SET GREEN BUTTON TO NEEDS REPAIR REFS
      if(!empty($car_needs_repair)){
        foreach ($car_needs_repair as $co) { 
            $found = array_search($co, $car_needs_repair_refs_2); 
            if(false !== $found){ 
              $car_needs_repair_refs[$found]->green = 'green'; 
            }
            else{ 
              $new_option_idx = count($car_needs_repair_refs);
              $new_option     = array(
                  'id'      => $new_option_idx, 
                  'name'    => $co, 
                  'green'   => 'green' 
              );
              array_push($car_needs_repair_refs, (object) $new_option); 
            }
        } 
      }

      $this->template->set('needs_repair', $car_needs_repair_refs);
      $car_needs_repair     = implode(", ", $car_needs_repair); 
      $car_needs_repair_refs = implode(", ", $car_needs_repair_refs); 
      $this->template->set('car_needs_repair', $car_needs_repair);
      $this->template->set('car_needs_repair_refs', $car_needs_repair_refs);

      //FOR DYNAMIC SIDEBAR WHEN UPCOMING & LIVE
      $resource  = 'auction';
      $query     = '/get_auction_times';
      $key       = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
      $api_url   = $url . $resource . $query . $key;

      try{
          $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]);
          $response  = $client->request('GET', $api_url);
          $times     = $response->getBody()->getContents();
          $times     = json_decode($times);
          $times     = $times->data; 
      }
      catch(Exception $e){ 
          //echo $e; 
      }

      /* IF SERVER IS CONFIGURED WITH TIMEZONE DIFFERENCE */
      // $client_time     = time();
      // $server_time     = strtotime($times->server_time_auction);
      // $time_difference = abs($server_time - $client_time); 
      // if($time_difference != 0){
      //     $times->last_create_auction = date("Y-m-d H:i:s", strtotime($times->last_create_auction) + $time_difference);
      //     $times->start_live_auction  = date("Y-m-d H:i:s", strtotime($times->start_live_auction) + $time_difference);
      //     $times->end_live_auction    = date("Y-m-d H:i:s", strtotime($times->end_live_auction) + $time_difference);
      //     $this->template->set('time_difference', $time_difference);
      // }

      $now = date('Y-m-d H:i:s');
      if( $now < $times->start_live_auction || $now > $times->end_live_auction )
        $upcoming_time = true;
      else
        $upcoming_time = false;
      
      if($this->seller_profile && $upcoming_time ){
        $this->set_sidebar_auction_pending($this->seller_profile->id, $auction_id, $car_sale_id);
        $this->template->set('sidebar', $this->sidebar_pending);
      }
      elseif($this->seller_profile){
        $this->set_sidebar_auction_active($this->seller_profile->id, $auction_id, $car_sale_id);
        $this->template->set('sidebar', $this->sidebar_active);
      }

      $this->template->set('auction_id', $auction_id);
      $this->template->set('auction_car', $car_sale_id);
      $this->template->set('auction_vin', $an_auction->sale->vin);
      $resource  = 'car_sale';
      $query     = '/edit';
      $key       = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
      $auction_edit_url   = $url . $resource . $query . $key;
      $this->template->set('auction_edit_url', $auction_edit_url);
      $upload_photo_url   = $this->config->item('api_url') ."car_sale/web_upload/"
                              .$auction_id ."/" .$car_sale_id 
                              ."?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be";
      $this->template->set('upload_photo_url', $upload_photo_url);
      $this->template->build('edit');
  }

  public function vin(){
    if($this->input->post('vin_code')){
        $vin_info = $this->check_vin($this->input->post('vin_code')); 
        if($vin_info->status == "error"){
          $error = $vin_info->error_message; 
          $this->template->set('title', 'Auction');
          $this->template->set('body_class', 'seller-auction-create');
          $this->template->set('type', 'normal');
          $this->set_sidebar_default();
          $this->template->set('sidebar',$this->sidebar_auction);
          $this->template->set('error', $error);
          $this->template->build('vin_entry');
        }else{
          //GET from VIN API Provider then Display Here.
          try{
            $seller_id = $this->seller_profile->id;
            $vin_data = $this->get_vin_details($this->input->post('vin_code'));
            if(!empty($vin_data['error'])){ 
              $vin_error         = true; 
              $vin_error_message = $vin_data['error']; 
            }
            elseif(empty($vin_data)) {
              $vin_error         = true; 
              $vin_error_message = "Invalid VIN Number: No Record Found."; 
            }
            else{ $vin_error = false; }

            if((!$vin_error)){
              $car_specification = array(
                    'model_make_id' => $vin_data['vin_details']['make'],
                    'model_name'    => $vin_data['vin_details']['model'],
                    'model_year'    => $vin_data['vin_details']['year']
              );
              $trim_options = $this->car_query_trim_db($car_specification, $vin_data['vin_details']['trim'], 'string');
              $this->session->set_userdata('vin_result', (object) $vin_data['vin_details']);
              $this->template->set('body_class', 'seller-auction-create-vin-result');
              $this->template->set('type', 'normal');
              $this->set_sidebar_default();
              $this->template->set('sidebar',$this->sidebar_auction);
              $this->template->set('data', (object) $vin_data['vin_details']);
              $this->template->set('trim_options', $trim_options); 
              $this->template->set('seller_id', $seller_id);
              $this->template->build('vin_result');
            }else{
              $this->template->set('title', 'Auction');
              $this->template->set('body_class', 'seller-auction-create');
              $this->set_sidebar_default();
              $this->template->set('sidebar',$this->sidebar_auction);
              $this->template->set('vin_error_message', $vin_error_message);
              $this->template->set('error',$vin_data);
              $this->template->build('vin_entry');
            }
            
          }
          catch(Exception $e ) {
            //echo $e;
          }
        }
        
    }else{
        //Unset Previous Auction Data
        $this->session->unset_userdata('auction_data_photos');
        $this->session->unset_userdata('auction_data_result');

        $this->template->set('title', 'Auction');
        $this->template->set('body_class', 'seller-auction-create');
        $this->template->set('type', 'normal');
        $this->set_sidebar_default(); 
        $this->template->set('sidebar',$this->sidebar_auction);
        $this->template->build('vin_entry');
    }
  }

  public function photos($auction_id='', $auction_car='', $auction_vin=''){
      //Get transmission data from vin result
      if($this->input->post() || $this->session->userdata('auction_data_photos'))
      {
        /* Check Transmission */
        //$transmission = $this->input->post('transmission');
        //$this->session->set_userdata('transmission', $transmission);

        //Only GET POST data that is newly submitted
        if( $this->input->post() && empty($this->session->userdata('auction_data_photos')) ){
          $auction_data = $this->input->post(); 
          $this->session->set_userdata('auction_data_photos', $auction_data);
        }
        elseif( empty($auction_data) && !empty($this->session->userdata('auction_data_photos')) ){
          $auction_data = $this->session->userdata('auction_data_photos');
        }

        //Only Create Auction that is new
        if( empty($this->session->userdata('auction_data_result')) ){
          $auction_result  = $this->create_auction_for_web($auction_data); 
          $this->append_authorized_auctions($auction_result->auction_id);
          $this->append_authorized_cars($auction_result->auction_car);
          $this->session->set_userdata('auction_data_result', $auction_result);
        }
        else{
          $auction_result  = $this->session->userdata('auction_data_result');
        }
        
        if(!$auction_result){ redirect('auction/vin?error=vin_result', 'refresh'); exit; }
        else{
          //Check Existing Photo on Server for the Auctions
          $auction_multimedia = $this->check_multimedia($auction_result->auction_car);
          foreach ($auction_multimedia as $m) {
              $auction_files[$m->multimedia_code] = 'active';

          } 
          
          $upload_photo_url   = $this->config->item('api_url') ."car_sale/web_upload/"
                              .$auction_result->auction_id ."/" .$auction_result->auction_car 
                              ."?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be";
          $this->template->set('body_class', 'seller-auction-create-upload-photo');
          $this->template->set('type', 'normal');
          $this->set_sidebar_default(); 
          $this->template->set('sidebar',$this->sidebar_auction);
          $this->template->set('seller_id', $this->seller_profile->id);
          $this->template->set('auction_id', $auction_result->auction_id);
          $this->template->set('auction_car', $auction_result->auction_car);
          $this->template->set('auction_vin', $auction_data['vin']);
          $this->template->set('auction_files', $auction_files);
          $this->template->set('next', 'Next');
          $this->template->set('upload_photo_url', $upload_photo_url);
          $this->template->build('photos_upload');
        }
      }
      elseif(!empty($auction_id) && !empty($auction_car)){
          //Check Existing Photo on Server for the Auctions
          $auction_multimedia = $this->check_multimedia($auction_car);
          foreach ($auction_multimedia as $m) {
              $auction_files[$m->multimedia_code] = 'active';

          } 
          
          $upload_photo_url   = $this->config->item('api_url') ."car_sale/web_upload/"
                              .$auction_id ."/" .$auction_car 
                              ."?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be";
          $this->template->set('body_class', 'seller-auction-create-upload-photo');
          $this->template->set('type', 'normal');
          $this->set_sidebar_default(); 
          $this->template->set('sidebar',$this->sidebar_auction);
          $this->template->set('seller_id', $this->seller_profile->id);
          $this->template->set('auction_id', $auction_id);
          $this->template->set('auction_car', $auction_car);
          $this->template->set('auction_vin', $auction_vin);
          $this->template->set('auction_files', $auction_files);
          $this->template->set('next', 'Back to edit');
          $this->template->set('upload_photo_url', $upload_photo_url);
          $this->template->build('photos_upload');
      }
      else{ 
        redirect('auction/vin?error=unauthorized_access', 'refresh'); exit; 
      }
  }

  private function create_auction_for_web($auction=array()){

    $url            = $this->config->item('api_url');
    $resource       = 'car_sale';
    try{ $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]); } catch(Exception $e){ echo $e; }
    $query          = '/create_for_auction_web';
    $key            = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
    $api_url        = $url . $resource . $query . $key;

    try{
        $client          = new GuzzleHttp\Client([ 'base_uri' => $url ]);
        $response        = $client->request('POST', $api_url, 
                              [
                                'form_params' => 
                                  [
                                      'seller_id'   => $auction['seller_id'],
                                      'vin'         => $auction['vin'],
                                      'make'        => $auction['make'],
                                      'model'       => $auction['model'],
                                      'year'        => $auction['year'],
                                      'trim'        => $auction['trim'],
                                      'trim_id'     => $auction['trim_id'], 
                                      'trim_ids'    => $auction['trim_ids'], 
                                      'trim_models' => $auction['trim_models'],
                                      'body_style'  => $auction['body_style'],
                                      'passengers'  => $auction['seats']
                                  ]
                              ]
                          );
        $result          = $response->getBody()->getContents();
        $result          = json_decode($result);
        $result          = $result->data;
        return $result;
    }
    catch(Exception $e){
        //echo $e;
        return false; 
    }

  }

  public function detail($auction_id='', $auction_role='seller', $auction_car=''){
      $key_auction = array_search($auction_id, $this->authorized_seller_auctions);
      $key_car     = array_search($auction_car, $this->authorized_seller_cars);
      $url = $this->config->item('api_url');
      try{ $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]); } catch(Exception $e){ echo $e; }
      
        if($auction_role=='seller'){
          if(false !== $key_auction && false !== $key_car){

            $resource  = 'car_sale'; 
            $query     = '/get_review?car_sale_id='.$auction_car; 
            $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
            $api_url   = $url . $resource . $query . $key;

            try{
                $response                 = $client->request('GET', $api_url);
                $detail                   = $response->getBody()->getContents();
                $detail                   = json_decode($detail);
                $detail                   = $detail->data; //var_dump($detail); die;
                $car_auction              = $detail->auction; 
                $car_sale                 = $detail->sale; //var_dump($car_sale); die;
                $car_condition            = $detail->conditions;
                $car_multimedia           = $detail->multimedia;
                $car_declaration          = $detail->declaration;
                $car_declaration_details  = $detail->declaration_details;

                $declare_answers        = array();
                foreach ($car_declaration as $a) {
                  array_push($declare_answers, $a->answer);
                }
            }
            catch(Exception $e){
                //echo $e;
            }

            //get auction times
            $resource  = 'auction';
            $query     = '/get_auction_times';
            $key       = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
            $api_url   = $url . $resource . $query . $key;
    
            try{
                $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]);
                $response  = $client->request('GET', $api_url);
                $times     = $response->getBody()->getContents();
                $times     = json_decode($times);
                $times     = $times->data; 
            }
            catch(Exception $e){ 
                //echo $e; 
            }

            $auction_finished = time() - strtotime($times->end_live_auction);
            if($auction_finished > 0){ $auction_day = '1'; }
            else{ $auction_day = '0'; }

            /* IF SERVER IS CONFIGURED WITH TIMEZONE DIFFERENCE */
            // $client_time     = time();
            // $server_time     = strtotime($times->server_time_auction);
            // $time_difference = abs($server_time - $client_time); 
            // if($time_difference != 0){
            //     $times->last_create_auction = date("Y-m-d H:i:s", strtotime($times->last_create_auction) + $time_difference);
            //     $times->start_live_auction  = date("Y-m-d H:i:s", strtotime($times->start_live_auction) + $time_difference);
            //     $times->end_live_auction    = date("Y-m-d H:i:s", strtotime($times->end_live_auction) + $time_difference);
            //     $this->template->set('time_difference', $time_difference);
            // }
            
            $this->template->set('body_class', 'seller-auction-detail');
            $this->template->set('type', 'normal');
            $now = date('Y-m-d H:i:s');
            if($this->seller_profile && ( $now < $times->start_live_auction || $now > $times->end_live_auction ) ){
              $this->set_sidebar_auction_pending($this->seller_profile->id, $auction_id, $auction_car);
              $this->template->set('sidebar', $this->sidebar_pending);
            }
            elseif($this->seller_profile){
              $this->set_sidebar_auction_active($this->seller_profile->id, $auction_id, $auction_car);
              $this->template->set('sidebar', $this->sidebar_active);
            }

            $this->template->set('auction_id', $auction_id);
            $this->template->set('auction_day', $auction_day);
            $this->template->set('auction_time', $times);
            $this->template->set('auction_car', $auction_car);
            $this->template->set('car_auction', $car_auction);
            $this->template->set('car_sale', $car_sale);
            $this->template->set('car_condition', $car_condition);
            $this->template->set('car_multimedia', $car_multimedia);
            $this->template->set('car_declaration', $car_declaration);
            $this->template->set('car_declaration_details', $car_declaration_details);
            $this->template->set('declare_answers', $declare_answers);
            $this->template->build('detail_seller');
          }else{
            redirect('seller', 'refresh');
          }
        }
        elseif($auction_role=='dealer'){
          $dealer_id = $this->dealer_profile->id;
          $resource  = 'dealers';
          $query     = '/detail_auction?auction_id='.$auction_id.'&dealer_id='.$dealer_id;
          $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
          $api_url   = $url . $resource . $query . $key;

          try{
              $response                 = $client->request('GET', $api_url);
              $detail                   = $response->getBody()->getContents();
              $detail                   = json_decode($detail);
              $detail                   = $detail->data; //var_dump($detail); die;
              $car_auction              = $detail->car_auction;
              $car_details              = $detail->car_details; 
              $car_condition            = $detail->car_conditions;
              $car_multimedia           = $detail->car_multimedia;
              $car_declaration          = $detail->car_declaration;
              $car_declaration_details  = $detail->car_declaration_details;
          }
          catch(Exception $e){
              //echo $e;
          }

          //get auction times
          $resource  = 'dealers';
          $query     = '/get_auction_times';
          $key       = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
          $api_url   = $url . $resource . $query . $key;
  
          try{
              $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]);
              $response  = $client->request('GET', $api_url);
              $times     = $response->getBody()->getContents();
              $times     = json_decode($times);
              $times     = $times->data; 
          }
          catch(Exception $e){ 
              //echo $e; 
          }

          $auction_finished = time() - strtotime($times->end_live_auction);
          if($auction_finished > 0){ $auction_day = '1'; }
          else{ $auction_day = '0'; }

          //Check auction status
          $now = date('Y-m-d H:i:s');
          if($now >= $car_auction->start_time && $now <= $car_auction->endtime){
            $live = 1;
          }else{ $live = 0; }
          $this->template->set('live', $live);

          if($auction_car == 'won'){
            $this->template->set('won', true);
          }
          
          $key='key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
          $post_dealer_addbid         = $url .'bid/create?'.$key;
          $post_dealer_addproxybid    = $url .'bid/proxy/set?'.$key;
          $post_dealer_removeproxybid = $url .'bid/proxy/remove?'.$key;
          $get_dealer_single_auction_stream  = $url .'bid/single_auction_highest/' .$auction_id .'/' .$this->dealer_profile->id .'?' .$key;
          $this->template->set('post_dealer_addbid', $post_dealer_addbid);
          $this->template->set('post_dealer_addproxybid', $post_dealer_addproxybid);
          $this->template->set('post_dealer_removeproxybid', $post_dealer_removeproxybid);
          $this->template->set('get_dealer_single_auction_stream', $get_dealer_single_auction_stream);
          $this->template->set('dealer_id', $dealer_id);


          $this->set_sidebar_profile_dealer();
          $this->template->set('sidebar', $this->sidebar_profile);
          
          $post_dealer_addwatchlist = $url .'dealers/add_watchlist?'.$key;
          $post_dealer_remwatchlist = $url .'dealers/remove_watchlist?'.$key;
          $this->template->set('post_dealer_addwatchlist', $post_dealer_addwatchlist);
          $this->template->set('post_dealer_remwatchlist', $post_dealer_remwatchlist);
          
          $this->template->set('auction_id', $auction_id);
          $this->template->set('auction_day', $auction_day);
          $this->template->set('auction_time', $times);
          $this->template->set('auction_car', $auction_car);
          $this->template->set('car_auction', $car_auction);
          $this->template->set('car_details', $car_details);
          $this->template->set('car_condition', $car_condition);
          $this->template->set('car_multimedia', $car_multimedia);
          $this->template->set('car_declaration', $car_declaration);
          $this->template->set('car_declaration_details', $car_declaration_details);
          $this->template->set('title', 'Auction Detail');
          $this->template->set('body_class', 'dealer-auction-detail');
          $this->template->set('type', 'normal');
          $this->template->build('detail_dealer');
      }else{
        redirect('seller', 'refresh');
      }
  }

  public function inbox($auction_id='', $auction_role='', $auction_dealer=''){  

      $url            = $this->config->item('api_url');
      $resource       = 'auction';
      try{ $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]); } catch(Exception $e){ echo $e; }

      if($auction_role=='seller'){
          //GET AUTHORIZED AUCTION
          $key_auction = array_search($auction_id, $this->authorized_seller_auctions);
          if(false === $key_auction){ redirect('seller', 'refresh'); die; }

          //GET AUCTION INBOX
          $query          = '/get_messages?seller_id='.$this->seller_profile->id.'&auction_id='.$auction_id;
          $key            = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
          $api_url        = $url . $resource . $query . $key; 
          try{
              $response   = $client->request('GET', $api_url);
              $inbox      = $response->getBody()->getContents();
              $inbox      = json_decode($inbox);
              $inbox      = $inbox->data; //var_dump($inbox); die;
              $messages   = $inbox->messages;
              $unread     = $inbox->total_unread_messages;
          }catch(Exception $e){ 
              //echo $e; 
          }

          $this->set_sidebar_default();
          $this->template->set('sidebar', $this->sidebar_auction);
          $this->template->set('body_class', 'seller-notification');
          $this->template->set('type', 'normal');
          $this->template->set('title', 'Auction | Notification');
          $this->template->set('conversations', $messages);
          $this->template->set('unread', $unread);
          $this->template->build('inbox_seller');
      }
      elseif($auction_role=='dealer'){
          $resource = 'dealers';
          $query    = '/inbox?dealer_id='.$this->dealer_profile->id;
          $key      = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';

          $api_url  = $url . $resource . $query . $key; 
          try{
              $response   = $client->request('GET', $api_url);
              $inbox      = $response->getBody()->getContents();
              $inbox      = json_decode($inbox);
              $inbox      = $inbox->data; //var_dump($inbox); die;
              $messages   = $inbox->messages;
              $unread     = $inbox->total_unread_messages;
          }catch(Exception $e){ 
              //echo $e; 
          }

          $this->set_sidebar_default_dealer(); 
          $this->template->set('sidebar', $this->sidebar_auction_dealer);
          $this->template->set('body_class', 'dealer-notification');
          $this->template->set('type', 'normal');
          $this->template->set('title', 'Auction | Notification');
          $this->template->set('conversations', $messages);
          $this->template->set('unread', $unread);
          $this->template->build('inbox_dealer');
      }

  }

  public function notification($auction_id='', $auction_role='', $message_id=''){
      //GET SINGLE AUCTION INFO
      $url            = $this->config->item('api_url');
      $resource       = 'auction';
      try{ $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]); } catch(Exception $e){ echo $e; }
      $query          = '/live_auction?auction_id='.$auction_id;
      $key            = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
      $api_url        = $url . $resource . $query . $key;
      try{
          $response   = $client->request('GET', $api_url);
          $auction    = $response->getBody()->getContents();
          $auction    = json_decode($auction);
          $auction    = $auction->data; //var_dump($auction); die;
      }
      catch(Exception $e){
          //echo $e;
      }

      if($auction_role=='seller') {
        //GET AUTHORIZED AUCTION
        $key_auction = array_search($auction_id, $this->authorized_seller_auctions);
        if(false === $key_auction){ redirect('seller', 'refresh'); die; }

        //GET AUCTION INBOX
        $query          = '/get_messages?seller_id='.$this->seller_profile->id.'&auction_id='.$auction_id;
        $key            = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $api_url        = $url . $resource . $query . $key;
        try{
            $response   = $client->request('GET', $api_url);
            $inbox      = $response->getBody()->getContents();
            $inbox      = json_decode($inbox);
            $inbox      = $inbox->data; //var_dump($inbox); die;
            $messages   = $inbox->messages;
            $unread     = $inbox->total_unread_messages;
        }catch(Exception $e){ 
            //echo $e; 
        }
        
        $inbox_list = "";
        foreach ($messages as $m) {
          if($m->auction_id != $auction_id){
            $chatroom = site_url('auction/notification/'.$auction_id.'/seller/'.$m->message_id);
            $style = '';
            if($m->unread_messages > 0){
              $style = 'style="background: #f4f5f7;"';
            }

            $inbox_list .= file_get_contents(FCPATH . 'assets/templates/sidebar/seller/inbox.php');
            $inbox_list  = str_replace('{avatar}', $m->dealer_avatar , $inbox_list);
            $inbox_list  = str_replace('{name}', $m->dealer_name , $inbox_list);
            $inbox_list  = str_replace('{content}', $m->content , $inbox_list);
            $inbox_list  = str_replace('{chatroom}', $chatroom , $inbox_list);
            if($m->unread_messages > 0) { 
              $chatroom_unread = '<span class="badge">'.$m->unread_messages.'</span>';
            }else{
              $chatroom_unread = '';
            }
            $inbox_list  = str_replace('{unread_per_chat}', $chatroom_unread, $inbox_list);
            $inbox_list  = str_replace('{datetime}', date('g:i a', strtotime($m->datetime)) , $inbox_list);
          }
        }

        //GET CHATROOM
        $any_chat    = true;
        if($messages == array()){ $any_chat  = false; }
        $query          = '/get_message_content?message_id='.$message_id;
        $key            = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $api_url        = $url . $resource . $query . $key;
        try{
            $response   = $client->request('GET', $api_url);
            $chat       = $response->getBody()->getContents();
            $chat       = json_decode($chat);
            $chat       = $chat->data;
            if($chat != array()){
              $dealer_avatar  = $chat[0]->dealer_avatar;
              $dealer_name    = $chat[0]->dealer_name;
            }else{
              $dealer_avatar  = "";
              $dealer_name    = "";
            }   
        }catch(Exception $e){ 
            //echo $e; 
        }

        //SEND MESSAGE
        $query = '/send_message';
        $key   = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $send_message_url = $url . $resource . $query . $key;

        if($unread > 0){
          $unread = '<span class="badge">'.$unread.'</span>';
        }
        $this->sidebar_contact_seller = file_get_contents(FCPATH . 'assets/templates/sidebar/seller/contact.php');
        $this->sidebar_contact_seller = str_replace('{unread_message}', $unread, $this->sidebar_contact_seller);
        $this->sidebar_contact_seller = str_replace('{list_inbox}', $inbox_list , $this->sidebar_contact_seller);
        $this->sidebar_contact_seller = str_replace('{dashboard_link}', site_url('seller'), $this->sidebar_contact_seller);
        $this->sidebar_contact_seller = str_replace('{preference_link}', site_url('seller/preference'), $this->sidebar_contact_seller);
        //$this->sidebar_contact_seller = str_replace('{more_link}', site_url('seller/more'), $this->sidebar_contact_seller);
        $this->template->set('auction', $auction);
        $this->template->set('any_chat', $any_chat);
        $this->template->set('inbox', $inbox->messages);
        $this->template->set('chat', $chat);
        $this->template->set('seller_id', $this->seller_profile->id);
        $this->template->set('dealer_avatar', $dealer_avatar);
        $this->template->set('dealer_name', $dealer_name);
        $this->template->set('message_id', $message_id);
        $this->template->set('send_message_url', $send_message_url);
        $this->template->set('sidebar', $this->sidebar_contact_seller);
        $this->template->set('body_class', 'seller-notification');
        $this->template->set('type', 'normal');
        $this->template->set('title', 'Auction | Notification');
        $this->template->build('chat_seller');
     }
     elseif ($auction_role=='dealer') {
        //GET DEALER INBOX
        $resource       = 'dealers'; 
        $query          = '/inbox?dealer_id='.$this->dealer_profile->id;
        $key            = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $api_url        = $url . $resource . $query . $key;

        try{
            $response   = $client->request('GET', $api_url);
            $inbox      = $response->getBody()->getContents();
            $inbox      = json_decode($inbox);
            $inbox      = $inbox->data;
            $messages   = $inbox->messages;
            $unread     = $inbox->total_unread_messages;
        }
        catch(Exception $e){
            //echo $e;
        }

        $this->sidebar_contact_dealer = file_get_contents(FCPATH . 'assets/templates/sidebar/dealer/contact.php');
        $this->sidebar_contact_dealer = str_replace('{unread_message}', $unread, $this->sidebar_contact_dealer);
        $this->sidebar_contact_dealer = str_replace('{dealer_notification_link}', site_url('auction/inbox/dealer'), $this->sidebar_contact_dealer);
        $this->sidebar_contact_dealer = str_replace('{dealer_dashboard_link}', site_url('dealer'), $this->sidebar_contact_dealer);
        $this->sidebar_contact_dealer = str_replace('{dealer_auction_link}', site_url('dealer/auction'), $this->sidebar_contact_dealer);
        $this->sidebar_contact_dealer = str_replace('{dealer_preference_link}', site_url('dealer/preference'), $this->sidebar_contact_dealer);
        $this->sidebar_contact_dealer = str_replace('{dealer_more_link}', site_url('dealer/more'), $this->sidebar_contact_dealer);
        
        $inbox_list = "";
        
        foreach ($messages as $m) {
          $chatroom = site_url('auction/notification/'.$m->auction_id.'/dealer/'.$m->message_id);
          $style = '';
          if($m->unread_messages > 0){
            $style = 'style="background: #f4f5f7;"';
          }

          $inbox_list .= file_get_contents(FCPATH . 'assets/templates/sidebar/dealer/inbox.php');
          $inbox_list  = str_replace('{avatar}', $m->seller_avatar , $inbox_list);
          $inbox_list  = str_replace('{name}', $m->seller_name , $inbox_list);
          $inbox_list  = str_replace('{content}', $m->content , $inbox_list);
          $inbox_list  = str_replace('{chatroom}', $chatroom , $inbox_list);
          $inbox_list  = str_replace('{datetime}', date('H:i:s', strtotime($m->datetime)) , $inbox_list);
        }

        $this->sidebar_contact_dealer = str_replace('{list_inbox}', $inbox_list , $this->sidebar_contact_dealer);

        //Get CHATROOM
        $query          = '/get_message_content?auction_id='.$auction_id.'&dealer_id='.$this->dealer_profile->id;
        $key            = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $api_url        = $url . $resource . $query . $key;
        
        try{
            $response   = $client->request('GET', $api_url);
            $chat      = $response->getBody()->getContents();
            $chat      = json_decode($chat);
            $chat      = $chat->data;
            if($chat != array()){
              $seller_avatar  = $chat[0]->seller_avatar;
              $seller_name    = $chat[0]->seller_name;
            }else{
              $seller_avatar  = "";
              $seller_name    = "";
            }
            
        }
        catch(Exception $e){
            //echo $e;
        }

        //Send Message
        $query = '/send_message';
        $key   = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $send_message_url = $url . $resource . $query . $key;

        $this->template->set('auction', $auction);
        $this->template->set('inbox', $inbox->messages);
        $this->template->set('chat', $chat);
        $this->template->set('dealer_id', $this->dealer_profile->id);
        $this->template->set('seller_avatar', $seller_avatar);
        $this->template->set('seller_name', $seller_name);
        $this->template->set('sidebar', $this->sidebar_contact_dealer);
        $this->template->set('send_message_url', $send_message_url);
        $this->template->set('body_class', 'dealer-notification');
        $this->template->set('type', 'normal');
        $this->template->set('title', 'Auction | Notification');
        $this->template->build('chat_dealer');
     }
  }

  public function history($auction_id='', $auction_role='seller'){
     if($auction_role=='seller'){ 
        //PROTECTION AGAINST BRUTE FORCE ID Auction & ID Car
        $key_auction = array_search($auction_id, $this->authorized_seller_auctions);
        if(false === $key_auction){ redirect('seller', 'refresh'); die; }
        //END PROTECTION
        $url            = $this->config->item('api_url');
        $resource       = 'auction';
        try{ $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]); } catch(Exception $e){ echo $e; }
        $query          = '/live_auction?auction_id='.$auction_id;
        $key            = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $api_url        = $url . $resource . $query . $key;
        try{
            $response   = $client->request('GET', $api_url);
            $history    = $response->getBody()->getContents();
            $history    = json_decode($history);
            $history    = $history->data;
        }
        catch(Exception $e){
            //echo $e;
        }
        //get auction times
        $resource  = 'auction';
        $query     = '/get_auction_times';
        $key       = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $api_url   = $url . $resource . $query . $key;

        try{
            $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]);
            $response  = $client->request('GET', $api_url);
            $times     = $response->getBody()->getContents();
            $times     = json_decode($times);
            $times     = $times->data; 
        }
        catch(Exception $e){ 
            //echo $e; 
        }

        /* IF SERVER IS CONFIGURED WITH TIMEZONE DIFFERENCE */
        // $client_time     = time();
        // $server_time     = strtotime($times->server_time_auction);
        // $time_difference = abs($server_time - $client_time); 
        // if($time_difference != 0){
        //     $times->last_create_auction = date("Y-m-d H:i:s", strtotime($times->last_create_auction) + $time_difference);
        //     $times->start_live_auction  = date("Y-m-d H:i:s", strtotime($times->start_live_auction) + $time_difference);
        //     $times->end_live_auction    = date("Y-m-d H:i:s", strtotime($times->end_live_auction) + $time_difference);
        //     $this->template->set('time_difference', $time_difference);
        // }
        
        $this->template->set('body_class', 'seller-auction-detail');
        $this->template->set('type', 'normal');
        $now = date('Y-m-d H:i:s');
        if($this->seller_profile && ( $now < $times->start_live_auction || $now > $times->end_live_auction ) ){
          $this->set_sidebar_auction_pending($this->seller_profile->id, $auction_id, $history->car_details->car_sale_id);
          $this->template->set('sidebar', $this->sidebar_pending);
        }
        elseif($this->seller_profile){
          $this->set_sidebar_auction_active($this->seller_profile->id, $auction_id, $history->car_details->car_sale_id);
          $this->template->set('sidebar', $this->sidebar_active);
        }

        $this->template->set('body_class', 'seller-auction-detail-history');
        $this->template->set('type', 'normal');
        $this->template->set('data', $history);
        $this->template->build('history'); 
     }
  }

  public function winner($auction_id='', $auction_role='seller'){
      $url              = $this->config->item('api_url');
      try{ $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]); } catch(Exception $e){ echo $e; }
      if($auction_role=='seller'){ 
        //PROTECTION AGAINST BRUTE FORCE ID Auction & ID Car
        $key_auction = array_search($auction_id, $this->authorized_seller_auctions);
        if(false === $key_auction){ redirect('seller', 'refresh'); die; }
        //END PROTECTION
        $resource       = 'auction';
        $query          = '/highest_bid?auction_id='.$auction_id;
        $key            = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $api_url        = $url . $resource . $query . $key;
        try{
            $response   = $client->request('GET', $api_url);
            $won        = $response->getBody()->getContents();
            $won        = json_decode($won);
            $won        = $won->data; //var_dump($won); die;
        }
        catch(Exception $e){
            //echo $e;
        }
        //get auction times
        $resource  = 'auction';
        $query     = '/get_auction_times';
        $key       = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $api_url   = $url . $resource . $query . $key;

        try{
            $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]);
            $response  = $client->request('GET', $api_url);
            $times     = $response->getBody()->getContents();
            $times     = json_decode($times);
            $times     = $times->data; 
        }
        catch(Exception $e){ 
            //echo $e; 
        }

        /* IF SERVER IS CONFIGURED WITH TIMEZONE DIFFERENCE */
        // $client_time     = time();
        // $server_time     = strtotime($times->server_time_auction);
        // $time_difference = abs($server_time - $client_time); 
        // if($time_difference != 0){
        //     $times->last_create_auction = date("Y-m-d H:i:s", strtotime($times->last_create_auction) + $time_difference);
        //     $times->start_live_auction  = date("Y-m-d H:i:s", strtotime($times->start_live_auction) + $time_difference);
        //     $times->end_live_auction    = date("Y-m-d H:i:s", strtotime($times->end_live_auction) + $time_difference);
        //     $this->template->set('time_difference', $time_difference);
        // }
        
        $this->template->set('body_class', 'seller-auction-detail');
        $this->template->set('type', 'normal');
        $now = date('Y-m-d H:i:s');
        if($this->seller_profile && ( $now < $times->start_live_auction || $now > $times->end_live_auction ) ){
          $this->set_sidebar_auction_pending($this->seller_profile->id, $auction_id, $won->car_sale_id);
          $this->template->set('sidebar', $this->sidebar_pending);
        }
        elseif($this->seller_profile){
          $this->set_sidebar_auction_active($this->seller_profile->id, $auction_id, $won->car_sale_id);
          $this->template->set('sidebar', $this->sidebar_active);
        }

        $this->template->set('body_class', 'seller-auction-detail-winner');
        $this->template->set('type', 'normal');
        $this->template->set('data', $won);
        $this->template->build('winner_seller'); 

      }elseif($auction_role=='dealer'){
        $resource       = 'dealers';
        $query          = '/detail_won_auction?auction_id='.$auction_id;
        $key            = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $api_url        = $url . $resource . $query . $key;
        try{
            $response   = $client->request('GET', $api_url);
            $won        = $response->getBody()->getContents();
            $won        = json_decode($won);
            $won        = $won->data; //var_dump($won); die;
        }catch(Exception $e){ 
            //echo $e; 
        }

        $this->set_sidebar_default_dealer();
        $this->template->set('sidebar', $this->sidebar_auction_dealer);
        $this->template->set('data', $won);
        $this->template->set('auction_id', $auction_id);
        $this->template->set('title', 'Auction Won');
        $this->template->set('body_class', 'dealer-auction-won');
        $this->template->set('type', 'normal');
        $this->template->build('winner_dealer');
     }
  }

  public function purchase($auction_id='', $auction_role='dealer'){
      $url            = $this->config->item('api_url');
      try{ $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]); } catch(Exception $e){ echo $e; }
      // Get Seller Info
      $resource       = 'dealers';
      $query          = '/detail_won_auction?auction_id='.$auction_id;
      $key            = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
      $api_url        = $url . $resource . $query . $key;
      try{
          $response   = $client->request('GET', $api_url);
          $won        = $response->getBody()->getContents();
          $won        = json_decode($won);
          $won        = $won->data; 
      }catch(Exception $e){ 
          //echo $e; 
      }
      //Get Seller purchased
      $resource       = 'sellers';
      $query          = '/get_purchased?seller_id='.$won->seller_id;
      $key            = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
      $api_url        = $url . $resource . $query . $key;
      try{
          $response   = $client->request('GET', $api_url);
          $purchase   = $response->getBody()->getContents();
          $purchase   = json_decode($purchase);
          $purchase   = $purchase->data; 
          $body_styles= $purchase->body_styles;
          $brands     = $purchase->brands;
      }catch(Exception $e){ 
          //echo $e; 
      }

      $this->template->set('data', $won);
      $this->template->set('body_styles', $body_styles);
      $this->template->set('brands', $brands);
      $this->set_sidebar_default_dealer();
      $this->template->set('sidebar', $this->sidebar_auction_dealer);
      $this->template->set('title', 'Auction Won');
      $this->template->set('body_class', 'seller-auction-create');
      $this->template->set('type', 'normal');
      $this->template->set('auction_id', $auction_id);
      $this->template->build('seller_looking_to_purchase');
    
  }

  //AJAX API - Set Auction
  public function set_auction($auction_id='0', $auction_live='active'){
    
      $url       = $this->config->item('api_url');
      $resource  = 'auction';
      $query     = '/create_new';
      $key       = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
      $api_url   = $url . $resource . $query . $key; 
      try{
          $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]);
          $response  = $client->request('POST', $api_url, 
                          [
                            'form_params' => 
                              [
                                  'auction_id'  => $auction_id
                              ]
                          ]
                      );
          $live      = $response->getBody()->getContents();
          $live      = json_decode($live); 
      }
      catch(Exception $e){
          //echo $e;
          echo 'false';
      }
      if($live->status=='success'){
          $live             = $live->data;
          $live->start_time = date('j F Y g:i a', strtotime($live->start_time));
          $live->endtime    = date('j F Y g:i a', strtotime($live->endtime));
          echo json_encode($live);
      }else{
          $live->start_time = false;
          $live->endtime    = false;
          echo json_encode($live);
      }
      
  }

  //AJAX API - Delete Auction
  public function delete($auction_id='0', $car_sale_id='0'){
      
      $url       = $this->config->item('api_url');
      $resource  = 'auction';
      $query     = '/delete';
      $key       = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
      $api_url   = $url . $resource . $query . $key;

      try{
          $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]);
          $response  = $client->request('POST', $api_url, 
                          [
                            'form_params' => 
                              [
                                  'auction_id'   => $auction_id,
                                  'car_sale_id'  => $car_sale_id
                              ]
                          ]
                      );
          $deleted_auction = $response->getBody()->getContents();
          $deleted_auction = json_decode($deleted_auction);
          $deleted_auction = $deleted_auction->data;
      }
      catch(Exception $e){
          //echo $e;
          echo 'false';
      }
      echo json_encode($deleted_auction);

  }

  //VINQuery-API Exploration, Thus reportType=2/EXT
  private function vin_query($vin){
      //$accesscode = "bf31dfde-34f1-4174-bac2-cb8a1fc341a6";
      $accesscode = $this->config->item('vin_query_key');
      $api_url    = "http://ws.vinquery.com/restxml.aspx?accesscode=".$accesscode."&reportType=2&vin=".$vin."" ;
      $client     = new GuzzleHttp\Client([ 'base_uri' => $api_url ]);
      $response   = $client->request('GET', $api_url);
      $contents   = $response->getBody()->getContents();
      $data       = simplexml_load_string($contents);

      var_dump($data->VIN['Number']); //vin number
      var_dump($data->VIN->Vehicle->Item[1]['Key']); //Year
      var_dump($data->VIN->Vehicle->Item[1]['Value']); 
      var_dump($data->VIN->Vehicle->Item[2]['Key']); //Make
      var_dump($data->VIN->Vehicle->Item[2]['Value']); 
      var_dump($data->VIN->Vehicle->Item[3]['Key']); //Model
      var_dump($data->VIN->Vehicle->Item[3]['Value']); 
      var_dump($data->VIN->Vehicle->Item[4]['Key']); //Trim
      var_dump($data->VIN->Vehicle->Item[4]['Value']); 
      var_dump($data->VIN->Vehicle->Item[7]['Key']); //Body style
      var_dump($data->VIN->Vehicle->Item[7]['Value']); 
      var_dump($data->VIN->Vehicle->Item[10]['Key']); //Transmission
      var_dump($data->VIN->Vehicle->Item[10]['Value']); 
      var_dump($data->VIN->Vehicle->Item[14]['Key']); //Fuel 
      var_dump($data->VIN->Vehicle->Item[14]['Value']);

      var_dump($data->VIN->Vehicle->Item[34]['Key']); //Exterior color
      var_dump($data->VIN->Vehicle->Item[34]['Value']); 
      var_dump($data->VIN->Vehicle->Item[64]['Key']); //Price
      var_dump($data->VIN->Vehicle->Item[64]['Value']); 
      
      return $data;
  }

  //Check VIN
  private function check_vin($vin){
    $url            = $this->config->item('api_url');
    $resource       = 'car_sale';
    $query          = '/check_vin';
    $key            = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
    $api_url        = $url . $resource . $query . $key; 

    try{
        $client          = new GuzzleHttp\Client([ 'base_uri' => $url ]);
        $response        = $client->request('POST', $api_url, 
                              [
                                'form_params' => 
                                  [
                                      'vin'     => $vin
                                  ]
                              ]
                          );
        $content          = $response->getBody()->getContents();
        $result           = json_decode($content); 
        return $result;
    }
    catch(Exception $e){
        return false;
    }
  }

  private function check_multimedia($auction_car=''){
    $url            = $this->config->item('api_url');
    $resource       = 'car_sale';
    $query          = '/check_multimedia/'.$auction_car;
    $key            = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
    $api_url        = $url . $resource . $query . $key;

    try{
          $client     = new GuzzleHttp\Client([ 'base_uri' => $url ]);
          $response   = $client->request('GET', $api_url);
          $multimedia = $response->getBody()->getContents();     
          $multimedia = json_decode($multimedia);
          
          if($multimedia->status == "success"){
            return $multimedia->data;
          }else{
            return false;
          }
      }
      catch(Exception $e){
          return false;
      }
  }

  //VIN Decoding by Client Itself (2)
  //VINQuery-API Decoding
  private function vinquery_decoding($vin){
        //$accesscode = "bf31dfde-34f1-4174-bac2-cb8a1fc341a6";
        $accesscode = $this->config->item('vin_query_key');
        $api_url    = "http://ws.vinquery.com/restxml.aspx?accesscode=".$accesscode."&reportType=0&vin=".$vin."" ;
        $client     = new GuzzleHttp\Client([ 'base_uri' => $api_url ]); 
        $response   = $client->request('GET', $api_url);
        $contents   = $response->getBody()->getContents();
        $data       = simplexml_load_string($contents);
        $status     = $data->VIN['Status']->__toString();
        if(strcmp($status, 'SUCCESS')==0){
            $data = array(
                'vin'           => $data->VIN['Number']->__toString(),
                'year'          => $data->VIN->Vehicle->Item[1]['Value']->__toString(),
                'make'          => $data->VIN->Vehicle->Item[2]['Value']->__toString(),
                'model'         => $data->VIN->Vehicle->Item[3]['Value']->__toString(),
                'trim'          => $data->VIN->Vehicle->Item[4]['Value']->__toString(),
                'body_style'    => $data->VIN->Vehicle->Item[7]['Value']->__toString(),
                'transmission'  => $data->VIN->Vehicle->Item[10]['Value']->__toString(),
                'drivetrain'    => $data->VIN->Vehicle->Item[11]['Value']->__toString(),
                'seats'         => $data->VIN->Vehicle->Item[17]['Value']->__toString()
            );
            return $data;
        }else if(strcmp($status, 'FAILED')==0){
            $data = array(
                'vin'           => $vin,
                'error'         => $data->VIN->Message['Value']->__toString()
            );
            return $data;
        }
  }

  //VIN Decoding by Client Itself (1)
  //Prepare VIN for VINQuery-API
  private function get_vin_details($vin){
      try {  
          //===START VINQUERY
          $data_vinquery = $this->vinquery_decoding($vin); 
          if(!empty($data_vinquery['error'])){
            return $data_vinquery; 
            exit;
          }

          //Check transmission
          $transmission           = 'Automatic';
          $vinquery_transmission  = stripos(strtolower($data_vinquery['transmission']), 'manual');
          if($vinquery_transmission !== false){
              $transmission = 'Manual';
          }
          //change SPORT UTILITY body_style from vinquery to default SUV style
          if(stripos($data_vinquery['body_style'], 'SPORT UTILITY') !== false)
            $body_style = 'SUV';
          elseif(stripos($data_vinquery['body_style'], 'PICKUP') !== false)
            $body_style = 'Pick Up';
          else
            $body_style = $data_vinquery['body_style'];
          //===END VINQUERY===

          //===START CARQUERY
          $car_specification = array(
                'model_make_id' => $data_vinquery['make'],
                'model_name'    => $data_vinquery['model'],
                'model_year'    => $data_vinquery['year']
          );
          $data_carquery = $this->car_query_trim_db($car_specification, $data_vinquery['trim'], 'strings');

          $data['vin_details'] = array(
              'vin'            => $vin,
              'make'           => $data_vinquery['make'],
              'model'          => $data_vinquery['model'],
              'year'           => $data_vinquery['year'],
              'trim'           => $data_vinquery['trim'],
              'body_style'     => $body_style,
              'drivetrain'     => $data_vinquery['drivetrain'],
              'transmission'   => $transmission,
              'model_id '      => $data_carquery['key'],
              'model_ids'      => $data_carquery['ids'],
              'model_trims'    => $data_carquery['models'],
              'exterior_color' => '',
              'exterior_hexa'  => '',
              'interior_color' => '',
              'interior_hexa'  => '',
              'cylinders'      => '',
              'fuel_type'      => '',
              'price'          => '',
              'doors'          => '' 
            );
          return $data;
      }
      catch(Exception $e ) {
          $err_msg    = 'Invalid VIN number.';
          echo $err_msg;
          return array();
      }
  }

  //VIN Decoding by API Server
  private function vin_decoding($seller_id,$vin) {
      $url       = $this->config->item('api_url');
      $resource  = 'car_sale';
      $query     = '/get_vin_details?seller_id='.$seller_id.'&vin='. $vin ;
      $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
      $api_url   = $url . $resource . $query . $key;
    
      try{
          $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]);
          $response  = $client->request('GET', $api_url);
          $content   = $response->getBody()->getContents();     
          $content   = json_decode($content);
          
          if($content->status == "success"){
            return $content->data;
          }else{
            return 'error';
          }
      }
      catch(Exception $e){
          //return $e;
          return false;
      }
  }

  private function is_login(){
      if($this->dealer_profile->id && $this->dealer_login){ 
          $login = true; 
      }
      elseif($this->seller_profile->id && $this->seller_login){
          $login = true;
      }
      else{ 
          $login = false; 
      }

      if(!$login){ redirect('login', 'refresh'); die; }
  }

  private function set_sidebar_default(){
      //SET SIDEBAR DEFAULT
      $this->sidebar_auction  = file_get_contents(FCPATH . 'assets/templates/sidebar/seller/default.php');
      $this->sidebar_auction  = str_replace('{dashboard_link}', site_url('seller'), $this->sidebar_auction);
      $this->sidebar_auction  = str_replace('{preference_link}', site_url('seller/preference'), $this->sidebar_auction);
      $this->sidebar_auction  = str_replace('{profile_link}', site_url('seller/profile'), $this->sidebar_auction);
      $this->sidebar_auction  = str_replace('{setting_link}', site_url('seller/setting'), $this->sidebar_auction);
      $this->sidebar_auction  = str_replace('{signout_link}', site_url('logout'), $this->sidebar_auction);
      //$this->sidebar_auction  = str_replace('{more_link}', site_url('seller/more'), $this->sidebar_auction);
      $this->sidebar_auction  = str_replace('{create_auction_link}', site_url('auction/vin'), $this->sidebar_auction);
  }

  private function set_sidebar_default_dealer(){
      $this->sidebar_auction_dealer = file_get_contents(FCPATH . 'assets/templates/sidebar/dealer/default.php');

      $this->sidebar_auction_dealer = str_replace('{dealer_notification_link}', site_url('auction/inbox/dealer'), $this->sidebar_auction_dealer);
      $this->sidebar_auction_dealer = str_replace('{dealer_dashboard_link}', site_url('dealer'), $this->sidebar_auction_dealer);
      $this->sidebar_auction_dealer = str_replace('{dealer_auction_link}', site_url('dealer/auction'), $this->sidebar_auction_dealer);
      $this->sidebar_auction_dealer = str_replace('{dealer_preference_link}', site_url('dealer/preference'), $this->sidebar_auction_dealer);
      $this->sidebar_auction_dealer = str_replace('{dealer_more_link}', site_url('dealer/more'), $this->sidebar_auction_dealer);
      $this->sidebar_auction_dealer = str_replace('{site_url}', site_url(), $this->sidebar_auction_dealer);
  }

  private function set_sidebar_auction_pending($seller_id, $auction_id, $car_sale_id){

      $url       = $this->config->item('api_url');
      $resource  = 'auction';
      $query     = '/list_new?seller_id=' . $seller_id;
      $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
      $api_url   = $url . $resource . $query . $key;

      try{
          $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]);
          $response  = $client->request('GET', $api_url);
          $auctions  = $response->getBody()->getContents();
          $auctions  = json_decode($auctions);
          $auctions  = $auctions->data; //var_dump($auctions); die;
      }
      catch(Exception $e){
          //echo $e;
      }

      $this->sidebar_pending = file_get_contents(FCPATH . 'assets/templates/sidebar/seller/auction-pending.php');
      $this->sidebar_pending = str_replace('{dashboard_link}', site_url('seller'), $this->sidebar_pending);
      $this->sidebar_pending = str_replace('{preference_link}', site_url('seller/preference'), $this->sidebar_pending);
      //$this->sidebar_pending = str_replace('{more_link}', site_url('seller/more'), $this->sidebar_pending);
      $this->sidebar_pending = str_replace('{profile_link}', site_url('seller/profile'), $this->sidebar_pending);
      $this->sidebar_pending = str_replace('{setting_link}', site_url('seller/setting'), $this->sidebar_pending);
      $this->sidebar_pending = str_replace('{signout_link}', site_url('logout'), $this->sidebar_pending);
      $this->sidebar_pending = str_replace('{site_url}', site_url(), $this->sidebar_pending);
      $this->sidebar_pending = str_replace('{create_auction_link}', site_url('auction/vin'), $this->sidebar_pending);
      if(count($auctions) < 2 && ($auctions[0]->auction_id == $auction_id)) {
        $cars_on_auction       = 'style="display: none;"';
        $this->sidebar_pending = str_replace('{cars_on_auction}', $cars_on_auction, $this->sidebar_pending);
      }
      else{
        $cars_on_auction       = '';
        $this->sidebar_pending = str_replace('{cars_on_auction}', $cars_on_auction, $this->sidebar_pending);
      }
      foreach ($auctions as $i => $a) {
        if($a->status == 1.1 && $a->auction_id != $auction_id ){
          if($a->car_details->fuel_type){ $car_fuel = ucwords($a->car_details->fuel_type); } else{ $car_fuel = 'N/A'; }
          if($a->car_details->mileage) { $car_mileage = number_format($a->car_details->mileage).' '.ucwords($a->car_details->mileage_type); }
          else{ $car_mileage = '0 Km'; }
          if($a->car_details->transmission){ $car_transmission = $a->car_details->transmission; } else{ $car_transmission = 'N/A'; }
          if($a->car_details->passenger){ $car_passenger = $a->car_details->passenger; } else{ $car_passenger = 'N/A'; }
          if($a->start_time >= date('Y-m-d H:i:s')){ $cta = 'button green'; }else { $cta = 'button gray'; }
          $this->auction_pending .= 
            '<div class="item">
                <div class="left">
                  <a href="'.site_url().'"><img src="'.$a->car_details->front34.'"></a>
                </div>
                <div class="right">
                  <p>'.$a->item_title .'</p>
                  <ul class="spec">'.
                    //<li class="fuel">'.$car_fuel.'</li>
                    '<li class="odometer">'.$car_mileage.'</li>'.
                    //<li class="transmission">'.$car_transmission.'</li>
                    //<li class="capacity">'.$car_passenger.' people</li>
                  '</ul>
                  <div class="row small-up-2">
                    <div class="column column-block">
                    <a class="button gray" href="'.site_url('auction/'.$a->auction_id.'/edit/'.$a->car_details->car_sale_id).'">
                    Edit</a></div>
                    <div class="column column-block">
                    <a class="'.$cta.'" href="'.site_url('auction/'.$a->auction_id.'/detail/seller/'.$a->car_details->car_sale_id).'">
                    Auction</a></div>'.
                    //<a class="'.$cta.' live-auction" data-auction="'.$a->auction_id.'"><span>Auction</span></a>
                    //<a class="call-to-action delete-auction" data-auction="'.$a->auction_id.'" data-car="'.$a->car_details->car_sale_id.'">
                    //  <span>Delete</span></a>
                  '</div>
                </div>
            </div>';
        }
      }
      $this->sidebar_pending = str_replace('{list_pending_auctions}', $this->auction_pending, $this->sidebar_pending);
  }

  private function set_sidebar_auction_active($seller_id, $auction_id, $car_sale_id){
      $url       = $this->config->item('api_url');
      $resource  = 'auction';
      $query     = '/list_new?seller_id=' . $seller_id . '&notification=true';
      $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
      $api_url   = $url . $resource . $query . $key;

      try{
          $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]);
          $response  = $client->request('GET', $api_url);
          $auctions  = $response->getBody()->getContents();
          $auctions  = json_decode($auctions);
          $auctions  = $auctions->data; //var_dump($auctions); die;
      }
      catch(Exception $e){
          //echo $e;
      }

      $this->sidebar_active = file_get_contents(FCPATH . 'assets/templates/sidebar/seller/auction-active.php');
      $this->sidebar_active = str_replace('{dashboard_link}', site_url('seller'), $this->sidebar_active);
      $this->sidebar_active = str_replace('{preference_link}', site_url('seller/preference'), $this->sidebar_active);
      //$this->sidebar_active = str_replace('{more_link}', site_url('seller/more'), $this->sidebar_active);
      $this->sidebar_active = str_replace('{profile_link}', site_url('seller/profile'), $this->sidebar_active);
      $this->sidebar_active = str_replace('{setting_link}', site_url('seller/setting'), $this->sidebar_active);
      $this->sidebar_active = str_replace('{signout_link}', site_url('logout'), $this->sidebar_active);
      $this->sidebar_active = str_replace('{site_url}', site_url(), $this->sidebar_active);
      $this->sidebar_active = str_replace('{create_auction_link}', site_url('auction/vin'), $this->sidebar_active);
      if(count($auctions) < 2 && ($auctions[0]->auction_id == $auction_id)) {
        $cars_on_auction       = 'style="display: none;"';
        $this->sidebar_active = str_replace('{cars_on_auction}', $cars_on_auction, $this->sidebar_active);
      }
      else{
        $cars_on_auction       = '';
        $this->sidebar_active = str_replace('{cars_on_auction}', $cars_on_auction, $this->sidebar_active);
      }
      foreach ($auctions as $i => $a) {
        if( ($a->status == 1 || $a->start_time >= date('Y-m-d H:i:s')) ) {
          if($a->car_details->fuel_type){ $car_fuel = ucwords($a->car_details->fuel_type); } else{ $car_fuel = 'N/A'; }
          if($a->car_details->mileage) { $car_mileage = number_format($a->car_details->mileage).' '.ucwords($a->car_details->mileage_type); }
          else{ $car_mileage = '0 Km'; }
          if($a->car_details->transmission){ $car_transmission = $a->car_details->transmission; } else{ $car_transmission = 'N/A'; }
          if($a->car_details->passenger){ $car_passenger = $a->car_details->passenger; } else{ $car_passenger = 'N/A'; }
          if($a->status == 1){ $is_active = 'is-active'; $cta = 'call-to-action-green'; }else{ $is_active = ''; $cta = 'call-to-action'; }
          if($a->unread_messages > 0){ $unread_badge = '<span class="badge">'.$a->unread_messages.'</span>'; }else{ $unread_badge = ''; }
          $this->auction_active .= 
            '<div class="item '.$is_active.'">
                <div class="left">
                  <a href="'.site_url().'"><img src="'.$a->car_details->front34.'"></a>
                </div>
                <div class="right">
                  <p>'.$a->item_title .'</p>
                  <ul class="spec">'.
                    //<li class="fuel">'.$car_fuel.'</li>
                    '<li class="odometer">'.$car_mileage.'</li>'.
                    //<li class="transmission">'.$car_transmission.'</li>
                    //<li class="capacity">'.$car_passenger.' people</li>
                  '</ul>
                  <div class="row small-up-2">
                    <a class="'.$cta.'" href="'.site_url('auction/'.$a->auction_id.'/inbox/seller').'"><span>Notification</span>'
                    .$unread_badge.'</a>
                  </div>
                </div>
            </div>';
        }
      }
      // foreach ($auctions as $i => $a) {
      //   if($a->status == 2 && $a->auction_id != $auction_id){
      //     $this->auction_active .= 
      //     '<div class="item is-history">
      //       <p><a href="'.site_url('auction/'.$a->auction_id.'/winner/seller').'">'.$a->item_title.'<a></p>
      //     </div>';
      //   }
      // }

      $this->sidebar_active = str_replace('{list_active_auctions}', $this->auction_active, $this->sidebar_active);
  }

  //UNUSED
  private function set_sidebar_auction_edit($auction_id='', $car_sale_id=''){
      $this->sidebar_auction_edit = file_get_contents(FCPATH . 'assets/templates/sidebar/seller/auction-edit.php');
      $this->sidebar_auction_edit = str_replace('{dashboard_link}', site_url('seller'), $this->sidebar_auction_edit);
      $this->sidebar_auction_edit = str_replace('{preference_link}', site_url('seller/preference'), $this->sidebar_auction_edit);
      $this->sidebar_auction_edit = str_replace('{more_link}', site_url('seller/more'), $this->sidebar_auction_edit);
      $this->sidebar_auction_edit = str_replace('{site_url}', site_url(), $this->sidebar_auction_edit);
      $this->sidebar_auction_edit = str_replace('{edit_detail}', site_url().'auction/edit/'.$auction_id.'/detail/'.$car_sale_id, $this->sidebar_auction_edit);
      $this->sidebar_auction_edit = str_replace('{edit_exterior}', site_url().'auction/edit/'.$auction_id.'/exterior/'.$car_sale_id, $this->sidebar_auction_edit);
      $this->sidebar_auction_edit = str_replace('{edit_interior}', site_url().'auction/edit/'.$auction_id.'/interior/'.$car_sale_id, $this->sidebar_auction_edit);
      $this->sidebar_auction_edit = str_replace('{edit_mechanical}', site_url().'auction/edit/'.$auction_id.'/mechanical/'.$car_sale_id, $this->sidebar_auction_edit);
      $this->sidebar_auction_edit = str_replace('{edit_options}', site_url().'auction/edit/'.$auction_id.'/option/'.$car_sale_id, $this->sidebar_auction_edit);
      $this->sidebar_auction_edit = str_replace('{edit_declarations}', site_url().'auction/edit/'.$auction_id.'/declaration/'.$car_sale_id, $this->sidebar_auction_edit);
      $this->sidebar_auction_edit = str_replace('{edit_conditions}', site_url().'auction/edit/'.$auction_id.'/condition/'.$car_sale_id, $this->sidebar_auction_edit);
  }

  private function set_sidebar_profile(){
      $this->sidebar_profile = str_replace('{dashboard_link}', site_url('seller'), $this->sidebar_profile);
      $this->sidebar_profile = str_replace('{preference_link}', site_url('seller/preference'), $this->sidebar_profile);
      $this->sidebar_profile = str_replace('{more_link}', site_url('seller/profile'), $this->sidebar_profile);
      $this->sidebar_profile = str_replace('{profile_link}', site_url('seller/profile'), $this->sidebar_profile);
      $this->sidebar_profile = str_replace('{setting_link}', site_url('seller/setting'), $this->sidebar_profile);
      $this->sidebar_profile = str_replace('{signout_link}', site_url('logout'), $this->sidebar_profile);
  }

  private function set_sidebar_profile_dealer(){
      $this->sidebar_profile = file_get_contents(FCPATH . 'assets/templates/sidebar/dealer/profile.php');
      $this->sidebar_profile = str_replace('{dealer_notification_link}', site_url('auction/inbox/dealer'), $this->sidebar_profile);
      $this->sidebar_profile = str_replace('{dealer_dashboard_link}', site_url('dealer'), $this->sidebar_profile);
      $this->sidebar_profile = str_replace('{dealer_auction_link}', site_url('dealer/auction'), $this->sidebar_profile);
      $this->sidebar_profile = str_replace('{dealer_preference_link}', site_url('dealer/preference'), $this->sidebar_profile);
      $this->sidebar_profile = str_replace('{dealer_more_link}', site_url('dealer/more'), $this->sidebar_profile);
      $this->sidebar_profile = str_replace('{dealer_profile_link}', site_url('dealer/profile'), $this->sidebar_profile);
      $this->sidebar_profile = str_replace('{dealer_settings_link}', site_url('dealer/settings'), $this->sidebar_profile);
      $this->sidebar_profile = str_replace('{signout_link}', site_url('logout'), $this->sidebar_profile);
  }

  private function set_authorized_auctions($seller_id){
      $list_auctions = $this->session->userdata('authorized_auction');
      $auction_ids   = array();
      foreach ($list_auctions as $a) {
        array_push($auction_ids, $a->auction_id);
      }
      return $auction_ids;
  }

  private function append_authorized_auctions($auction_id){
      array_push($this->authorized_seller_auctions, $auction_id);
  }

  private function set_authorized_cars($seller_id){
      $list_cars = $this->session->userdata('authorized_auction');
      $car_ids       = array();
      foreach ($list_cars as $a) {
        array_push($car_ids, $a->car_details->car_sale_id);
      }
      return $car_ids;
  }

  private function append_authorized_cars($auction_car){
      array_push($this->authorized_seller_cars, $auction_car);
  }

  //CarQuery DB-based Trim
  private function car_query_trim_db($car_specification=array(), $the_trim='', $the_response='array'){
        $trims = $this->car_trim->find_all_trims_by($car_specification);
        if($the_response=='array'){
          $trims_array = array();
          foreach ($trims as $idx => $trim)
          {
              if(!empty($trim->model_trim))
                $trims_array[$trim->model_id] = $trim->model_trim;
          }
          return $trims_array;
        }
        else{
          $trim_ids_array = array(); $trim_models_array = array(); $trim_objects_array = array();
          $trims_key = 0; $trims_percent = 0;
          foreach ($trims as $idx => $trim) {
              if(!empty($trim->model_trim))
              {
                  array_push($trim_ids_array, $trim->model_id);
                  array_push($trim_models_array, $trim->model_trim);
                  $trim_objects_array[$trim->model_id] = $trim->model_trim;

                  similar_text($the_trim, $trim->model_trim, $percent);
                  if($percent > $trims_percent){
                      $trims_percent = $percent;
                      $trims_key = $trim->model_id;
                  }
              }
          }

          $trim_ids_array = implode(",", $trim_ids_array);
          $trim_models_array = implode(",", $trim_models_array);

          return array(
            "key" => $trims_key, "objects" => $trim_objects_array,
            "ids" => $trim_ids_array, "models" => $trim_models_array
          );
        }
  }

  //CarQuery API-based Trim
  //Step [1]
  private function car_query_trim($maker='', $model='',$year='',$trim='',$response='array'){
      $trim_data = $this->get_trims_from_car_query($maker, $model, $year, $trim, $response);
      return $trim_data;
  }

  //CarQuery API-based Trim
  //Step [2]
  private function get_trims_from_car_query($the_maker='', $the_model='',$the_year='',$the_trim='', $the_response='array'){
      //Retrieving Response
      $base_url   = 'https://www.carqueryapi.com/api/0.3/';
      $query      = '?callback=?&cmd=getTrims&make='.$the_maker.'&model='.$the_model.'&year='.$the_year;
      try{
          $ch          = curl_init($base_url . $query);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //for windows
          $car_details = curl_exec($ch);
      }
      catch(Exception $e){
          //echo $e;
      }
      
      //Parsing Response
      $car_details = str_replace('?(', '', $car_details);
      $car_details = str_replace(');', '', $car_details);
      $car_details = json_decode($car_details);
      //$car_details = (array) $car_details;
      //var_dump($json_response->Trims); die;
      if($the_response=='array'){
          $trims_array = array();
          foreach ($car_details->Trims as $idx => $trim) {
              //array_push($trims_array, $trim->model_trim);
              if(!empty($trim->model_trim))
                $trims_array[$trim->model_id] = $trim->model_trim;
          }
          //IF: Multi Dimensional Array
          //$found = array_search('LTZ', array_column($multi_dimension_array, 'field_name_in_2nd_dimension'));
          //$found = array_search($the_trim, $trims_array);
          //return $car_details->Trims[$found];
          return $trims_array;
      }
      else{
          $trim_ids_array = array(); $trim_models_array = array(); $trim_objects_array = array();
          $trims_key = 0; $trims_percent = 0;
          foreach ($car_details->Trims as $idx => $trim) {
              if(!empty($trim->model_trim)){
                  array_push($trim_ids_array, $trim->model_id);
                  array_push($trim_models_array, $trim->model_trim);
                  $trim_objects_array[$trim->model_id] = $trim->model_trim;

                  similar_text($the_trim, $trim->model_trim, $percent);
                  if($percent > $trims_percent){
                      $trims_percent = $percent;
                      $trims_key = $trim->model_id;
                  }
              }
          }

          $trim_ids_array = implode(",", $trim_ids_array);
          $trim_models_array = implode(",", $trim_models_array);

          return array(
            "key" => $trims_key, "objects" => $trim_objects_array,
            "ids" => $trim_ids_array, "models" => $trim_models_array
          );
      }
  }

}

?>