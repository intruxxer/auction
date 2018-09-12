<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Seller extends Front_Controller {

    protected $seller_profile;
    protected $seller_login;
    
    public function __construct() {
        parent::__construct();
        $this->load->library('guzzle');
        $this->load->model('auction/car_ref_preferences_model', 'car_ref_preferences');
        $this->seller_profile = $this->session->userdata('seller_profile');
        $this->seller_login   = $this->session->userdata('login');
        $this->is_login();
        $this->template->set('title', '123Quanto | Seller');
        $this->template->set('user_id', $this->seller_profile->id);
        $this->template->set('user_name', $this->seller_profile->first_name . ' ' . $this->seller_profile->last_name);
        $this->template->set('user_email', $this->seller_profile->email);
        $this->template->set('user_role', 'seller');
        $this->template->set('profile_link', site_url('seller/profile'));
        $this->template->set('payment_link', site_url('seller/payment'));
        $this->template->set('setting_link', site_url('seller/setting'));
        $this->template->set('signout_link', site_url('logout'));
        //SIDEBARS
        $this->sidebar_default = file_get_contents(FCPATH . 'assets/templates/sidebar/seller/default.php');
        $this->sidebar_profile = file_get_contents(FCPATH . 'assets/templates/sidebar/seller/profile.php');
        //SIDEBARS' LINKS
        $this->sidebar_default = str_replace('{dashboard_link}', site_url('seller'), $this->sidebar_default);
        $this->sidebar_default = str_replace('{preference_link}', site_url('seller/preference'), $this->sidebar_default);
        //$this->sidebar_default = str_replace('{more_link}', site_url('seller/profile'), $this->sidebar_default);
        $this->sidebar_default = str_replace('{profile_link}', site_url('seller/profile'), $this->sidebar_default);
        $this->sidebar_default = str_replace('{payment_link}', site_url('seller/payment'), $this->sidebar_default);
        $this->sidebar_default = str_replace('{setting_link}', site_url('seller/setting'), $this->sidebar_default);
        $this->sidebar_default = str_replace('{create_auction_link}', site_url('auction/vin'), $this->sidebar_default);
        $this->sidebar_default = str_replace('{signout_link}', site_url('logout'), $this->sidebar_default);

        $this->sidebar_profile = str_replace('{dashboard_link}', site_url('seller'), $this->sidebar_profile);
        $this->sidebar_profile = str_replace('{preference_link}', site_url('seller/preference'), $this->sidebar_profile);
        $this->sidebar_profile = str_replace('{more_link}', site_url('seller/profile'), $this->sidebar_profile);
        $this->sidebar_profile = str_replace('{profile_link}', site_url('seller/profile'), $this->sidebar_profile);
        $this->sidebar_profile = str_replace('{payment_link}', site_url('seller/payment'), $this->sidebar_profile);
        $this->sidebar_profile = str_replace('{setting_link}', site_url('seller/setting'), $this->sidebar_profile);
        $this->sidebar_profile = str_replace('{signout_link}', site_url('logout'), $this->sidebar_profile);
    }

    public function index(){
        
        if($this->seller_profile->id){
            $url       = $this->config->item('api_url');
            $resource  = 'auction';
            $query     = '/list_new?seller_id=' . $this->seller_profile->id;
            $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
            $api_url   = $url . $resource . $query . $key; //echo $api_url;die;

            try{
                $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]);
                $response  = $client->request('GET', $api_url);
                $auctions  = $response->getBody()->getContents();
                $auctions  = json_decode($auctions); 
                $auctions  = $auctions->data; //var_dump($auctions); die;
                $count     = count($auctions);

                $this->session->set_userdata('authorized_auction', $auctions);
                 //Detect if Need Redirection e.g. From API after creating auction
                $next = $this->input->get('next');
                if(!empty($next)){ 
                    redirect(site_url($next . '?filters=true'), 'refresh'); die; 
                } 
            }
            catch(Exception $e){
                //echo "API Auction/List_New Error: " .$e;
            }
            
            $post_unset_auction = $url . $resource . '/unset_auction' . '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';

            //Getting Auction Time
            $resource  = 'dealers';
            $query     = '/get_auction_times?';
            $key       = 'key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
            $api_url   = $url . $resource . $query . $key;

            try{
                $client       = new GuzzleHttp\Client([ 'base_uri' => $url ]);
                $response     = $client->request('GET', $api_url);
                $auction_time = $response->getBody()->getContents();
                $auction_time = json_decode($auction_time);
                $auction_time = $auction_time->data; //var_dump($auction_time); die;
            }
            catch(Exception $e){ 
                //echo $e; 
            }

            $auction_finished = time() - strtotime($auction_time->end_live_auction);
            if($auction_finished > 0){ $auction_day = '1'; }
            else{ $auction_day = '0'; }

            if(strtotime(date('Y-m-d H:i:s')) < strtotime($auction_time->start_live_auction) ||
                strtotime(date('Y-m-d H:i:s')) > strtotime($auction_time->end_live_auction)
            ){
                $live         = false;
            }else{
                $live         = true;
            }

            if($count == 1){
                $resource  = 'car_sale';
                $query     = '/get_review?car_sale_id='.$auctions[0]->car_details->car_sale_id;
                $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
                $api_url   = $url . $resource . $query . $key;

                try{
                    $response  = $client->request('GET', $api_url);
                    $detail    = $response->getBody()->getContents();
                    $detail    = json_decode($detail);
                    $detail    = $detail->data; 
                    $detail->auction->start_time = $auctions[0]->start_time;
                    $detail->auction->unread_messages = $auctions[0]->unread_messages; 
                    $detail->auction->car_sale_id = $auctions[0]->car_details->car_sale_id; //var_dump($detail); die;
                }
                catch(Exception $e){
                    //echo $e;
                }

                $this->template->set('body_class', 'seller-index');
                $this->template->set('type', 'normal');
                $this->template->set('sidebar',$this->sidebar_default);
                $this->template->set('data', $detail); //var_dump($detail->auction->start_time);die;
                $this->template->set('post_unset_auction', $post_unset_auction);
                $this->template->set('auction_day', $auction_day);
                $this->template->set('auction_time', $auction_time);
                $this->template->set('live', $live);
                $this->template->build('single_auction');
            }else if($count > 1){
                $this->template->set('body_class', 'seller-index');
                $this->template->set('type', 'normal');
                $this->template->set('sidebar',$this->sidebar_default);
                $this->template->set('data', $auctions);
                $this->template->set('post_unset_auction', $post_unset_auction);
                $this->template->set('auction_day', $auction_day);
                $this->template->set('auction_time', $auction_time);
                $this->template->set('live', $live);
                $this->template->build('multi_auction'); 
            }else{
                $this->template->set('body_class', 'seller-index');
                $this->template->set('type', 'normal');
                $this->template->set('sidebar',$this->sidebar_default);
                // $this->template->set('auction_day', $auction_day);
                // $this->template->set('auction_time', $auction_time);
                $this->template->build('empty_auction');
            }
        }
    }
    
    public function setting(){ redirect('seller/profile', 'refresh'); }

    public function profile($mode='view'){
        
        $url       = $this->config->item('api_url');
        $resource  = 'users';
        $query     = '/profile?user_id=' . $this->seller_profile->id . '&role=seller';
        $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $api_url   = $url . $resource . $query . $key; 

        try{
            $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]);
            $response  = $client->request('GET', $api_url);
            $profile   = $response->getBody()->getContents();
            $profile   = json_decode($profile);
            $profile   = $profile->data; //var_dump($profile);die;
            $this->template->set('seller_id', $this->seller_profile->id);
            $this->template->set('seller_profile', $profile);
        }
        catch(Exception $e){
            //echo $e;
        }

        $this->template->set('body_class', 'seller-profile');
        $this->template->set('type', 'normal');
        $this->template->set('sidebar', $this->sidebar_profile);

        if($mode == 'view'){
            $this->template->build('profile');
        }elseif($mode == 'edit'){
            $resource           = 'sellers';
            $query              = '/update_profile';
            $key                = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
            $edit_profile_url   = $url . $resource . $query . $key; 
            $this->template->set('edit_profile_url', $edit_profile_url);
            $this->template->build('profile_edit');
        }

    }

    public function preference($from='', $auction_id=''){
        if($from=='set_for_auction'){
            $this->template->set('new_auction', 'true');
            $this->template->set('auction_id', $auction_id);
        }

        $url       = $this->config->item('api_url');
        $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]);

        //GET seller preference for body style & brands
        $resource  = 'sellers';
        $query     = '/get_purchased?seller_id=' . $this->seller_profile->id;
        $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $api_url   = $url . $resource . $query . $key;

        try{
            $response          = $client->request('GET', $api_url);
            $seller_preference = $response->getBody()->getContents();
            $seller_preference = json_decode($seller_preference);
            $seller_preference = $seller_preference->data; //var_dump($seller_preference); die;
        }
        catch(Exception $e){
            //echo $e;
        }

        //GET user brands
        $resource  = 'users';
        $query     = '/get_user_brands?user_id=' . $this->seller_profile->id . '&user_role=seller';
        $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $api_url   = $url . $resource . $query . $key;

        try{
            $response    = $client->request('GET', $api_url);
            $user_brands = $response->getBody()->getContents();
            $user_brands = json_decode($user_brands);
            $user_brands = $user_brands->data->brands; //var_dump($user_brands); die;
        }
        catch(Exception $e){
            //echo $e;
        }

        $preference['body_styles'] = $this->car_ref_preferences->all_styles();
        $preference['brands']      = $this->car_ref_preferences->all_brands();

        if($user_brands){
            foreach ($user_brands as $u) {
                $new_brand  = array(
                    'name'   => trim($u),
                    'type'   => '',
                    'active' => '',
                    'orange' => '',
                    'green'  => ''
                    );
                $new_brand = (object) $new_brand; 
                array_push($preference['brands'], $new_brand);
            }
        }

        $preference                = (object) $preference;

        //SET "is-active" tag per body styles
        $styles_preference = array();
        foreach ($preference->body_styles as $key => $style) {
            $style->name = trim($style->name);
            $found = array_search($style->name, $seller_preference->body_styles);
            //Key can be nonnegative integers {0,1,2,....,n} thus
            if($found > -1){
                $style->active = 'is-active';
                array_push($styles_preference, "'".$style->name."'");
            }
            else{
                $style->active = '';
            }
        }

        //SET "is-active tag" per brands, collection (auto-complete), & preference (submission data).
        $brands_collection = array(); $brands_preference = array();
        foreach ($preference->brands as $key => $brand) {
            //SET brands_collection STRING (AutoComplete)
            array_push($brands_collection, "'".$brand->name."'");
            //SET "is-active tag" and
            //SET brands_preference STRING (Preference Data)
            $found = array_search($brand->name, $seller_preference->brands);
            if($found > -1){
                $brand->active = 'is-active';
                $brand->orange = 'orange';
                $brand->green  = 'green';
                array_push($brands_preference, "'".$brand->name."'");
            }
            else{
                $brand->active = '';
                $brand->orange = '';
                $brand->green  = '';
            }
        }
        
        //To accomodate Seller's Preferences which are not listed in our DB
        foreach ($seller_preference->brands  as $key => $brand_name) {
            $found = array_search("'".$brand_name."'", $brands_collection);
            if(false === $found){
                $unlisted_brand->name   = $brand_name;
                $unlisted_brand->active = 'is-active';
                $unlisted_brand->orange = 'orange';
                $unlisted_brand->green  = 'green';
                array_push($preference->brands, $unlisted_brand); 
                unset($unlisted_brand);
                array_push($brands_preference, "'".trim($brand_name)."'");
            }
        }
        
        $brands_collection = implode(",", $brands_collection);
        $brands_preference = implode(",", $brands_preference);
        $styles_preference = implode(",", $styles_preference);
        // var_dump($preference->brands); 
        //var_dump($seller_preference->brands); die;
        // var_dump($brands_preference); die;
        // var_dump($brands_collection); die;
        $key='key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $post_seller_preference = $url .'sellers/purchase?'.$key;
        $post_single_brand      = $url .'users/user_add_brand?'.$key;
        $this->template->set('body_class', 'seller-purchase');
        $this->template->set('type', 'normal');
        $this->template->set('sidebar', $this->sidebar_default);
        $this->template->set('seller_id', $this->seller_profile->id);
        $this->template->set('post_seller_preference', $post_seller_preference);
        $this->template->set('post_single_brand', $post_single_brand);
        $this->template->set('body_styles', $preference->body_styles);
        $this->template->set('brands', $preference->brands);
        $this->template->set('brands_collection', $brands_collection);
        $this->template->set('styles_preference', $styles_preference);
        $this->template->set('brands_preference', $brands_preference);
        $this->template->build('preference');
    }

    private function is_login(){
        if($this->seller_profile->id && $this->seller_login){ 
            $login = true; 
        }
        else{ 
            $login = false; 
        }

        if(!$login){ redirect('login', 'refresh'); die; }
    }
    
}

?>