<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';

$route['(:any)/(:any)/list'] = "$1/list_/$2";
$route['(:any)/list/(:any)'] = "$1/list_/$2";
$route['(:any)/list'] = "$1/list_";

$route['(:any)/list/photos/(:num)/sort'] = "$1/photo_sort/$2";

$route['(:any)/(:any)/sort'] = "$1/sort_/$2";


$route['(:any)/list/edit/(:num)'] = "$1/edit_/$2";
$route['(:any)/list/delete/(:num)'] = "$1/delete_/$2";
$route['(:any)/list/photos/(:num)/set_as_primary/(:num)'] = "$1/photo_set_as_primary/$2/$3";
$route['(:any)/list/photos/(:num)/delete/(:num)'] = "$1/photo_delete/$2/$3";
$route['(:any)/list/photos/(:num)/edit/(:num)'] = "$1/photo_edit/$2/$3";
$route['(:any)/list/photos/(:num)/add'] = "$1/photo_add/$2";
$route['(:any)/list/photos/(:num)'] = "$1/photos/$2";

$route['(:any)/list/installation/(:num)/set_as_primary/(:num)'] = "$1/installation_set_as_primary/$2/$3";
$route['(:any)/list/installation/(:num)/delete/(:num)'] = "$1/installation_delete/$2/$3";
$route['(:any)/list/installation/(:num)/edit/(:num)'] = "$1/installation_edit/$2/$3";
$route['(:any)/list/installation/(:num)/add'] = "$1/installation_add/$2";
$route['(:any)/list/installation/(:num)'] = "$1/installation/$2";




/* End of file routes.php */
/* Location: ./application/config/routes.php */
