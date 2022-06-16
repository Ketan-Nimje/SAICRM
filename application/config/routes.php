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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'Welcome';
$route['404_override'] = 'Custom404';
$route['translate_uri_dashes'] = FALSE;

/**
 * Admin Site User Defined Routes
 */

// analytic routes
$route['logout'] = 'Auth/logout';

// analytic routes
$route['dashboard'] = 'Dashboard/index';
$route['change-password'] = 'Dashboard/changePassword';

// follow up routes: tables
$folder = 'tables/';

$route["{$folder}client-master"] = "{$folder}ClientMaster/index";
$route["{$folder}client-master/get_data"] = "{$folder}ClientMaster/get_data";
$route["{$folder}client-master/add_update"] = "{$folder}ClientMaster/add_update";
$route["{$folder}client-master/edit/(:num)"] = "{$folder}ClientMaster/edit/$1";
$route["{$folder}client-master/show/(:num)"] = "{$folder}ClientMaster/show/$1";
$route["{$folder}client-master/delete"] = "{$folder}ClientMaster/delete";
$route["{$folder}client-master/change_status"] = "{$folder}ClientMaster/change_status";

$route["{$folder}client-view"] = "{$folder}ClientView/index";
$route["{$folder}client-view/get_data"] = "{$folder}ClientView/get_data";
$route["{$folder}client-view/add_update"] = "{$folder}ClientView/add_update";
$route["{$folder}client-view/edit/(:num)"] = "{$folder}ClientView/edit/$1";
$route["{$folder}client-view/show/(:num)"] = "{$folder}ClientView/show/$1";
$route["{$folder}client-view/delete"] = "{$folder}ClientView/delete";
$route["{$folder}client-view/change_status"] = "{$folder}ClientView/change_status";

$route["{$folder}transactions-detail"] = "{$folder}TransactionsDetail/index";
$route["{$folder}transactions-detail/get_data"] = "{$folder}TransactionsDetail/get_data";
$route["{$folder}transactions-detail/add_update"] = "{$folder}TransactionsDetail/add_update";
$route["{$folder}transactions-detail/edit/(:num)"] = "{$folder}TransactionsDetail/edit/$1";
$route["{$folder}transactions-detail/show/(:num)"] = "{$folder}TransactionsDetail/show/$1";
$route["{$folder}transactions-detail/delete"] = "{$folder}TransactionsDetail/delete";
$route["{$folder}transactions-detail/change_status"] = "{$folder}TransactionsDetail/change_status";

// follow up routes: Configuration
$folder = 'configuration/';

$route["{$folder}contact"] = "{$folder}Contact/index";

$route["{$folder}for-year"] = "{$folder}ForYear/index";
$route["{$folder}for-year/get_data"] = "{$folder}ForYear/get_data";
$route["{$folder}for-year/add_update"] = "{$folder}ForYear/add_update";
$route["{$folder}for-year/edit/(:num)"] = "{$folder}ForYear/edit/$1";
$route["{$folder}for-year/show/(:num)"] = "{$folder}ForYear/show/$1";
$route["{$folder}for-year/delete"] = "{$folder}ForYear/delete";
$route["{$folder}for-year/change_status"] = "{$folder}ForYear/change_status";

$route["{$folder}gst-key"] = "{$folder}GstKey/index";
$route["{$folder}gst-key/get_data"] = "{$folder}GstKey/get_data";
$route["{$folder}gst-key/add_update"] = "{$folder}GstKey/add_update";
$route["{$folder}gst-key/edit/(:num)"] = "{$folder}GstKey/edit/$1";
$route["{$folder}gst-key/show/(:num)"] = "{$folder}GstKey/show/$1";
$route["{$folder}gst-key/delete"] = "{$folder}GstKey/delete";
$route["{$folder}gst-key/change_status"] = "{$folder}GstKey/change_status";
$route["{$folder}state"] = "{$folder}State/index";
$route["{$folder}product"] = "{$folder}Product/index";

$folder = 'help-desk';

$route["{$folder}help"] = "{$folder}Help/index";

$route["{$folder}quick"] = "{$folder}Quick/index";
$route["{$folder}transaction"] = "{$folder}Transaction/index";

// follow up routes: Manage Products
$folder = 'manage-products/';

$route["{$folder}category"] = "{$folder}Category/index";
$route["{$folder}product"] = "{$folder}Product/index";
$route["{$folder}product/get_categories"] = "{$folder}Category/get_categories";

// follow up routes: Manage SEO
$folder = 'manage-seo/';

$route["{$folder}seo"] = "{$folder}Seo/index";

// pages routes: Manage Homepage
$folder = 'manage-homepage/';

$route["{$folder}announcement"] = "{$folder}Announcement/index";
$route["{$folder}client"] = "{$folder}Client/index";
$route["{$folder}home-popup"] = "{$folder}HomePopup/index";
$route["{$folder}home-popup/get_data"] = "{$folder}HomePopup/get_data";
$route["{$folder}home-popup/add_update"] = "{$folder}HomePopup/add_update";
$route["{$folder}home-popup/edit/(:num)"] = "{$folder}HomePopup/edit/$1";
$route["{$folder}home-popup/show"] = "{$folder}HomePopup/show";
$route["{$folder}home-popup/delete"] = "{$folder}HomePopup/delete";
$route["{$folder}home-popup/change_status"] = "{$folder}HomePopup/change_status";

$route["{$folder}slider"] = "{$folder}Slider/index";
$route["{$folder}software-feature"] = "{$folder}SoftwareFeature/index";
$route["{$folder}software-feature/add_update_software_desc"] = "{$folder}SoftwareFeature/add_update_software_desc";
$route["{$folder}software-feature/add_update"] = "{$folder}SoftwareFeature/add_update";
$route["{$folder}software-feature/edit/(:num)"] = "{$folder}SoftwareFeature/edit/$1";
$route["{$folder}software-feature/show"] = "{$folder}SoftwareFeature/show";
$route["{$folder}software-feature/delete"] = "{$folder}SoftwareFeature/delete";
$route["{$folder}software-feature/change_status"] = "{$folder}SoftwareFeature/change_status";

$route["{$folder}testimoinal"] = "{$folder}Testimoinal/index";
$route["{$folder}welcome"] = "{$folder}Welcome/index";

// pages routes: Manage Custom Pages
$folder = 'manage-custom-pages/';

$route["{$folder}about-us"] = "{$folder}AboutUs/index";
$route["{$folder}about-us/add_update"] = "{$folder}AboutUs/add_update";
$route["{$folder}about-us/edit/(:num)"] = "{$folder}AboutUs/edit/$1";
$route["{$folder}about-us/show"] = "{$folder}AboutUs/show";
$route["{$folder}about-us/delete"] = "{$folder}AboutUs/delete";
$route["{$folder}about-us/change_status"] = "{$folder}AboutUs/change_status";

$route["{$folder}bank-detail"] = "{$folder}BankDetail/index";
$route["{$folder}bank-detail/get_data"] = "{$folder}BankDetail/get_data";
$route["{$folder}bank-detail/add_update"] = "{$folder}BankDetail/add_update";
$route["{$folder}bank-detail/edit/(:num)"] = "{$folder}BankDetail/edit/$1";
$route["{$folder}bank-detail/show"] = "{$folder}BankDetail/show";
$route["{$folder}bank-detail/delete"] = "{$folder}BankDetail/delete";
$route["{$folder}bank-detail/change_status"] = "{$folder}BankDetail/change_status";

$route["{$folder}career"] = "{$folder}Career/index";

$route["{$folder}career-job"] = "{$folder}CareerJob/index";
$route["{$folder}career-job/add_update"] = "{$folder}CareerJob/add_update";
$route["{$folder}career-job/edit/(:num)"] = "{$folder}CareerJob/edit/$1";
$route["{$folder}career-job/show"] = "{$folder}CareerJob/show";
$route["{$folder}career-job/delete"] = "{$folder}CareerJob/delete";
$route["{$folder}career-job/change_status"] = "{$folder}CareerJob/change_status";

$route["{$folder}contact-info"] = "{$folder}ContactInfo/index";
$route["{$folder}contact-info/get_data"] = "{$folder}ContactInfo/get_data";
$route["{$folder}contact-info/add_update"] = "{$folder}ContactInfo/add_update";
$route["{$folder}contact-info/edit/(:num)"] = "{$folder}ContactInfo/edit/$1";
$route["{$folder}contact-info/show"] = "{$folder}ContactInfo/show";
$route["{$folder}contact-info/delete"] = "{$folder}ContactInfo/delete";
$route["{$folder}contact-info/change_status"] = "{$folder}ContactInfo/change_status";

$route["{$folder}digital-sign"] = "{$folder}DigitalSign/index";
$route["{$folder}digital-sign/add_update"] = "{$folder}DigitalSign/add_update";
$route["{$folder}digital-sign/edit/(:num)"] = "{$folder}DigitalSign/edit/$1";
$route["{$folder}digital-sign/show"] = "{$folder}DigitalSign/show";
$route["{$folder}digital-sign/delete"] = "{$folder}DigitalSign/delete";
$route["{$folder}digital-sign/change_status"] = "{$folder}DigitalSign/change_status";

$route["{$folder}faq"] = "{$folder}Faq/index";
$route["{$folder}privacy"] = "{$folder}Privacy/index";

$route["{$folder}social-media"] = "{$folder}SocialMedia/index";
$route["{$folder}social-media/get_data"] = "{$folder}SocialMedia/get_data";
$route["{$folder}social-media/add_update"] = "{$folder}SocialMedia/add_update";
$route["{$folder}social-media/edit/(:num)"] = "{$folder}SocialMedia/edit/$1";
$route["{$folder}social-media/show"] = "{$folder}SocialMedia/show";
$route["{$folder}social-media/delete"] = "{$folder}SocialMedia/delete";
$route["{$folder}social-media/change_status"] = "{$folder}SocialMedia/change_status";

$route["{$folder}term"] = "{$folder}Term/index";

// follow up routes: Manage Account & Priviliges
$folder = 'manage-account-priviliges/';

$route["{$folder}user"] = "{$folder}User/index";
$route["{$folder}user-priviliges"] = "{$folder}UserPrivilige/index";
$route["{$folder}user-priviliges/get_data"] = "{$folder}UserPrivilige/get_data";
$route["{$folder}user-priviliges/add_update"] = "{$folder}UserPrivilige/add_update";
$route["{$folder}user-priviliges/edit/(:num)"] = "{$folder}UserPrivilige/edit/$1";
$route["{$folder}user-priviliges/show"] = "{$folder}UserPrivilige/show";
$route["{$folder}user-priviliges/delete"] = "{$folder}UserPrivilige/delete";
$route["{$folder}user-priviliges/change_status"] = "{$folder}UserPrivilige/change_status";

$route["{$folder}menu-assign"] = "{$folder}MenuAssign/index";
$route["{$folder}menu-assign/get_data"] = "{$folder}MenuAssign/get_data";
$route["{$folder}menu-assign/add_update"] = "{$folder}MenuAssign/add_update";
$route["{$folder}menu-assign/edit/(:num)"] = "{$folder}MenuAssign/edit/$1";
$route["{$folder}menu-assign/show"] = "{$folder}MenuAssign/show";
$route["{$folder}menu-assign/delete"] = "{$folder}MenuAssign/delete";
$route["{$folder}menu-assign/change_status"] = "{$folder}MenuAssign/change_status";

// follow up routes: Manage Teams
$folder = 'manage-teams/';

$route["{$folder}team"] = "{$folder}Team/index";