<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dealer extends Front_Controller {

    protected $dealer_profile;
    protected $dealer_login;
	
	public function __construct() {
        parent::__construct();
        $this->load->library('guzzle');
        $this->load->model('auction/car_ref_preferences_model', 'car_ref_preferences');
        $this->dealer_profile = $this->session->userdata('dealer_profile');
        $this->dealer_login   = $this->session->userdata('login');
        $this->is_login();
        $this->template->set('title', '123Quanto | Dealer');
        $this->template->set('user_id', $this->dealer_profile->id);
        $this->template->set('user_name', $this->dealer_profile->company_name);
        $this->template->set('user_email', $this->dealer_profile->email);
        $this->template->set('user_role', "dealer");
        $this->template->set('profile_link', site_url('dealer/profile'));
        $this->template->set('payment_link', site_url('dealer/payment'));
        $this->template->set('setting_link', site_url('dealer/setting'));
        $this->template->set('signout_link', site_url('logout'));
        //SIDEBARS
        $this->sidebar_default = file_get_contents(FCPATH . 'assets/templates/sidebar/dealer/default.php');
        $this->sidebar_profile = file_get_contents(FCPATH . 'assets/templates/sidebar/dealer/profile.php');
        //SIDEBARS' LINKS
        $this->sidebar_default = str_replace('{dealer_notification_link}', site_url('auction/inbox/dealer'), $this->sidebar_default);
        $this->sidebar_default = str_replace('{dealer_dashboard_link}', site_url('dealer'), $this->sidebar_default);
        $this->sidebar_default = str_replace('{dealer_auction_link}', site_url('dealer/auction'), $this->sidebar_default);
        $this->sidebar_default = str_replace('{dealer_preference_link}', site_url('dealer/preference'), $this->sidebar_default);
        $this->sidebar_default = str_replace('{dealer_more_link}', site_url('dealer/more'), $this->sidebar_default);
        $this->sidebar_default = str_replace('{signout_link}', site_url('logout'), $this->sidebar_default);

        $this->sidebar_profile = str_replace('{dealer_notification_link}', site_url('auction/inbox/dealer'), $this->sidebar_profile);
        $this->sidebar_profile = str_replace('{dealer_dashboard_link}', site_url('dealer'), $this->sidebar_profile);
        $this->sidebar_profile = str_replace('{dealer_auction_link}', site_url('dealer/auction'), $this->sidebar_profile);
        $this->sidebar_profile = str_replace('{dealer_preference_link}', site_url('dealer/preference'), $this->sidebar_profile);
        $this->sidebar_profile = str_replace('{dealer_more_link}', site_url('dealer/more'), $this->sidebar_profile);
        $this->sidebar_profile = str_replace('{dealer_profile_link}', site_url('dealer/profile'), $this->sidebar_profile);
        $this->sidebar_profile = str_replace('{dealer_settings_link}', site_url('dealer/settings'), $this->sidebar_profile);
        $this->sidebar_profile = str_replace('{signout_link}', site_url('logout'), $this->sidebar_profile);

        $this->total_page;
    }

    public function index($page=1){
        if($this->dealer_profile->id){
            $url       = $this->config->item('api_url');

            //1st, Getting Auction Time
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

            /* IF SERVER IS CONFIGURED WITH TIMEZONE DIFFERENCE */
            // $client_time     = time();
            // $server_time     = strtotime($auction_time->server_time_auction);
            // $time_difference = abs($server_time - $client_time); 
            // if($time_difference != 0){
            //     $auction_time->last_create_auction = date("Y-m-d H:i:s", strtotime($auction_time->last_create_auction) + $time_difference);
            //     $auction_time->start_live_auction  = date("Y-m-d H:i:s", strtotime($auction_time->start_live_auction) + $time_difference);
            //     $auction_time->end_live_auction    = date("Y-m-d H:i:s", strtotime($auction_time->end_live_auction) + $time_difference);
            //     $this->template->set('time_difference', $time_difference);
            // }
            $limit  = 10;
            $offset = ($page - 1)*$limit;
            //2nd, Getting Active Auctions matching Dealer's Preference 
            $query     = '/list_auction?'. 'dealer_id=' . $this->dealer_profile->id . 
                        '&limit=' . $limit . '&offset=' . $offset . '&';
            $api_url   = $url . $resource . $query . $key; //echo $api_url;die;
            try{
                $client         = new GuzzleHttp\Client([ 'base_uri' => $url ]);
                $response       = $client->request('GET', $api_url);
                $result         = $response->getBody()->getContents();
                $result         = json_decode($result);
                $filters        = $result->data->filters;
                $auctions       = $result->data->auctions; 
                $num_auction    = count($auctions); 
                $num_live_auction    = $result->data->num_of_auctions;  
                $this->total_page   = ceil($num_live_auction/$limit);
                //var_dump($num_live_auction); var_dump($this->total_page);die;
            }
            catch(Exception $e){ 
                //echo $e; 
            }

            //Check if NULL auction
            $empty_auction     = 0;
            if($num_live_auction == 0){
                $empty_auction = 1;
            }

            //or Set Next Live Auction Time
            $now = date('Y-m-d H:i:s');
            if($now > $auction_time->start_live_auction && $now < $auction_time->end_live_auction){

                try{
                    $response  = $client->request('GET', $api_url);
                    $auctions  = $response->getBody()->getContents();
                    $auctions  = json_decode($auctions);
                    $auctions  = $auctions->data->auctions;
                    
                    $live = 1;
                }
                catch(Exception $e){
                    //echo $e;
                }
                
            }else{
                $live = 0;
            }

            //2nd, Get Watchlist Auction
            $query     = '/watchlist?'. 'dealer_id=' . $this->dealer_profile->id . 
                        '&limit=10&offset=0&';
            $api_url   = $url . $resource . $query . $key; //echo $api_url;die;
            try{
                $client         = new GuzzleHttp\Client([ 'base_uri' => $url ]);
                $response       = $client->request('GET', $api_url);
                $result         = $response->getBody()->getContents();
                $result         = json_decode($result);
                $filters        = $result->data->filters;
                $watchlist      = $result->data->watchlist; //var_dump($watchlist);die;
                $num_watchlist  = $result->data->num_of_watchlist; 
            }
            catch(Exception $e){ 
                //echo $e; 
            }

            //3rd, Getting Won Auction
            $query     = '/auction_won?'. 'dealer_id=' . $this->dealer_profile->id . '&limit=5&offset=0&';
            $api_url   = $url . $resource . $query . $key; 
            try{
                $client         = new GuzzleHttp\Client([ 'base_uri' => $url ]);
                $response       = $client->request('GET', $api_url);
                $won_auctions   = $response->getBody()->getContents();
                $won_auctions   = json_decode($won_auctions);
                $won_auctions   = $won_auctions->data->won_auctions;
                $num_auction_won = count($won_auctions);
                // var_dump($won_auctions);die;
            }
            catch(Exception $e){ 
                //echo $e; 
            }

            //4th, Getting Dealer Preference
            $query     = '/get_purchased?'. 'dealer_id=' . $this->dealer_profile->id .'&';
            $api_url   = $url . $resource . $query . $key; 
            try{
                $client         = new GuzzleHttp\Client([ 'base_uri' => $url ]);
                $response       = $client->request('GET', $api_url);
                $preference   = $response->getBody()->getContents();
                $preference   = json_decode($preference);
                $preference   = $preference->data; 
                $body_styles  = $preference->body_styles;
                $brands       = $preference->brands;
            }
            catch(Exception $e){ 
                //echo $e; 
            }
        }
        
        //Extra Vars
        $auction_finished = time() - strtotime($auction_time->end_live_auction);
        if($auction_finished > 0){ $auction_day = '1'; }
        else{ $auction_day = '0'; }
        $key='key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $post_dealer_addbid         = $url .'bid/create?'.$key;
        $post_dealer_addproxybid    = $url .'bid/proxy/set?'.$key;
        $post_dealer_removeproxybid = $url .'bid/proxy/remove?'.$key;
        $get_dealer_auction_stream  = $url .'bid/all_auctions_highest/' .$this->dealer_profile->id .'?' .$key;

        $post_dealer_addwatchlist = $url .'dealers/add_watchlist?'.$key;
        $post_dealer_remwatchlist = $url .'dealers/remove_watchlist?'.$key;
        $post_dealer_preference = $url .'dealers/purchase?'.$key;
        $this->template->set('post_dealer_preference', $post_dealer_preference);
        $this->template->set('post_dealer_addwatchlist', $post_dealer_addwatchlist);
        $this->template->set('post_dealer_remwatchlist', $post_dealer_remwatchlist);
        $this->template->set('body_class', 'dealer-index');
        $this->template->set('type', 'normal');
        $this->template->set('sidebar', $this->sidebar_profile);
        $this->template->set('dealer_id', $this->dealer_profile->id);
        $this->template->set('post_dealer_addbid', $post_dealer_addbid);
        $this->template->set('post_dealer_addproxybid', $post_dealer_addproxybid);
        $this->template->set('post_dealer_removeproxybid', $post_dealer_removeproxybid);
        $this->template->set('get_dealer_auction_stream', $get_dealer_auction_stream);
        $this->template->set('auction_day', $auction_day);
        $this->template->set('auction_time', $auction_time);
        $this->template->set('live', $live);
        $this->template->set('empty_auction', $empty_auction);
        $this->template->set('key', $key);
        $this->template->set('body_styles', $body_styles); 
        $this->template->set('brands', $brands); 
        $this->template->set('auctions', $auctions); 
        $this->template->set('watchlist', $watchlist); 
        $this->template->set('num_watchlist', $num_watchlist); 
        $this->template->set('won_auctions', $won_auctions); 
        $this->template->set('num_auction', $num_live_auction); 
        $this->template->set('num_auction_won', $num_auction_won); 
        $this->template->set('num_pages', $this->total_page);
        $this->template->set('cur_page', $page);
        $this->template->build('index'); 
        
    }

    public function auction($page=1){
        if($this->dealer_profile->id){
            $url       = $this->config->item('api_url');
            //1st, Getting Active Auctions matching Dealer's Preference 
            $resource  = 'dealers';
            $key       = 'key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';

            $limit  = 10;
            $offset = ($page - 1)*$limit;
            //2nd, Getting Active Auctions matching Dealer's Preference 
            $query     = '/list_auction?'. 'dealer_id=' . $this->dealer_profile->id . 
                        '&limit=' . $limit . '&offset=' . $offset . '&';

            $api_url   = $url . $resource . $query . $key; //echo $api_url;die;
            try{
                $client         = new GuzzleHttp\Client([ 'base_uri' => $url ]);
                $response       = $client->request('GET', $api_url);
                $result         = $response->getBody()->getContents();
                $result         = json_decode($result);
                $filters        = $result->data->filters;
                $auctions       = $result->data->auctions; 
                $num_auction    = count($auctions); 
                $num_live_auction    = $result->data->num_of_auctions;  
                $this->total_page   = ceil($num_live_auction/$limit);
                // var_dump($num_live_auction); var_dump($this->total_page);die;
            }
            catch(Exception $e){ 
                //echo $e; 
            }
            // =========================================

            //Check if NULL auction
            $empty_auction     = 0;
            if($num_live_auction == 0){
                $empty_auction = 1;
            }

            //3rd, Get Watchlist Auction
            $offset = 0;
            $query     = '/watchlist?'. 'dealer_id=' . $this->dealer_profile->id . 
                        '&limit=' . $limit . '&offset=' . $offset . '&';
            $api_url   = $url . $resource . $query . $key; //echo $api_url;die;
            try{
                $client         = new GuzzleHttp\Client([ 'base_uri' => $url ]);
                $response       = $client->request('GET', $api_url);
                $result         = $response->getBody()->getContents();
                $result         = json_decode($result);
                $filters        = $result->data->filters;
                $watchlist      = $result->data->watchlist; 
                $num_watchlist  = $result->data->num_of_watchlist; 
            }
            catch(Exception $e){ 
                //echo $e; 
            }


             //4th, Getting Won Auction
            $query     = '/auction_won?'. 'dealer_id=' . $this->dealer_profile->id . '&limit=5&offset=0&';
            $api_url   = $url . $resource . $query . $key;
            try{
                $client         = new GuzzleHttp\Client([ 'base_uri' => $url ]);
                $response       = $client->request('GET', $api_url);
                $won_auctions   = $response->getBody()->getContents();
                $won_auctions   = json_decode($won_auctions);
                $won_auctions   = $won_auctions->data->won_auctions;
                $num_auction_won = count($won_auctions);
                // var_dump($won_auctions);die;
            }
            catch(Exception $e){ 
                //echo $e; 
            }

            //get auction times
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

            //Extra Vars
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
        
            if(strtotime(date('Y-m-d H:i:s')) < strtotime($times->start_live_auction) ||
                strtotime(date('Y-m-d H:i:s')) > strtotime($times->end_live_auction)
            ){
                $list_title   = 'Today Upcoming Auction';
                $list_color   = '#a8a8a8';
                $live         = 0;
            }else{
                $list_title   = 'Live Auction';
                $list_color   = '#4a6d82';
                $live         = 1;
            }

            //5th, Getting Dealer Preference
            $query     = '/get_purchased?'. 'dealer_id=' . $this->dealer_profile->id;
            $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
            $api_url   = $url . $resource . $query . $key; 
            try{
                $client       = new GuzzleHttp\Client([ 'base_uri' => $url ]);
                $response     = $client->request('GET', $api_url);
                $preference   = $response->getBody()->getContents();
                $preference   = json_decode($preference);
                $preference   = $preference->data; 
                $body_styles  = $preference->body_styles;
                $brands       = $preference->brands;
            }
            catch(Exception $e){ 
                //echo $e; 
            }
        }

        $key='key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $post_dealer_addbid = $url .'bid/create?'.$key;
        $post_dealer_addproxybid    = $url .'bid/proxy/set?'.$key;
        $post_dealer_removeproxybid = $url .'bid/proxy/remove?'.$key;
        $post_dealer_addwatchlist = $url .'dealers/add_watchlist?'.$key;
        $post_dealer_remwatchlist = $url .'dealers/remove_watchlist?'.$key;
        $post_dealer_preference = $url .'dealers/purchase?'.$key;
        //Server Stream Event / SSE
        $get_dealer_auction_stream  = $url .'bid/all_auctions_highest/' .$this->dealer_profile->id .'?' .$key;
        $this->template->set('post_dealer_addbid', $post_dealer_addbid);
        $this->template->set('post_dealer_addproxybid', $post_dealer_addproxybid);
        $this->template->set('post_dealer_removeproxybid', $post_dealer_removeproxybid);
        $this->template->set('post_dealer_addwatchlist', $post_dealer_addwatchlist);
        $this->template->set('post_dealer_remwatchlist', $post_dealer_remwatchlist);
        $this->template->set('get_dealer_auction_stream', $get_dealer_auction_stream);
        $this->template->set('post_dealer_preference', $post_dealer_preference);
        $this->template->set('body_styles', $body_styles); 
        $this->template->set('brands', $brands); 
        $this->template->set('dealer_id', $this->dealer_profile->id);
        $this->template->set('auctions', $auctions);
        $this->template->set('watchlist', $watchlist); 
        $this->template->set('empty_auction', $empty_auction);
        $this->template->set('num_watchlist', $num_watchlist); 
        $this->template->set('num_auction', $num_live_auction); 
        $this->template->set('won_auctions', $won_auctions); 
        $this->template->set('num_auction_won', $num_auction_won); 
        $this->template->set('list_title', $list_title);
        $this->template->set('list_color', $list_color);
        $this->template->set('live', $live);
        $this->template->set('auction_day', $auction_day);
        $this->template->set('auction_time', $times);
        $this->template->set('num_pages', $this->total_page);
        $this->template->set('cur_page', $page);
        $this->template->set('sidebar', $this->sidebar_profile);
        $this->template->set('title', 'Auction');
        $this->template->set('body_class', 'dealer-index');
        $this->template->set('type', 'normal');
        $this->template->build('auction_watchlist'); 
    }

    public function profile($mode='view'){
        $url       = $this->config->item('api_url');
        $resource  = 'users';
        $query     = '/profile?user_id=' . $this->dealer_profile->id . '&role=dealer';
        $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $api_url   = $url . $resource . $query . $key; 

        try{
            $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]);
            $response  = $client->request('GET', $api_url);
            $profile   = $response->getBody()->getContents();
            $profile   = json_decode($profile);
            $profile   = $profile->data; 
            $this->template->set('dealer_id', $this->dealer_profile->id);
            $this->template->set('email', $this->dealer_profile->email);
            $this->template->set('dealer_profile', $profile);
        }
        catch(Exception $e){ 
            //echo $e; 
        }
        $this->template->set('body_class', 'dealer-profile');
        $this->template->set('type', 'normal');
        $this->template->set('sidebar', $this->sidebar_profile);

        if($mode == 'view'){
            $this->template->build('profile');
        }elseif($mode == 'edit'){
            $resource           = 'dealers';
            $query              = '/update_profile';
            $key                = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
            $edit_profile_url   = $url . $resource . $query . $key; 
            $this->template->set('edit_profile_url', $edit_profile_url);
            $this->template->build('profile_edit');
        }
    }

    public function preference(){ 
        $url       = $this->config->item('api_url');
        $client    = new GuzzleHttp\Client([ 'base_uri' => $url ]);

        //GET dealer preference for body style & brands
        $resource  = 'dealers';
        $query     = '/get_purchased?dealer_id=' . $this->dealer_profile->id;
        $key       = '&key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $api_url   = $url . $resource . $query . $key;

        try{
            $response          = $client->request('GET', $api_url);
            $dealer_preference = $response->getBody()->getContents();
            $dealer_preference = json_decode($dealer_preference);
            $dealer_preference = $dealer_preference->data;
        }
        catch(Exception $e){
            //echo $e;
        }

        //GET user brands
        $resource  = 'users';
        $query     = '/get_user_brands?user_id=' . $this->dealer_profile->id . '&user_role=dealer';
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
            $found = array_search($style->name, $dealer_preference->body_styles);
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
            $found = array_search($brand->name, $dealer_preference->brands);
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

        //To accomodate Dealers' Preferences which are not listed in our DB
        foreach ($dealer_preference->brands  as $key => $brand_name) {
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
        // var_dump($preference->brands);  die;
        //var_dump($dealer_preference->brands); die;
        //var_dump($brands_preference); var_dump($brands_collection); die;
        $key='key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $post_dealer_preference = $url .'dealers/purchase?'.$key;
        $post_single_brand      = $url .'users/user_add_brand?'.$key;
        $this->template->set('body_class', 'dealer-filters');
        $this->template->set('type', 'normal');
        $this->template->set('sidebar', $this->sidebar_profile);
        $this->template->set('dealer_id', $this->dealer_profile->id);
        $this->template->set('post_dealer_preference', $post_dealer_preference);
        $this->template->set('post_single_brand', $post_single_brand);
        $this->template->set('body_styles', $preference->body_styles);
        $this->template->set('brands', $preference->brands);
        $this->template->set('brands_collection', $brands_collection);
        $this->template->set('styles_preference', $styles_preference);
        $this->template->set('brands_preference', $brands_preference);
        $this->template->build('preference');
    }

    private function is_login(){
        if($this->dealer_profile->id && $this->dealer_login){ 
            $login = true; 
        }
        else{ 
            $login = false; 
        }

        if(!$login){ redirect('login', 'refresh'); die; }
    }
    
}

?>