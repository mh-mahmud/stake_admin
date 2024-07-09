<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// The items on Envato Market are owned by the authors, not by us. ... compilation, and look and feel of the Envato Market sites, and copyright, trademarks

/*5th Floor,
|Dragonara Business Centre
|Dragonara Road, St. Julian's
|STJ 3141, Malta
*/ 

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
$route['default_controller'] = 'welcome/admin_login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['admin_login'] = 'welcome/admin_login';
 

$route['manage_sports'] = 'admin/manage_sports';
$route['match_details'] = 'admin/match_details';
$route['match_history'] = 'admin/match_history';
$route['match_details/view/:any'] = 'admin/view_details';
$route['match_details/view_end/:any'] = 'admin/view_details_end';
$route['match_details/view/:any/:any'] = 'extrasettings/get_match_saved_question';
$route['match_details/more_view/:any/:any'] = 'Morequestion/get_match_saved_question';
$route['match_details/view_add/:any'] = 'admin/add_extra_match_option';
$route['create_match'] = 'admin/create_match';
$route['remove_match/:any'] = 'admin/remove_match';
$route['matchbit_coin'] = 'admin/matchbit_coin';
$route['matchbit_coin_prev'] = 'admin/matchbit_coin_prev';
$route['edit_match_data'] = 'admin/edit_match_data';

$route['customer_deposit'] = 'admin/customer_deposit';
$route['approve_deposit'] = 'admin/approve_deposit';
$route['approve_withdraw'] = 'admin/approve_withdraw';
$route['approve_club_withdraw'] = 'admin/approve_club_withdraw';
$route['reply_complain'] = 'admin/reply_complain';
$route['remove_complain/:any'] = 'admin/remove_complain';
$route['customer_withdraw'] = 'admin/customer_withdraw';
$route['customer_complain'] = 'admin/customer_complain';
$route['customer_balance_transfer'] = 'admin/customer_balance_transfer';
$route['club_withdraw'] = 'admin/club_withdraw';

// hidtory route
$route['customer_deposit_history'] = 'admin/customer_deposit_history';
$route['match_bit_coin_history'] = 'admin/match_bit_coin_history';
$route['customer_withdraw_history'] = 'admin/customer_withdraw_history';
$route['club_withdraw_history'] = 'admin/club_withdraw_history';
$route['balance_transfer_history'] = 'admin/balance_transfer_history';
$route['complain_history'] = 'admin/complain_history';

$route['club_user'] = 'admin/club_user';
$route['fault_user'] = 'admin/fault_user';
$route['admin_user'] = 'admin/admin_user';
$route['customer_user'] = 'admin/customer_user';
$route['manage_role'] = 'admin/manage_role'; 
$route['notice-panel'] = 'admin/notice_panel';
$route['deposit_account'] = 'admin/deposit_account';
$route['withdraw_account'] = 'admin/withdraw_account';


$route['user_statement'] = 'admin/user_statement';
$route['club_statement'] = 'admin/club_statement';
$route['settings'] = 'admin/settings'; 

// extra settings

$route['sports_icon'] = 'extrasettings/sports_icon'; 
$route['slider_banner'] = 'extrasettings/slider_banner';
$route['match_option_save'] = 'extrasettings/match_option_save';
$route['match_save_st/:any/:any'] = 'extrasettings/status_change_for_bet_question';
$route['match_option_view/:any'] = 'extrasettings/match_option_view';

$route['more_match_option_save'] = 'Morequestion/match_option_save';
$route['more_match_save_st/:any/:any'] = 'Morequestion/status_change_for_bet_question';
$route['more_match_option_view/:any'] = 'Morequestion/match_option_view';

$route['total_statement'] = 'extrasettings/total_statement';

// score slider option
$route['change_live_score'] = 'Admin/change_score_live_game';
$route['show_to_slider'] = 'Admin/show_to_slider_game';

// game page router
$route['game_page'] = 'Admin/game_page';
$route['game_page/view/:any'] = 'Admin/game_page_banner';
$route['game_inactive/:any'] = 'Admin/game_page_inactive';
$route['game_active/:any'] = 'Admin/game_page_active';


// multi bet
$route['multibet'] = 'Admin/multibets_data';
$route['multibet/(:num)'] = 'Admin/multibets_data';
 
