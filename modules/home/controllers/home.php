<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home extends Front_Controller {

	  public function __construct() {
        parent::__construct();
        $this->load->library('guzzle');
        $this->template->set('title', '123Quanto');
    }

    public function index()
    {
      $this->template->set_theme('landing');
      $this->template->set_layout('index');
      $this->template->build('index');
    }

    public function v1()
    {
      $this->template->set_theme('landing');
      $this->template->set_layout('index');
      $this->template->build('v1');
    }

    public function v2()
    {
      $this->template->set_theme('landing');
      $this->template->set_layout('index');
      $this->template->build('v2');
    }

    public function v3()
    {
      $this->template->set_theme('landing');
      $this->template->set_layout('index');
      $this->template->build('v3');
    }

    public function signin(){
        if($this->session->userdata('seller_profile')) { redirect('seller', 'refresh'); exit; }
        elseif($this->session->userdata('dealer_profile')) { redirect('dealer', 'refresh'); exit; }
        else{
          $fb     = $this->facebook->Facebook();
          $google = new Google();
          if(!$this->facebook->is_authenticated()){
              $fb_login_url     = $this->facebook->login_url();
              $google_login_url = $google->login_url();
              $this->template->set('fb_login_url', $fb_login_url);
              $this->template->set('google_login_url', $google_login_url);
          }
          else{
              $fb_login_url     = $this->facebook->login_url();
              $google_login_url = $google->login_url();
              $this->template->set('fb_login_url', $fb_login_url);
              $this->template->set('google_login_url', $google_login_url);
          }

          $this->template->set('body_class', 'home');
          $this->template->set('type', 'registration');
      	  $this->template->build('index');
        }
    }

    public function terms(){
        $this->template->set('type', 'registration');
        $this->template->build('terms');
    }

    public function activated_account(){
        $this->template->set('body_class', 'notification');
        $this->template->set('type', 'registration');
        $this->template->build('activated_account');
    }

    public function login()
    {
      	if ($this->input->post()) {
      		  $email           = $this->input->post('email');
  	        $password        = $this->input->post('password');

  	        $url             = $this->config->item('api_url');
  	        $resource        = 'users';
  	        $query           = '/login?';
  	        $key             = 'key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
  	        $api_url         = $url . $resource . $query . $key;

  	        try{
  	          $client          = new GuzzleHttp\Client([ 'base_uri' => $url ]);
  	          $response        = $client->request('POST', $api_url,
  	                                [
  	                                  'form_params' =>
  	                                    [
  	                                        'email'     => $email,
  	                                        'password'  => $password
  	                                    ]
  	                                ]
  	                            );

              $content          = $response->getBody()->getContents();
  	          $result           = json_decode($content);
              $result           = $result->data;

              if($result->type == "Seller"){
                $this->session->set_userdata('login', true);
                $this->session->set_userdata('seller_profile', $result);
                redirect('seller', 'refresh');
              }elseif($result->type == "Dealer"){
                $this->session->set_userdata('login', true);
                $this->session->set_userdata('dealer_profile', $result);
                redirect('dealer', 'refresh');
              }else{
                redirect('login?error=wrong_credentials', 'refresh');
              }

  	        }
  	        catch(Exception $e){
  	          //echo $e;
              redirect('login', 'refresh');
  	        }
      	}
      	else{
          $error = $this->input->get('error');
          if($error=='wrong_credentials')
            $this->template->set('error_login', 'Your email or password does not match what we have in our system. Please try again.');
          $this->template->set('body_class', 'login');
          $this->template->set('type', 'registration');
      		$this->template->build('login');
      	}
    }

    public function google_connect(){
        $google_code  = $this->input->get('code');
        $google_error = $this->input->get('error');
        if($google_code){
            $google = new Google($google_code);
            //EQUAL WITH: $google->access_token; $this->session->userdata('google_access_token');
            $google_token    = $google->get_oauth_access_token();
            $google_profile  = $google->get_google_user($google_token);
            $google_user     = array(
                    'google_id' => $google_profile['google_id'],
                    'fullname'  => $google_profile['firstname'].' '.$google_profile['lastname'],
                    'birthday'  => $google_profile['birthday'],
                    'email'     => $google_profile['email'],
                    'gender'    => $google_profile['gender']
            );
            $this->session->set_userdata('google_user', $google_user);

            //(1) Attempt Login using Google ID by HTTP Client
            $url       = $this->config->item('api_url');
            $resource  = 'users';
            $query     = '/social_login/google';
            $key       = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
            $api_url   = $url . $resource . $query . $key;

            $client    = new GuzzleHttp\Client([ 'base_uri' => $this->url ]);
            $response  = $client->request('POST', $api_url,
                         [
                            'form_params' =>
                            [
                                'social_id'    => $google_user['google_id'],
                                'social_email' => $google_user['email']
                            ]
                         ]
            );

            $user  = $response->getBody()->getContents();
            $user  = json_decode($user);
            $user  = $user->data;
            //(2.1) If Found, Login to Member Dashboard.
            if(!empty($user)){
              if($user->type == "Seller"){
                  $this->session->set_userdata('login', true);
                  $this->session->set_userdata('seller_profile', $user);
                  redirect('seller', 'refresh');
              }elseif($user->type == "Dealer"){
                  $this->session->set_userdata('login', true);
                  $this->session->set_userdata('dealer_profile', $user);
                  redirect('dealer', 'refresh');
              }
            }
            //(2.2) If Not Found, Load Registration Form with Google User Data
            else{
              $this->session->set_userdata('social_register_gid', $google_user['google_id']);
              $this->session->set_userdata('social_register_email', $google_user['email']);
              $this->session->set_userdata('social_register_name', $google_user['fullname']);
              redirect('register', 'refresh');
            }
        }
        else
        {
            if($google_error=='access_denied'){
              redirect(site_url().'?error=google_auth', 'refresh');
            }
        }
    }

    public function facebook_connect(){
        $code  = $this->input->get('code');
        $state = $this->input->get('state');

        if(!empty($code))
        {
            $fb = $this->facebook->Facebook($code, $state);
            $fb_access_token = $this->facebook->is_authenticated();
            if($fb_access_token)
            {
                $fb_user_data = $this->facebook->Request('get', '/me?fields=id,name,birthday,email,gender', [], $fb_access_token);
                $facebook_user = array(
                    'facebook_id' => $fb_user_data['id'],
                    'fullname'    => $fb_user_data['name'],
                    'birthday'    => $fb_user_data['birthday'],
                    'email'       => $fb_user_data['email'],
                    'gender'      => $fb_user_data['gender']
                );
                $this->session->set_userdata('facebook_user', $facebook_user);

                //(1) Attempt Login using FB ID by HTTP Client
                $url       = $this->config->item('api_url');
                $resource  = 'users';
                $query     = '/social_login/facebook';
                $key       = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
                $api_url   = $url . $resource . $query . $key;

                $client    = new GuzzleHttp\Client([ 'base_uri' => $this->url ]);
                $response  = $client->request('POST', $api_url,
                             [
                                'form_params' =>
                                [
                                    'social_id'    => $facebook_user['facebook_id'],
                                    'social_email' => $facebook_user['email']
                                ]
                             ]
                );

                $user  = $response->getBody()->getContents();
                $user  = json_decode($user);
                $user  = $user->data;
                //(2.1) If Found, Login to Member Dashboard.
                if(!empty($user)){
                  if($user->type == "Seller"){
                      $this->session->set_userdata('login', true);
                      $this->session->set_userdata('seller_profile', $user);
                      redirect('seller', 'refresh');
                  }elseif($user->type == "Dealer"){
                      $this->session->set_userdata('login', true);
                      $this->session->set_userdata('dealer_profile', $user);
                      redirect('dealer', 'refresh');
                  }
                }
                //(2.2) If Not Found, Load Registration Form with FB User Data
                else{
                  $this->session->set_userdata('social_register_fbid', $facebook_user['facebook_id']);
                  $this->session->set_userdata('social_register_email', $facebook_user['email']);
                  $this->session->set_userdata('social_register_name', $facebook_user['fullname']);
                  redirect('register', 'refresh');
                }
            }
        }
        else{
            redirect(site_url().'?error=fb_auth', 'refresh');
        }
    }

    public function reset_password(){
        $url                  = $this->config->item('api_url');
        $resource             = 'users/reset_password';
        $query                = '/request?';
        $key                  = 'key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $reset_password_url   = $url . $resource . $query . $key;
	    try{

	    	$client = new GuzzleHttp\Client([ 'base_uri' => $url ]);

	    	//print_r($client);

	    } catch(Exception $e){
	    	echo $e;
	    }

        $this->template->set('body_class', 'login');
        $this->template->set('reset_password_url', $reset_password_url);
        $this->template->set('type', 'registration');
        $this->template->build('verify_email');
    }

    public function register($type=''){
        if($type=='seller'){
          $email        = $this->input->post('email');
          $password     = $this->input->post('password');
          $re_password  = $this->input->post('re_password');

          $email_info = $this->check_email($email);
          if($email_info->status == "error"){
            $error_message = $email_info->error_message;

            $this->template->set('error_message', $error_message);
            $this->template->set('title', 'Register');
            $this->template->set('body_class', 'register');
            $this->template->set('type', 'registration');
            $this->template->build('register');
          }else{

          //validation
            if($email && $re_password == $password){

              $this->session->set_userdata('email', $email);
              $this->session->set_userdata('password', $password);
              $this->template->set('body_class', 'register');
              $this->template->set('type', 'registration');
              $this->template->build('register_seller');
            }
            else{
              $this->template->set('error_message', 'Your passwords did not match. Please confirm and try again.');
              $this->template->set('body_class', 'register');
              $this->template->set('type', 'registration');
              $this->template->build('register');
            }
          }
  	    }
  	    elseif($type=='dealer'){
            $registration_role = $this->input->post('registration-role');
            if($registration_role=='seller'){
              $first_name      = $this->input->post('first_name');
              $last_name       = $this->input->post('last_name');
              $this->session->set_userdata('email', $this->input->post('email'));
              $cellphone       = $this->input->post('phone_number');
              $address_1       = $this->input->post('address_1');
              $address_2       = $this->input->post('address_2');
              $city            = $this->input->post('city');
              $state           = $this->input->post('state');
              $zip_code        = $this->input->post('zip_code');
              $facebook_id     = $this->session->userdata('social_register_fbid');
              $google_id       = $this->session->userdata('social_register_gid');
              //Guzzle API seller registration
              $url             = $this->config->item('api_url');
              $resource        = 'sellers';
              $query           = '/register?';
              $key             = 'key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
              $api_url         = $url . $resource . $query . $key;

              try{
                $client          = new GuzzleHttp\Client([ 'base_uri' => $url ]);
                $response        = $client->request('POST', $api_url,
                                      [
                                        'form_params' =>
                                          [
                                              'email'       => $this->session->userdata('email'),
                                              'password'    => $this->session->userdata('password'),
                                              'first_name'  => $first_name,
                                              'last_name'   => $last_name,
                                              'cellphone'   => $cellphone,
                                              'address_1'   => $address_1,
                                              'address_2'   => $address_2,
                                              'city'        => $city,
                                              'state'       => $state,
                                              'zipcode'     => $zip_code,
                                              'facebook_id' => $facebook_id,
                                              'google_id'   => $google_id
                                          ]
                                      ]
                                  );

                $content          = $response->getBody()->getContents();
                $result           = json_decode($content);
                $result           = $result->data;

                if(!empty($result)){
                  $this->session->set_userdata('login', true);
                  $this->session->set_userdata('seller_profile', $result);
                  redirect('seller', 'refresh');
                }else{
                  redirect('home', 'refresh');
                }

              }
              catch(Exception $e){
                //echo $e;
                redirect('home', 'refresh');
              }
            }else{
              $company_name     = $this->input->post('company_name');
              $address_1        = $this->input->post('address_1');
              $address_2        = $this->input->post('address_2');
              $city             = $this->input->post('city');
              $state            = $this->input->post('state');
              $zip_code         = $this->input->post('zip_code');
              $company_email    = $this->input->post('company_email');
              $company_phone    = $this->input->post('company_phone');
              $company_website  = $this->input->post('company_website');
              $company_address  = $this->input->post('company_address');

              $dealer_data     = array(
                'company_name'  => $company_name,
                'address_1'     => $address_1,
                'address_2'     => $address_2,
                'city'          => $city,
                'state'         => $state,
                'zip_code'      => $zip_code,
                'company_email' => $company_email,
                'company_phone' => $company_phone,
                'company_website' => $company_website,
                'company_address' => $company_address
                );

              $this->session->set_userdata('dealer_data', $dealer_data);

              $this->template->set('body_class', 'register');
              $this->template->set('type', 'registration');
              $this->template->build('register_dealer');
            }

        }elseif($type=='dealer_create'){
          $key_contact          = $this->input->post('key_contact');
          $key_contact_title    = $this->input->post('key_contact_title');
          $key_contact_email    = $this->input->post('key_contact_email');
          $key_contact_phone    = $this->input->post('key_contact_phone');
          $key_contact_mobile   = $this->input->post('key_contact_mobile');
          $company_type         = $this->input->post('company_type');
          $year_established     = $this->input->post('year_established');
          $number_of_employees  = $this->input->post('number_of_employees');
          $facebook_id          = $this->session->userdata('social_register_fbid');
          $google_id            = $this->session->userdata('social_register_gid');

          $dealer_data = $this->session->userdata('dealer_data');
          //Guzzle Dealer Register
          $url             = $this->config->item('api_url');
          $resource        = 'dealers';
          $query           = '/register?';
          $key             = 'key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
          $api_url         = $url . $resource . $query . $key;

          try{
            $client          = new GuzzleHttp\Client([ 'base_uri' => $url ]);
            $response        = $client->request('POST', $api_url,
                                  [
                                    'form_params' =>
                                      [
                                          'email'             => $this->session->userdata('email'),
                                          'password'          => $this->session->userdata('password'),
                                          'company_name'      => $dealer_data['company_name'],
                                          'address_1'         => $dealer_data['address_1'],
                                          'address_2'         => $dealer_data['address_2'],
                                          'city'              => $dealer_data['city'],
                                          'state'             => $dealer_data['state'],
                                          'zipcode'           => $dealer_data['zip_code'],
                                          'company_email'     => $dealer_data['company_email'],
                                          'company_phone'     => $dealer_data['company_phone'],
                                          'company_website'   => $dealer_data['company_website'],
                                          'company_address'   => $dealer_data['company_address'],
                                          'key_contact'       => $key_contact,
                                          'key_contact_title' => $key_contact_title,
                                          'key_contact_email' => $key_contact_email,
                                          'key_contact_phone' => $key_contact_phone,
                                          'key_contact_mobile'=> $key_contact_mobile,
                                          'company_type'      => $company_type,
                                          'company_est_year'  => $year_established,
                                          'company_employees' => $number_of_employees,
                                          'facebook_id'       => $facebook_id,
                                          'google_id'         => $google_id
                                      ]
                                  ]
                              );

            $content          = $response->getBody()->getContents();
            $result           = json_decode($content);
            $result           = $result->data;
            //go to login
            // redirect('login', 'refresh');

            if(!empty($result)){
              $this->session->set_userdata('login', true);
              $this->session->set_userdata('dealer_profile', $result);
              redirect('dealer', 'refresh');
            }else{
              redirect('home', 'refresh');
            }
          }
          catch(Exception $e){
            //echo $e;
            redirect('register/dealer', 'refresh');
          }
        }
        else{
            $this->template->set('body_class', 'register');
            $this->template->set('type', 'registration');
            $this->template->build('register');
        }
    }

    private function registration()
    {
        $first_name      = $this->input->post('first_name');
        $last_name       = $this->input->post('last_name');
        $email           = $this->input->post('email');
        $password        = $this->input->post('password');
        $cellphone       = $this->input->post('cellphone');
        $avatar          = $this->input->post('avatar');
        $facebook        = $this->input->post('facebook');
        $google          = $this->input->post('google');
        $address_1       = $this->input->post('address_1');
        $address_2       = $this->input->post('address_2');
        $city            = $this->input->post('city');
        $state           = $this->input->post('state');
        $zip_code        = $this->input->post('zip_code');
        $avatar          = $this->input->post('avatar');

        $url             = $this->config->item('api_url');
        $resource        = $this->input->post('role');
        $query           = '/register?';
        $key             = 'key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
        $api_url         = $url . $resource . $query . $key;

        try{
          $client          = new GuzzleHttp\Client([ 'base_uri' => $url ]);
          $response        = $client->request('POST', $api_url,
                                [
                                  'form_params' =>
                                    [
                                        'first_name'  => $first_name,
                                        'last_name'   => $last_name,
                                        'email'       => $email,
                                        'password'    => $password,
                                        'cellphone'   => $cellphone,
                                        'avatar'      => $avatar,
                                        'facebook'    => $facebook,
                                        'google'      => $google,
                                        'address_1'   => $address_1,
                                        'address_2'   => $address_2,
                                        'city'        => $city,
                                        'zipcode'    => $zip_code,
                                        'state'       => $state,
                                        'avatar'      => $avatar
                                    ]
                                ]
                            );
          $result          = $response->getBody()->getContents();
          $result          = json_decode($result);
        }
        catch(Exception $e){
          //echo $e;
        }

    }

    public function logout(){
        /*
        $this->session->unset_userdata('login');
        $this->session->unset_userdata('seller_profile');
        $this->session->unset_userdata('dealer_profile');
        $this->session->unset_userdata('fb_access_token');
        $this->session->unset_userdata('fb_expire');
        $this->session->unset_userdata('social_register_fbid');
        $this->session->unset_userdata('social_register_gid');
        $this->session->unset_userdata('social_register_name');
        $this->session->unset_userdata('social_register_email');
        */
        $this->session->sess_destroy();
        redirect('', 'refresh');
    }

    private function check_email($email){
    $url            = $this->config->item('api_url');
    $resource       = 'users';
    $query          = '/check_email';
    $key            = '?key=312fd05d107f1b0a42ea36a7b4dfa282019d42be';
    $api_url        = $url . $resource . $query . $key;

    try{
        $client          = new GuzzleHttp\Client([ 'base_uri' => $url ]);
        $response        = $client->request('POST', $api_url,
                              [
                                'form_params' =>
                                  [
                                      'email'     => $email
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

}

?>
