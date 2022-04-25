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
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/**
 * Admin Site User Defined Routes
 */

// analytic routes
$route['logout'] = 'Auth/logout';

// analytic routes
$route['dashboard'] = 'Dashboard/index';
$route['change-password'] = 'Dashboard/changePassword';

// follow up routes: Manage Inquiries
$folder = 'manage-inquires/';

$route["{$folder}contact"] = "{$folder}Contact/index";

$route["{$folder}download-setup"] = "{$folder}DownloadSetup/index";
$route["{$folder}download-setup/get_data"] = "{$folder}DownloadSetup/get_data";
$route["{$folder}download-setup/add_update"] = "{$folder}DownloadSetup/add_update";
$route["{$folder}download-setup/edit/(:num)"] = "{$folder}DownloadSetup/edit/$1";
$route["{$folder}download-setup/show/(:num)"] = "{$folder}DownloadSetup/show/$1";
$route["{$folder}download-setup/delete"] = "{$folder}DownloadSetup/delete";
$route["{$folder}download-setup/change_status"] = "{$folder}DownloadSetup/change_status";

$route["{$folder}gst"] = "{$folder}Gst/index";
$route["{$folder}job"] = "{$folder}Job/index";
$route["{$folder}product"] = "{$folder}Product/index";

$route["{$folder}product-download"] = "{$folder}ProductDownload/index";
$route["{$folder}product-download/get_data"] = "{$folder}ProductDownload/get_data";
$route["{$folder}product-download/add_update"] = "{$folder}ProductDownload/add_update";
$route["{$folder}product-download/edit/(:num)"] = "{$folder}ProductDownload/edit/$1";
$route["{$folder}product-download/show/(:num)"] = "{$folder}ProductDownload/show/$1";
$route["{$folder}product-download/delete"] = "{$folder}ProductDownload/delete";
$route["{$folder}product-download/change_status"] = "{$folder}ProductDownload/change_status";

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

$route["{$folder}account"] = "{$folder}Account/index";
$route["{$folder}privilige"] = "{$folder}Privilige/index";

// follow up routes: Manage Teams
$folder = 'manage-teams/';

$route["{$folder}team"] = "{$folder}Team/index";