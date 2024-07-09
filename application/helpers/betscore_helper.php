<?php
/**
 * @author   Mh Tusher
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('menu_active_route')) {

	function menu_active_route($route_name)
	{
		$ci =& get_instance();
		$ci->load->helper('url');
		if ($route_name == $ci->uri->segment(1)) {
			echo "active";
		}
	}
}

if (!function_exists('get_club_name')) {

	function get_club_name($id)
	{
		$CI =& get_instance();
		$CI->db->select('club_name');
		$CI->db->from('club_users');
		$CI->db->where('id', $id);
		$query = $CI->db->get();
		if (!empty($query->row())) {
			return $query->row()->club_name;
		}
		return '';
	}
}

if (!function_exists('get_club_id_by_username')) {

	function get_club_id_by_username($id)
	{
		$CI =& get_instance();
		$CI->db->select('id');
		$CI->db->from('club_users');
		$CI->db->where('club_name', $id);
		$query = $CI->db->get();
		if (!empty($query->row())) {
			return $query->row()->id;
		}
		return '';
	}
}

if (!function_exists('get_user_name')) {

	function get_user_name($id)
	{
		$CI =& get_instance();
		$CI->db->select('name');
		$CI->db->from('users');
		$CI->db->where('id', $id);
		$query = $CI->db->get();
		if (!empty($query->row())) {
			return $query->row()->name;
		}
		return '';
	}
}

if (!function_exists('get_username')) {

	function get_username($id)
	{
		$CI =& get_instance();
		$CI->db->select('username');
		$CI->db->from('users');
		$CI->db->where('id', $id);
		$query = $CI->db->get();
		if (!empty($query->row())) {
			return $query->row()->username;
		}
		return '';
	}
}

if (!function_exists('get_user_id_by_username')) {

	function get_user_id_by_username($id)
	{
		$CI =& get_instance();
		$CI->db->select('id');
		$CI->db->from('users');
		$CI->db->where('username', $id);
		$query = $CI->db->get();
		if (!empty($query->row())) {
			return $query->row()->id;
		}
		return '';
	}
}

if (!function_exists('get_user_club_id')) {

	function get_user_club_id($id)
	{
		$CI =& get_instance();
		$CI->db->select('club_id');
		$CI->db->from('users');
		$CI->db->where('id', $id);
		$query = $CI->db->get();
		if (!empty($query->row())) {
			return $query->row()->club_id;
		}
		return '';
	}
}

if (!function_exists('get_user_sponsor_id')) {

	function get_user_sponsor_id($id)
	{
		$CI =& get_instance();
		$CI->db->select('sponsor_id');
		$CI->db->from('users');
		$CI->db->where('id', $id);
		$query = $CI->db->get();
		if (!empty($query->row())) {
			return $query->row()->sponsor_id;
		}
		return '';
	}
}

if (!function_exists('get_user_current_balance')) {

	function get_user_current_balance($user_id)
	{
		$CI =& get_instance();
		$CI->db->select('current_balance');
		$CI->db->from('my_coin');
		$CI->db->where('user_id', $user_id);
		$CI->db->order_by("id", "desc");
		$query = $CI->db->get();
		if (!empty($query->row())) {
			return $query->row()->current_balance;
		}
		return 0;
	}
}

if (!function_exists('get_club_current_balance')) {

	function get_club_current_balance($user_id)
	{
		$CI =& get_instance();
		$CI->db->select('current_balance');
		$CI->db->from('club_coin');
		$CI->db->where('club_id', $user_id);
		$CI->db->order_by("id", "desc");
		$query = $CI->db->get();
		if (!empty($query->row())) {
			return $query->row()->current_balance;
		}
		return 0;
	}
}

if (!function_exists('get_club_balance')) {

	function get_club_balance($club_id)
	{
		$CI =& get_instance();
		$get_coin = 0;
		$post_coin = 0;
		$get_data = $CI->db->query("SELECT SUM(coin) AS get_coin FROM `club_coin` WHERE club_id='{$club_id}' AND method='GET'")->row();
		if( !empty($get_data->get_coin) ) {
			$get_coin = $get_data->get_coin;
		}

		$post_data = $CI->db->query("SELECT SUM(coin) AS post_coin FROM `club_coin` WHERE club_id='$club_id' AND method='POST'")->row();
		if( !empty($post_data->post_coin) ) {
			$post_coin = $post_data->post_coin;
		}

		$total_coin = $get_coin - $post_coin;
		if($total_coin < 0) {
			$total_coin = 0;
		}
		return $total_coin;
	}
}

if (!function_exists('status_bg_color')) {

	function status_bg_color($status)
	{
		switch ($status) {
			case "PENDING":
				$result = "<span class=\"badge badge-pending\">Pending</span>";
				break;
			case "SUCCESS":
				$result = "<span class=\"badge badge-complete\">Complete</span>";
				break;
			case "CANCEL":
				$result = "<span class=\"badge badge-cancel\">Cancel</span>";
				break;

			default:
				break;
		}
		return $result;
	}
}

if (!function_exists('bet_history_status_color')) {

	function bet_history_status_color($status)
	{
		switch ($status) {
			case "WIN":
				$res = "<span class=\"badge badge-success\">WIN</span>";
				break;
			case "LOST":
				$res = "<span class=\"badge badge-danger\">LOST</span>";
				break;
			case "USER_CANCEL":
				$res = "<span class=\"badge badge-secondary\">BET CANCEL</span>";
				break;
			case "CANCEL_ADMIN":
				$res = "<span class=\"badge badge-info\">CANCEL</span>";
				break;
			case "ADMIN_CANCEL":
				$res = "<span class=\"badge badge-info\">FAILED</span>";
				break;
			case "MATCH_RUNNING":
				$res = "<span class=\"badge badge-warning\">RUNNING</span>";
				break;
			default:
				break;
		}
		return $res;
	}

}

if (!function_exists('menu_active_route')) {

	function menu_active_route($route_name)
	{
		$ci =& get_instance();
		$ci->load->helper('url');
		if (in_array($ci->uri->segment(1),$route_name)){
			$result = 1;
		}
		return $result;
	}
}

if (!function_exists('get_match_live_or_upcoming')) {

	function get_match_live_or_upcoming($id)
	{
		$CI =& get_instance();
		$CI->db->select('active_status');
		$CI->db->from('matchname');
		$CI->db->where('id', $id); 
		$query = $CI->db->get();
		if (!empty($query->row())) {
			return $query->row()->active_status;
		}
		return 0;
	}
}

if (!function_exists('get_match_live_or_upcoming_from_mo')) {

	function get_match_live_or_upcoming_from_mo($id)
	{
		$CI =& get_instance();
		$CI->db->select('match_id');
		$CI->db->from('match_option');
		$CI->db->where('id', $id); 
		$query = $CI->db->get();
		if (!empty($query->row())) {
			$m_id = $query->row()->match_id;
			return get_match_live_or_upcoming($m_id);
		}
		return 0;
	}
}

if (!function_exists('get_match_live_or_upcoming_from_mod')) {

	function get_match_live_or_upcoming_from_mod($id)
	{
		$CI =& get_instance();
		$CI->db->select('match_id');
		$CI->db->from('match_option');
		$CI->db->where('id', $id); 
		$query = $CI->db->get();
		if (!empty($query->row())) {
			$m_id = $query->row()->match_id;
			return get_match_live_or_upcoming($m_id);
		}
		return 0;
	}
}

if (!function_exists('trigger_pusher')) {

	function trigger_pusher($ch,$ev) {
		$ci =& get_instance();

		// -- pusher server side code
		$data = [];
		$ci->load->view('vendor/autoload.php'); 
			$options = array(
		    'cluster' => 'ap1',
		    'useTLS' => true
		  );
		  $pusher = new Pusher\Pusher(
		    '734a83109a657d6a3c32',
		    '83552c393b33c22380c2',
		    '1059840',
		    $options
		  );

		$data['message'] = 'get_pushar_message';
		$pusher->trigger($ch, $ev, $data);
		// -- end pusher
		
	}
}

if (!function_exists('admin_access_menu')) {

    function admin_access_menu($route_string, $route_name)
    {
        if($route_string=='super_admin') {
            return true;
        }
        $route_str = explode(",", $route_string);

        $ci =& get_instance();
        $ci->load->helper('url');
        if( in_array($route_name, $route_str) ) {
            return true;
        }
    }
}

if (!function_exists('verify_group_route')) {

    function verify_group_route($route_arr)
    {
        $ci =& get_instance();
        $ci->load->helper('url');

        $role_data = explode(',', $_SESSION['admin_user_data']->role_data);
        if($role_data[0]=='super_admin') {
        	return true;
        }
        if( array_intersect($role_data, $route_arr) ) {
            return true;
        }
    }
}


if (!function_exists('get_matchbet_coin_status')) {

	function get_matchbet_coin_status($id)
	{
		$CI =& get_instance();
		$CI->db->select('bet_status');
		$CI->db->from('matchbit_coin');
		$CI->db->where('id', $id);
		$CI->db->order_by("id", "desc");
		$query = $CI->db->get();
		if (!empty($query->row())) {
			return $query->row()->bet_status;
		}
		return 0;
	}
}

if (!function_exists('get_multi_bet_status')) {

	function get_multi_bet_status($id)
	{
		$CI =& get_instance();
		$CI->db->select('status');
		$CI->db->from('multibet');
		$CI->db->where('id', $id);
		$CI->db->order_by("id", "desc");
		$query = $CI->db->get();
		if (!empty($query->row())) {
			return $query->row()->status;
		}
		return 0;
	}
}

if (!function_exists('get_total_bet_running')) {

	function get_total_bet_running($id)
	{
		$CI =& get_instance();
		$CI->db->select('sum(bet_coin) as bet_total');
		$CI->db->from('matchbit_coin');
		$CI->db->where('match_bit_id', $id); 
		$query = $CI->db->get();
		if (!empty($query->row())) {
			return $query->row()->bet_total;
		}
		return 0;
	}
}

if (!function_exists('get_total_bet_return')) {

	function get_total_bet_return($id)
	{
		$CI =& get_instance();
		$CI->db->select('sum(total_coin) as bet_total');
		$CI->db->from('matchbit_coin');
		$CI->db->where('match_bit_id', $id); 
		$query = $CI->db->get();
		if (!empty($query->row())) {
			return $query->row()->bet_total;
		}
		return 0;
	}
}


if (!function_exists('get_total_match_bet_running')) {

	function get_total_match_bet_running($id)
	{
		$CI =& get_instance();
		$CI->db->select('sum(bet_coin) as bet_total');
		$CI->db->from('matchbit_coin');
		$CI->db->where('match_id', $id); 
		$query = $CI->db->get();
		if (!empty($query->row())) {
			return $query->row()->bet_total;
		}
		return 0;
	}
}

if (!function_exists('get_total_match_bet_return')) {

	function get_total_match_bet_return($id)
	{
		$CI =& get_instance();
		$CI->db->select('sum(total_coin) as bet_total');
		$CI->db->from('matchbit_coin');
		$CI->db->where('match_id', $id); 
		$query = $CI->db->get();
		if (!empty($query->row())) {
			return $query->row()->bet_total;
		}
		return 0;
	}
}

if (!function_exists('get_user_balance_plus_minus_btn')) {

	function get_user_balance_plus_minus_btn()
	{
		$CI =& get_instance();
		$CI->db->select('user_balance_plus_minus');
		$CI->db->from('settings');
		$CI->db->where('id', 1); 
		$query = $CI->db->get();
		if (!empty($query->row())) {
			return $query->row()->user_balance_plus_minus;
		}
		return 0;
	}
}

if (!function_exists('get_client_ip')) {

	function get_client_ip()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		    $ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
}