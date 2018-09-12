<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

//variables in (:num), (:any), ([a-zA-Z_-]+)

$route['404_override']                        = 'error/custom_404';
$route['default_controller']           		  = 'home';
$route['v1']           		  			   	  = 'home/v1';
$route['v2']           		  			   	  = 'home/v2';
$route['v3']           		  			   	  = 'home/v3';
$route['login']                        		  = 'home/login';
$route['signin']                        	  = 'home/signin';
$route['facebook']                            = 'home/facebook_connect';
$route['google']                              = 'home/google_connect';
$route['logout']                              = 'home/logout';
$route['register']              	   		  = 'home/register/index';
$route['register/(:any)']              		  = 'home/register/$1';
$route['reset_password']               		  = 'home/reset_password';
$route['terms']                        		  = 'home/terms';
$route['activated_account']					  = 'home/activated_account';

$route['dealer/(:any)/dashboard']        	  = 'dealer/index/$1';
$route['dealer/(:any)/auction']        	      = 'dealer/auction/$1';
$route['dealer/profile/(:any)']        		  = 'dealer/profile/$1';
$route['dealer/(:num)/preference']     		  = 'dealer/preference/$1';
$route['dealer/preference']     		  	  = 'dealer/preference';
$route['dealer/payment']        		      = 'dealer/profile';
$route['dealer/setting']        		      = 'dealer/profile';
$route['dealer/(:num)']        		      	  = 'dealer/profile';

$route['seller/(:any)/dashboard']             = 'seller/index/$1';
$route['seller/(:num)/auction']        		  = 'seller/auction/$1';
$route['seller/(:num)/preference']     		  = 'seller/preference/$1';
$route['seller/preference']     		  	  = 'seller/preference';
$route['seller/setting']     		  	      = 'seller/profile';
$route['seller/profile/(:any)']        		  = 'seller/profile/$1';

$route['auction/create']     				  = 'auction/create';
$route['auction/(:num)/activate/(:any)']      = 'auction/activate/$1/$2';
// $route['auction/(:num)/edit']   		 	  = 'auction/edit/$1/detail';
// $route['auction/(:num)/edit/(:any)']       = 'auction/edit/$1/$2';
$route['auction/(:num)/edit/(:num)']   		  = 'auction/edit/$1/$2';
$route['auction/(:num)/detail'] 		 	  = 'auction/detail/$1/seller';
$route['auction/(:num)/detail/(:any)/(:any)'] = 'auction/detail/$1/$2/$3';
$route['auction/(:num)/winner/(:any)']        = 'auction/winner/$1/$2';
$route['auction/(:num)/history']        	  = 'auction/history/$1';
$route['auction/(:num)/photos/(:num)/(:any)'] = 'auction/photos/$1/$2/$3';

$route['auction/(:num)/inbox/seller']               = 'auction/inbox/$1/seller';
$route['auction/inbox/dealer']                      = 'auction/inbox/unused/dealer/unused';
$route['auction/(:num)/notification/(:any)/(:num)'] = 'auction/notification/$1/$2/$3';
$route['auction/(:num)/purchase'] 			  		= 'auction/purchase/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
