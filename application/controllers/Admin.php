<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
		$this->load->helper('betscore'); 
		if (empty($this->session->userdata('admin_user_data'))) {
			redirect('/');
		}
	}

	public function index()
	{
		$data = array();
		$data['title'] = 'Dashboard'; 
		$this->load->view('admin/dashboard', $data);
	}

	  

	public function manage_user()
	{
		$data = array();
		$data['title'] = 'Manage User';
		$data['all_users'] = $this->select_model->get_all_users();
		$data['body'] = $this->load->view('admin/manage_user/manage_user', $data, TRUE);
		$this->load->view('admin/common/admin_master', $data);
	}

	public function remove_user()
	{
		$id = $this->uri->segment(3);
		$this->db->query("DELETE FROM users WHERE id='{$id}'");
		$this->session->set_flashdata('msg', 'User deleted successfully');
		redirect('admin/manage_user');
	}

	public function manage_category()
	{
		$data = array();
		$data['title'] = 'Manage Category';
		$data['category'] = $this->db->query("SELECT * FROM category")->result();
		$data['body'] = $this->load->view('admin/manage_category/manage_category', $data, TRUE);
		$this->load->view('admin/common/admin_master', $data);
	}

	public function manage_sports()
	{
		$data = array();
		$data['title'] = 'Manage Sports';
		$data['names'] = $this->db->query("SELECT * FROM sportscategory")->result();
		$data['sports_icon'] = $this->db->query("SELECT * FROM sports_icon WHERE status = 1")->result();
		$data['body'] = $this->load->view('admin/liveinplay/manage_sports', $data);
	}

	public function sports_create()
	{
		$sports_edit_id = $this->input->post('edit_sports_id');
		$sports_name = $this->input->post('sports_name');
		$sports_serial = $this->input->post('sports_serial');
		$sports_icon = $this->input->post('sports_icon');
		if (isset($sports_name) && isset($sports_serial) && isset($sports_icon) && empty($sports_edit_id)) {

			if ($this->db->query("INSERT INTO sportscategory VALUES (null,'$sports_name','1',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,'$sports_serial','0','0','$sports_icon')")) {
				echo json_encode(array('st' => 200, 'msg' => 'Successfully added new sports'));
			} else {
				echo json_encode(array('st' => 400, 'msg' => 'Error! may be some data missing or exits data double entry'));
			}
		} else if (isset($sports_edit_id)) {
			if ($this->db->query("UPDATE sportscategory SET name ='$sports_name',serial='$sports_serial',image='$sports_icon',updated_at=CURRENT_TIMESTAMP WHERE id='$sports_edit_id'")) {
				echo json_encode(array('st' => 200, 'msg' => 'Successfully Updated'));
			}
		} else {
			echo json_encode(array('st' => 400, 'msg' => 'Error! data not entry correctly'));
		}
	}

	public function sports_status_change()
	{
		$sports_id = $this->input->post('id');
		$status_change = $this->input->post('status');
		if (isset($sports_id) && isset($status_change)) {
			if ($this->db->query("UPDATE sportscategory SET active_status='$status_change' WHERE id ='$sports_id'")) {
				echo json_encode(array('st' => 200, 'msg' => 'Successfully update status'));
			} else {
				echo json_encode(array('st' => 400, 'msg' => 'Error! something worng'));
			}
		}
	}

	public function sports_edit()
	{
		$data = array();
		$sports_id = $this->input->post('id');
		if (isset($sports_id)) {
			$get_sports_data = $this->db->query("SELECT * FROM sportscategory WHERE id = '$sports_id' ")->row();
			$data['st'] = 200;
			$data['sport_id'] = $get_sports_data->id;
			$data['name'] = $get_sports_data->name;
			$data['serial'] = $get_sports_data->serial;
			$data['image'] = $get_sports_data->image;
			echo json_encode($data);
			return false;
		}
	}

	public function match_details()
	{
		$data = array();
		$data['title'] = 'Match Details';
		$data['sports'] = $this->db->query("SELECT * FROM sportscategory")->result();
		$data['matches'] = $this->db->query("SELECT m.*, s.name FROM matchname AS m INNER JOIN sportscategory AS s ON m.sportscategory_id=s.id WHERE m.status IN(1,2) ORDER BY m.serial ASC")->result();
		$this->load->view('admin/liveinplay/match_details', $data);
	}

	public function match_history()
	{
		$data = array();
		$data['title'] = 'Match Details';
		$data['sports'] = $this->db->query("SELECT * FROM sportscategory")->result();
		$data['matches'] = $this->db->query("SELECT m.*, s.name FROM matchname AS m INNER JOIN sportscategory AS s ON m.sportscategory_id=s.id WHERE m.status IN(3,4) ORDER BY m.id DESC")->result();
		$this->load->view('admin/liveinplay/match_history', $data);
	}

	public function view_details()
	{
		$data = array();
		$data['title'] = 'View Details';
		$match_id = $this->uri->segment(3);
		$data['matchId'] = $match_id;
		$matchname = $this->db
                          ->select('title,icon1,icon2')
                          ->from('matchname')
                          ->where('id', $match_id)->get()->row(); 
		$data['match_name'] = $matchname->title;
		$data['icon1'] = $matchname->icon1;
		$data['icon2'] = $matchname->icon2;
		 
		$data['matches'] = $this->db->query("SELECT * FROM match_option WHERE match_id='{$match_id}' AND status!='3'")->result();  
		$this->load->view('admin/liveinplay/view_dt_new', $data);
	}

	public function view_details_end()
	{
		$data = array();
		$data['title'] = 'View Details';
		$match_id = $this->uri->segment(3);
		$data['matchId'] = $match_id;
		$matchname = $this->db
                          ->select('title,icon1,icon2')
                          ->from('matchname')
                          ->where('id', $match_id)->get()->row(); 
		$data['match_name'] = $matchname->title;
		$data['icon1'] = $matchname->icon1;
		$data['icon2'] = $matchname->icon2;
		 
		$data['matches'] = $this->db->query("SELECT * FROM match_option WHERE match_id='{$match_id}' AND status='3'")->result();  
		$this->load->view('admin/liveinplay/view_dt_new', $data);
	}

//	match bit coin
	public function matchbit_coin()
	{
		$data = array();
		$data['title'] = 'Match Bit Coin';
		$data['date_today'] = date('Y-m-d');
		$data['date_7days'] = date('Y-m-d', strtotime('-7 days')); 
		$this->load->view('admin/liveinplay/matchbit_coin', $data);
	}

	public function matchbit_coin_dt()
	{

		$status_post = $this->input->post('status');
		$date1 = $this->input->post('date1') == 'NaN-NaN-NaN' ? '' : $this->input->post('date1');
		$date2 = $this->input->post('date2') == 'NaN-NaN-NaN' ? '' : $this->input->post('date2');;
		$user = $this->input->post('user');
		$d1 = "";
		$u = "";
		if (!empty($date1) && empty($date2)) {
			$d1 = "AND mbc.created_at LIKE '$date1%' ";
		} else if (!empty($date1) && !empty($date2)) {
			$d1 = "AND mbc.created_at >= '" . $date1 . " 00:00:00' AND mbc.created_at <= '" . $date2 . " 23:59:59'";
		}
		if (!empty($user)) {
			$u = "AND username LIKE '$user%'";
		}

		if (!empty($status_post)) {
			$query = "SELECT mbc.*, mopd.option_title, mopd.match_id, mopd.match_option_id, mp.match_option_title, m.league_title, m.title, s.name FROM matchbit_coin AS mbc INNER JOIN match_option_details AS mopd ON mbc.match_bit_id=mopd.id INNER JOIN match_option AS mp ON mopd.match_option_id=mp.id INNER JOIN matchname AS m ON mopd.match_id=m.id INNER JOIN sportscategory AS s ON m.sportscategory_id=s.id WHERE mbc.bet_type = 'SINGLE_BET' AND mbc.bet_status IN('{$status_post}') $d1 $u";

			if (isset($_POST["search"]["value"])) {
				$query .= ' AND
				 (option_title LIKE "%' . $_POST["search"]["value"] . '%"
				 OR match_option_id LIKE "%' . $_POST["search"]["value"] . '%"
				 OR bet_status LIKE "%' . $_POST["search"]["value"] . '%"
				 OR league_title LIKE "%' . $_POST["search"]["value"] . '%"
				 OR username LIKE "%' . $_POST["search"]["value"] . '%")
				';
			}

			if (isset($_POST["order"])) {
				$columns = "";
				$query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
			} else {
				$query .= 'ORDER BY mbc.id DESC ';
			}
			if ($_POST["length"] != -1) {
				$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			} else {
				$query1 = "";
			}

			$number_filter_row = $this->db->query($query)->num_rows();
			$fetch_data = $this->db->query($query . $query1)->result();
			$data = array();
			$i = 1;
			foreach ($fetch_data as $row) {
				$sub_array = array();

				$club_dt = "
					<p style=\"width: 300px !important;text-align:justify;\"> 
						S: $row->name<br>
						L: $row->league_title<br>
						M: $row->title<br>
						Q: $row->match_option_title<br>
						A: $row->option_title
					</p>
			";
				 

				$action_btn = "<a onclick=\"return change_status_bet($row->id, '$row->username');\">Change Status</a>";

				$sub_array[] = $i;
				$sub_array[] = $row->username;
				$sub_array[] = $club_dt;
				$sub_array[] = $row->bet_coin;
				$sub_array[] = $row->option_coin;
				$sub_array[] = $row->total_coin;
				$sub_array[] = $row->prev_balance;
				$sub_array[] = $row->cur_balance;
				$sub_array[] = $row->created_at;
				$sub_array[] = bet_history_status_color($row->bet_status);
				$sub_array[] = $action_btn;
				$data[] = $sub_array;
				$i++;
			}

		 

			$recordsTotal = $this->db->query("SELECT mbc.*, mopd.option_title, mopd.match_id, mopd.match_option_id, mp.match_option_title, m.league_title, m.title, s.name FROM matchbit_coin AS mbc INNER JOIN match_option_details AS mopd ON mbc.match_bit_id=mopd.id INNER JOIN match_option AS mp ON mopd.match_option_id=mp.id INNER JOIN matchname AS m ON mopd.match_id=m.id INNER JOIN sportscategory AS s ON m.sportscategory_id=s.id WHERE mbc.bet_status IN('{$status_post}')  $d1 $u")->num_rows();
			$output = array(
				"draw" => intval($_POST["draw"]),
				"recordsTotal" => $recordsTotal,
				"recordsFiltered" => $number_filter_row,
				"data" => $data
				 
			);
			echo json_encode($output);
		} else {
			echo "No direct script access allowed";
		}
	}
 
	public function post_running_bet_rate()
	{
		$match_bet_id = $this->input->post("match_bet_id");
		$bet_rate = $this->input->post("bet_rate");
		$bet_rate_total = $this->input->post("bet_rate_total");

		if (!empty($match_bet_id) && !empty($bet_rate) && !empty($bet_rate_total)) {
			$this->db->query("UPDATE matchbit_coin SET option_coin='$bet_rate', total_coin='$bet_rate_total' WHERE id='$match_bet_id'");
			echo json_encode(array('st' => 200, 'msg' => 'Change Rate Successfully'));
		} else {
			echo json_encode(array('st' => 400, 'msg' => 'Empty value not acceptable'));
		}
	}

	public function post_running_bet_status()
	{
		$match_bet_id = $this->input->post("match_bet_id_st");
		$bet_status = $this->input->post("bet_status");

		if (!empty($match_bet_id) && !empty($bet_status)) {
            $this->db->query("UPDATE matchbit_coin SET bet_status='$bet_status' WHERE id='$match_bet_id'");
			if ($bet_status=="CANCEL_ADMIN"){
				$fetch_matchbet = $this->db->query("SELECT * FROM `matchbit_coin` WHERE id = '$match_bet_id'")->row();
				if ($fetch_matchbet->bet_type=="SINGLE_BET") {
					$str_row = 'single_bet_id';
				} else {
					$str_row = 'multi_bet_id';
				}

				if ($fetch_matchbet->user_coin_update=="Yes") {
					 
				} else {
					$get_cur_balance = @(get_user_current_balance($fetch_matchbet->user_id) + $fetch_matchbet->bet_coin);
					$data_arr2 = array(
						'user_id' => $fetch_matchbet->user_id,
						'club_id' => $fetch_matchbet->club_id,
						'coin' => $fetch_matchbet->bet_coin,
						'current_balance' => $get_cur_balance,
						'coin_type' => 'BETCANCEL',
						'method' => 'GET',
						'transfer_user_id' => 0,
						$str_row => $fetch_matchbet->id,
						'created_at' => date("Y-m-d H:i:s")
					);
					$this->db->insert('my_coin', $data_arr2);
				}
			}
			echo json_encode(array('st' => 200, 'msg' => 'Change status Successfully'));
		} else {
			echo json_encode(array('st' => 400, 'msg' => 'Empty value not acceptable'));
		}
	}


	public function post_create_match()
	{
		$data = array();

		if ($this->input->post('submit')) {
			$sports_name = $this->input->post('sports_name');
			$team_1 = $this->input->post('team_1');
			$icon1 = $this->input->post('icon1');
			$team_2 = $this->input->post('team_2');
			$icon2 = $this->input->post('icon2');
			$match_title = $team_1 . " VS " . $team_2;
			$league_title = $this->input->post('league_title');
			$match_status = $this->input->post('match_status');
			$match_serial = $this->input->post('match_serial');
			$active_status = $this->input->post('active_status');
			$notification = $this->input->post('notification');
			$match_time_local = $this->input->post('starting_time');
			$youtubeLinkCreate = $this->input->post('youtubeLinkCreate');
			$starting_time = date('Y-m-d H:i:s', strtotime($match_time_local));
			$score_1 = "0";
			$score_2 = "0";
			$red = 'match_details/';

			if (empty($sports_name) || empty($match_title) || empty($match_status) || empty($match_serial) || empty($active_status)) {
				$this->session->set_flashdata('error', 'All fields are required');
				redirect($red);
			}

			$data_arr = array(
				'sportscategory_id' => $sports_name,
				'team1' => $team_1,
				'icon1' => $icon1,
				'team2' => $team_2,
				'icon2' => $icon2,
				'league_title' => $league_title,
				'title' => $match_title,
				'active_status' => $match_status,
				'notification' => $notification,
				'serial' => $match_serial,
				'score_1' => $score_1,
				'score_2' => $score_2,
				'status' => $active_status,
				'created_at' => date("Y-m-d H:i:s"),
				'starting_time' => $starting_time,
				'match_time_local' => $match_time_local,
				'youtubeLInk' => $youtubeLinkCreate
			);
			$this->db->insert('matchname', $data_arr);
 

			$this->session->set_flashdata('msg', 'Match created successfully');
			redirect($red);
		}
	}

	public function post_edit_match()
	{
		$data = array();
		$id = $_POST['match_edit_id'];
		$get_show_in ="";

		if ($this->input->post('submit')) {
			$sports_name = $this->input->post('sports_name');
			$league_title = $this->input->post('league_title');
			$team_1 = $this->input->post('team_1');
			$team_2 = $this->input->post('team_2');
			$match_title = $team_1 . " VS " . $team_2;
			$match_status = $this->input->post('match_status');
			$match_serial = $this->input->post('match_serial');
			$active_status = $this->input->post('active_status');
			$notification = $this->input->post('notification');
			$youtubeLInk = $this->input->post('youtubeLInk');
			$score_1 = $this->input->post('score_1');
			$score_2 = $this->input->post('score_2');
			$match_time_local = $this->input->post('starting_time');
			$starting_time = date('Y-m-d H:i:s', strtotime($match_time_local));
			$red = 'match_details/';

			if (empty($sports_name) || empty($match_title) || empty($match_status) || empty($match_serial) || empty($active_status)) {
				$this->session->set_flashdata('error', 'All fields are required');
				redirect($red);
			}



			$data_arr = array(
				'sportscategory_id' => $sports_name,
				'team1' => $team_1,
				'team2' => $team_2,
				'league_title' => $league_title,
				'title' => $match_title,
				'active_status' => $match_status,
				'notification' => $notification,
				'serial' => $match_serial,
				'score_1' => $score_1,
				'score_2' => $score_2,
				'status' => $active_status,
				'updated_at' => date("Y-m-d H:i:s"),
				'starting_time' => $starting_time,
				'match_time_local' => $match_time_local,
				'youtubeLInk' => $youtubeLInk,
			);
			$this->db->where('id', $id);
			$this->db->update('matchname', $data_arr);



			if ($match_status==1) {
				$get_show_in = $this->db->query("SELECT score_show_in FROM matchname WHERE active_status=1 AND id ='{$id}'")->row()->score_show_in;    
 			}
  

			$this->session->set_flashdata('msg', 'Match updated successfully');
			redirect($red);
		}
	}

	public function view_team_for_flag()
	{
		$match_id = $_POST['match_id'];
		$data = $this->db->query("SELECT id,team1,icon1,team2,icon2 FROM matchname WHERE id='{$match_id}'")->row();
		echo json_encode($data);
	}

	public function add_match_flag()
	{
		$red = 'match_details/';
		$match_id = $_POST['match_matchname_id'];
		$team1_icon = $_POST['team1_icon'];
		$team2_icon = $_POST['team2_icon'];

		if (!empty($match_id) && !empty($team1_icon) && !empty($team2_icon)) {
			$this->db->query("UPDATE matchname SET icon1='$team1_icon', icon2='$team2_icon' WHERE id = '$match_id'");
			$this->session->set_flashdata('msg', 'Match status changed successfully');
			redirect($red);
		}

	}

// this one is form submit
	public function change_match_details_status()
	{

		$red = 'admin/match_details/';
		$this->db->query("UPDATE matchname SET status='{$_POST['match_status']}' WHERE id='{$_POST['match_id']}' LIMIT 1"); 

		$this->session->set_flashdata('msg', 'Update successfully');
		redirect($red);
	} 

	public function change_match_details_status_c()
	{

		$red = 'admin/match_details/';
		$this->db->query("UPDATE matchname SET status='{$this->uri->segment(3)}' WHERE id='{$this->uri->segment(4)}' LIMIT 1"); 
		$this->session->set_flashdata('msg', 'Update successfully');
		redirect($red);
	}

	public function change_bet_live_status()
	{

		$red = 'admin/match_details/';
		$this->db->query("UPDATE matchname SET isLive='{$this->uri->segment(3)}' WHERE id='{$this->uri->segment(4)}' LIMIT 1");

		$this->session->set_flashdata('msg', 'Updated bet live status');
		redirect($red);
	}

	public function change_bet_cancelable()
	{

		$red = 'admin/match_details/';
		$this->db->query("UPDATE matchname SET isBetCancelable='{$this->uri->segment(3)}' WHERE id='{$this->uri->segment(4)}' LIMIT 1");

		$this->session->set_flashdata('msg', 'User Bet Cancel Permission Update successfully');
		redirect($red);
	}

	public function change_user_status()
	{
		$red = 'customer_user/';
		$id = $this->uri->segment(3);
		$sts = $this->uri->segment(4);

		$this->db->query("UPDATE users SET status='{$sts}' WHERE id='{$id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'User status changed successfully');
		redirect($red);
	}

	public function post_create_club()
	{
		$data = array();

		if ($this->input->post('submit')) {
			$club_name = $this->input->post('club_name');
			$club_email = $this->input->post('club_email');
			$club_ratio = $this->input->post('club_ratio');
			$show_ratio = $this->input->post('show_ratio');
			$club_mobile = $this->input->post('club_mobile');
			$club_serial = $this->input->post('club_serial');
			$password = $this->input->post('password');
			$red = 'club_user/';

			if (empty($club_name) || empty($club_email) || empty($club_mobile) || empty($password)) {
				$this->session->set_flashdata('error', 'All fields are required');
				redirect($red);
			}

			// -- if club exists
			$x_club = $this->db->query("SELECT * FROM club_users WHERE club_name='{$club_name}' OR club_email='{$club_email}'");
			$x_club = $x_club->result();
			if (!empty($x_club)) {
				$this->session->set_flashdata('error', 'Sorry, This club already exists');
				redirect($red);
			}

			$data_arr = array(
				'club_name' => $club_name,
				'club_email' => $club_email,
				'club_ratio' => $club_ratio,
				'show_ratio' => $show_ratio,
				'club_mobile' => $club_mobile,
				'serial' => $club_serial,
				'password' => md5($password),
				'created_at' => date("Y-m-d H:i:s")
			);
			$this->db->insert('club_users', $data_arr);
			$this->session->set_flashdata('msg', 'Club created successfully');
			redirect($red);
		}
	}

	public function post_edit_club()
	{
		$data = array();

		if ($this->input->post('submit')) {
			$club_name = $this->input->post('club_name');
			$club_email = $this->input->post('club_email');
			$club_ratio = $this->input->post('club_ratio');
			$show_ratio = $this->input->post('show_ratio');
			$club_mobile = $this->input->post('club_mobile');
			$club_serial = $this->input->post('club_serial');
			$status = $this->input->post('status');
			$club_id = $this->input->post('club_id');
			$red = 'club_user/';
			// dd($_POST);

			if (empty($club_name) || empty($club_email) || empty($club_mobile)) {
				$this->session->set_flashdata('error', 'All fields are required');
				redirect($red);
			}

			// -- if club exists
			$prev_club = $this->db->query("SELECT * FROM club_users WHERE id='{$club_id}'")->row();

			if ($club_name != $prev_club->club_name) {
				$x_club = $this->db->query("SELECT * FROM club_users WHERE club_name='{$club_name}'");
				$x_club = $x_club->result();
				if (!empty($x_club)) {
					$this->session->set_flashdata('error', 'Sorry, This club already exists');
					redirect($red);
				}
			}

			if ($club_email != $prev_club->club_email) {
				$x_club = $this->db->query("SELECT * FROM club_users WHERE club_email='{$club_email}'");
				$x_club = $x_club->result();
				if (!empty($x_club)) {
					$this->session->set_flashdata('error', 'Sorry, This club already exists');
					redirect($red);
				}
			}

			$data_arr = array(
				'club_name' => $club_name,
				'club_email' => $club_email,
				'club_ratio' => $club_ratio,
				'show_ratio' => $show_ratio,
				'club_mobile' => $club_mobile,
				'serial' => $club_serial,
				'status' => $status,
				'updated_at' => date("Y-m-d H:i:s")
			);
			$this->db->where('id', $club_id);
			$this->db->update('club_users', $data_arr);
			$this->session->set_flashdata('msg', 'Club edited successfully');
			redirect($red);
		}
	}

	public function add_notice()
	{
		$data = array();
		$red = 'notice-panel';
		if ($this->input->post('submit')) {
			$description = $this->input->post('description');

			if (!empty($description)) {
				$data_arr = array(
					'description' => $description,
					'created_at' => date("Y-m-d H:i:s")
				);
				$this->db->insert('notice', $data_arr);
				$this->session->set_flashdata('msg', 'Notice created successfully');
				redirect($red);
			}
		}
	}

	public function notice_inactive_status()
	{
		$id = $this->uri->segment(3);
		$red = 'notice-panel';
		$this->db->query("UPDATE notice SET status=0 WHERE id='{$id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'Notice status changed successfully');
		redirect($red);
	}

	public function notice_active_status()
	{
		$id = $this->uri->segment(3);
		$red = 'notice-panel';
		$this->db->query("UPDATE notice SET status=1 WHERE id='{$id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'Notice status changed successfully');
		redirect($red);
	}

	public function remove_notice()
	{
		$id = $this->uri->segment(3);
		$red = 'notice-panel';
		$this->db->query("DELETE FROM notice WHERE id='{$id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'Notice deleted successfully');
		redirect($red);
	}

	public function edit_notice()
	{
		$data = array();
		$red = 'notice-panel';
		if ($this->input->post('submit')) {
			$description = $this->input->post('description');
			$notice_id = $this->input->post('notice_id');

			if (!empty($description) && !empty($notice_id)) {
				$data_arr = array(
					'description' => $description,
					'created_at' => date("Y-m-d H:i:s")
				);
				$this->db->where('id', $notice_id);
				$this->db->update('notice', $data_arr);
				$this->session->set_flashdata('msg', 'Notice edited successfully');
				redirect($red);
			}
		}
	}

	public function club_user_change_password()
	{
		$data = array();

		if ($this->input->post('submit')) {
			$password = $this->input->post('password');
			$club_id = $this->input->post('hidden_club_id');
			$red = 'club_user/';
			// dd($_POST);

			if (empty($password) || empty($club_id)) {
				$this->session->set_flashdata('error', 'All fields are required');
				redirect($red);
			}

			$data_arr = array(
				'password' => md5($password),
				'updated_at' => date("Y-m-d H:i:s")
			);
			$this->db->where('id', $club_id);
			$this->db->update('club_users', $data_arr);
			$this->session->set_flashdata('msg', 'Password changed successfully');
			redirect($red);
		}
	}

	public function change_match_status()
	{ 
		$match_status_id = $this->uri->segment(4);
		$ch_match_status = $this->uri->segment(3);

		$red = 'admin/match_details/';
		if (!empty($match_status_id) && !empty($ch_match_status)) {
			$this->db->query("UPDATE matchname SET active_status='{$ch_match_status}' WHERE id='{$match_status_id}' LIMIT 1");   
		 
		 $this->session->set_flashdata('msg', 'Match status changed successfully');
		}
		redirect($red);
	}

	public function option_inactive()
	{
		$red = $_SERVER['HTTP_REFERER'];
		$id = $this->uri->segment(3);
		$this->db->query("UPDATE match_option SET status=0 WHERE id='{$id}' LIMIT 1");
 
		$this->session->set_flashdata('msg', 'Bet hide successfully');
		redirect($red);
	}

	public function option_active()
	{
		$red = $_SERVER['HTTP_REFERER'];
		$id = $this->uri->segment(3);
		$this->db->query("UPDATE match_option SET status=1 WHERE id='{$id}' LIMIT 1");
		  
 
		
		$this->session->set_flashdata('msg', 'Bet active successfully');
		redirect($red);
	}

	public function remove_match()
	{
		$id = $this->uri->segment(2);
		$red = 'admin/match_details/';
		$this->db->query("DELETE FROM matchname WHERE id='{$id}' LIMIT 1");
		 
	 

		$this->session->set_flashdata('msg', 'Match deleted successfully');
		redirect($red);
	}

	public function edit_match_bet_name()
	{
		$red = $_SERVER['HTTP_REFERER'];
		$mo_id = $_POST['hidden_match_bet_id'];
		$this->db->query("UPDATE match_option SET
			match_option_title='{$_POST['match_option_title']}',
			match_option_serial='{$_POST['match_option_serial']}'
			WHERE id='{$_POST['hidden_match_bet_id']}' LIMIT 1");
		 
	 
		$this->session->set_flashdata('msg', 'Bet name changed successfully');
		redirect($red);
	}

	public function edit_option_coin()
	{
		$red = $_SERVER['HTTP_REFERER'];
		$mod_id = $_POST['hidden_match_coin'];
		$this->db->query("UPDATE match_option_details SET option_coin='{$_POST['option_coin']}' WHERE id='{$mod_id}'");
		$this->session->set_flashdata('msg', 'Coin updated successfully');
		redirect($red);
	}

	public function edit_option_coin_new()
	{ 
		$mod_id = $_POST['hidden_match_coin']; 
		$this->db->query("UPDATE match_option_details SET option_coin='{$_POST['option_coin']}' WHERE id='{$mod_id}'");
				 
		$res = [
			'st' => 200,
			'msg' => 'Coin updated successfully'
		];
		echo json_encode($res);
	}

	public function edit_multi_option_coin_new()
	{ 
		$mod_id = $_POST['hidden_match_coin']; 
		$this->db->query("UPDATE match_option_details SET multi_option_coin='{$_POST['multi_option_coin']}' WHERE id='{$mod_id}'");
				 
		$res = [
			'st' => 200,
			'msg' => 'Multi Coin updated successfully'
		];
		echo json_encode($res);
	}

	public function edit_limit_option_coin_new()
	{ 
		$mod_id = $_POST['hidden_match_coin']; 
		$this->db->query("UPDATE match_option_details SET limit_option_coin='{$_POST['limit_option_coin']}' WHERE id='{$mod_id}'");
				 
		$res = [
			'st' => 200,
			'msg' => 'Coin Limit updated successfully'
		];
		echo json_encode($res);
	}

	public function status_change_option_coin()
	{
		$red = 'match_details/view/' . $this->uri->segment(5);
		$this->db->query("UPDATE match_option_details SET status='{$this->uri->segment(4)}' WHERE id='{$this->uri->segment(3)}' LIMIT 1");
		
		// trigger_pusher('bet_option_ch','bet_option_ev');

		$this->session->set_flashdata('msg', 'Option status updated successfully');
		redirect($red);
	}

	public function bet_show_hide_right_side()
	{
		$red = 'match_details/view/' . $this->uri->segment(5);
		$this->db->query("UPDATE match_option SET is_score_show='{$this->uri->segment(4)}' WHERE id='{$this->uri->segment(3)}' LIMIT 1"); 
 	 
		$this->session->set_flashdata('msg', 'Option status updated successfully');
		redirect($red);
	}

	public function edit_option_title()
	{
		$red = $_SERVER['HTTP_REFERER'];
		$mod_id = $_POST['hidden_option_title'];
		$this->db->query("UPDATE match_option_details SET
			option_title='{$_POST['option_title']}',
			option_serial='{$_POST['option_serial']}'
			WHERE id='{$_POST['hidden_option_title']}' LIMIT 1");
			
			 


		$this->session->set_flashdata('msg', 'Title updated successfully');
		redirect($red);
	}

	public function create_match_option()
	{
		$data = array();

		if ($this->input->post('submit')) {
			$match_option_name = $this->input->post('match_option_name');
			$red = 'match_details/';

			if (empty($match_option_name)) {
				$this->session->set_flashdata('error', 'All fields are required');
				redirect($red);
			}

			$data_arr = array(
				'match_id' => $_POST['match_option_id'],
				'match_option_title' => $match_option_name,
				'match_option_serial' => $_POST['match_option_serial'],
				'created_at' => date('Y-m-d H:i:s')
			);
			$this->db->insert('match_option', $data_arr);
			$last_id = $this->db->insert_id();

			for ($i = 0; $i < count($_POST['first_option_title']); $i++) {
				$data_arr = array(
					'match_id' => $_POST['match_option_id'],
					'match_option_id' => $last_id,
					'option_title' => $_POST['first_option_title'][$i],
					'option_coin' => $_POST['first_option_coin'][$i],
					'option_serial' => $_POST['first_option_serial'][$i],
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->db->insert('match_option_details', $data_arr);
			}

			 

			$this->session->set_flashdata('msg', 'Match option created successfully');
			redirect($red);
		}
	}

	public function create_match_option_viewpage()
	{
		$data = array();

		if ($this->input->post('submit')) {
			$match_option_name = $this->input->post('match_option_name'); // question name
			$red = 'match_details/view/' . $_POST['match_option_id'];

			if (empty($match_option_name)) {
				$this->session->set_flashdata('error', 'All fields are required');
				redirect($red);
			}

			$data_arr = array(
				'match_id' => $_POST['match_option_id'],
				'match_option_title' => $match_option_name,
				'match_option_serial' => $_POST['match_option_serial'],
				'status' => $_POST['status'],
				'created_at' => date('Y-m-d H:i:s')
			);
			$this->db->insert('match_option', $data_arr);
			$last_id = $this->db->insert_id();

			for ($i = 0; $i < count($_POST['first_option_title']); $i++) {
				$data_arr = array(
					'match_id' => $_POST['match_option_id'],
					'match_option_id' => $last_id,
					'option_title' => $_POST['first_option_title'][$i],
					'option_coin' => $_POST['first_option_coin'][$i],
					'multi_option_coin' => $_POST['first_multi_option_coin'][$i],
					'option_serial' => $_POST['first_option_serial'][$i],
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->db->insert('match_option_details', $data_arr);
			}
 			
 			 

			$this->session->set_flashdata('msg', 'Match option created successfully');
			redirect($red);
		}
	}

	public function create_new_option_foroldmatch()
	{
		$data = array();

		if ($this->input->post('submit')) {
			$match_id = $this->input->post('add_hdn_match_id');
			$match_option_id = $this->input->post('add_hdn_match_op_id');
			$red = 'match_details/view/' . $match_id;

			if (empty($match_id) && empty($match_option_id)) {
				$this->session->set_flashdata('error', 'All fields are required');
				redirect($red);
			}

			for ($i = 0; $i < count($_POST['first_option_title']); $i++) {
				$data_arr = array(
					'match_id' => $match_id,
					'match_option_id' => $match_option_id,
					'option_title' => $_POST['first_option_title'][$i],
					'option_coin' => $_POST['first_option_coin'][$i],
					'multi_option_coin' => $_POST['first_multi_option_coin'][$i],
					'option_serial' => $_POST['first_option_serial'][$i],
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->db->insert('match_option_details', $data_arr);
			}

		 
			
			$this->session->set_flashdata('msg', 'Match new option created successfully');
			redirect($red);
		}
	}

	public function edit_match_data()
	{
		$match_id = $_POST['match_id'];
		$data = $this->db->query("SELECT * FROM matchname WHERE id='{$match_id}'")->row();

		echo json_encode($data);
	}

	public function view_match_data()
	{
		$match_id = $_POST['match_id'];
		$match_data = $this->db->query("SELECT * FROM match_option WHERE match_id='{$match_id}'")->result();

		?>
		<table class="table table-bordered">
			<tr>
				<th>Match Bet Name</th>
				<th>Serial</th>
				<th>Status</th>
				<th>Created</th>
				<th>Action</th>
			</tr>

			<?php foreach ($match_data as $val) : ?>
				<tr>
					<td><?php echo $val->match_option_title; ?></td>
					<td><?php echo $val->match_option_serial; ?></td>
					<td><?php echo $val->status; ?></td>
					<td><?php echo $val->created_at; ?></td>
					<td></td>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php
	}


// customer deposit function
	public function customer_deposit()
	{
		$data = array();
		$data['title'] = 'Customer Deposit';
		 
		$this->load->view('admin/customer/customer_deposit', $data);
	}

	public function customer_deposit_dt()
	{

		$status_post = $this->input->post('status');
		$query = "SELECT d.*, c.club_name, u.username FROM `deposit` AS d INNER JOIN club_users AS c ON d.club_user_id=c.id INNER JOIN users AS u ON d.user_id=u.id WHERE d.amount NOT IN(0) AND d.status IN('{$status_post}')";

		if (isset($_POST["search"]["value"])) {
			$query .= ' AND
			 (username LIKE "%' . $_POST["search"]["value"] . '%"
			 OR club_name LIKE "%' . $_POST["search"]["value"] . '%"
			 OR transaction_id LIKE "%' . $_POST["search"]["value"] . '%"
			 OR user_phone LIKE "%' . $_POST["search"]["value"] . '%"
			 OR admin_account LIKE "%' . $_POST["search"]["value"] . '%")
			';
		}

		if (isset($_POST["order"])) {
			$columns = "";
			$query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$query .= 'ORDER BY id DESC ';
		}
		if ($_POST["length"] != -1) {
			$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		} else {
			$query1 = "";
		}

		$number_filter_row = $this->db->query($query)->num_rows();
		$fetch_data = $this->db->query($query . $query1)->result();
		$data = array();
		$i = 1;
		foreach ($fetch_data as $row) {
			$sub_array = array(); 
			if ($row->status == "PENDING") {
				$act_sts = $row->status == 'PENDING' ? 'SUCCESS' : '';
			} else {
				$act_sts = $row->status == 'SUCCESS' ? 'CANCEL' : 'SUCCESS';
			}
			 
			$action_btn = "<a class=\"deposit-status-modal\" title=\"Edit Deposit\" onclick=\"return approve_diposit($row->id,$row->coin,$row->amount,'$act_sts');\" ><i style=\"color:#20c997\" class=\"fa fa-check-square-o icon-edit\"></i></a>";
			  
			 
				 	$sub_array[] = $i;
					$sub_array[] = $row->username;
					$sub_array[] = $row->club_name;
					$sub_array[] = $row->created_at;
					$sub_array[] = $row->amount;
					$sub_array[] = $row->coin_rate;
					$sub_array[] = $row->coin;
					$sub_array[] = $row->payment_method;
					$sub_array[] = $row->transaction_id;
					$sub_array[] = $row->user_phone;
					$sub_array[] = $row->admin_account;
					$sub_array[] = status_bg_color($row->status); 
					$sub_array[] = $action_btn;
					$data[] = $sub_array;
 

			
			$i++;
		}
		$recordsTotal = $this->db->query("SELECT d.*, c.club_name, u.username  FROM `deposit` AS d INNER JOIN club_users AS c ON d.club_user_id=c.id INNER JOIN users AS u ON d.user_id=u.id WHERE d.status IN('{$status_post}')")->num_rows();
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $number_filter_row,
			"data" => $data
		);
		echo json_encode($output);
	}

	public function approve_deposit()
	{ 
		$red = 'customer_deposit';
		if ($this->input->post('submit')) {
			$status = $this->input->post('status');
			$deposit_id = $this->input->post('deposit_id');
			$coin = $this->input->post('coin');
			$dpcoin = $this->input->post('dpcoin');
			if (!empty($status) && !empty($deposit_id)) {
				if ($status == 'SUCCESS') { 

					if (empty($coin)) {
						$this->session->set_flashdata('error', 'Coin is required');
						redirect($red);
					}

					$deposit_data = $this->db->query("SELECT * FROM deposit WHERE id='{$deposit_id}'")->row();
					$user_id = $deposit_data->user_id;
					$club_id = $deposit_data->club_user_id;
					$current_balance = get_user_current_balance($user_id);
					$current_balance = $current_balance + $coin;

					$data_arr = array(
						'user_id' => $user_id,
						'club_id' => $club_id,
						'coin' => $coin,
						'current_balance' => $current_balance,
						'coin_type' => 'DEPOSIT',
						'method' => 'GET',
						'created_at' => date('Y-m-d H:i:s')
					);
					$this->db->insert('my_coin', $data_arr);
				}
				if ($status == 'CANCEL') { 

					if (empty($coin)) {
						$this->session->set_flashdata('error', 'Cancel Coin is required');
						redirect($red);
					}

					$deposit_data = $this->db->query("SELECT * FROM deposit WHERE id='{$deposit_id}'")->row();
					$user_id = $deposit_data->user_id;
					$club_id = $deposit_data->club_user_id;
					$db_status = $deposit_data->status;
					$current_balance = get_user_current_balance($user_id);
					if ($db_status != "PENDING") {
						$current_balance = $current_balance - $coin;
						$data_arr = array(
							'user_id' => $user_id,
							'club_id' => $club_id,
							'coin' => $coin,
							'current_balance' => $current_balance,
							'coin_type' => 'DEPOSIT_CANCEL',
							'method' => 'POST',
							'created_at' => date('Y-m-d H:i:s')
						);
						$this->db->insert('my_coin', $data_arr);
					}
				}

				$data_arr2 = array(
					'status' => $status,
					'amount' => $dpcoin,
					'coin' => $coin,
					'updated_at' => date("Y-m-d H:i:s")
				);
				$this->db->where('id', $deposit_id);
				$this->db->update('deposit', $data_arr2); 
			 
			    redirect($red);
				return;

			}
		}
	}


// customer withdraw function
	public function customer_withdraw()
	{
		$data = array();
		$data['title'] = 'Customer Withdraw';
		$this->load->view('admin/customer/customer_withdraw', $data);
	}

	public function customer_withdraw_dt()
	{

		$status_post = $this->input->post('status');
		$query = "SELECT w.*, u.username, c.club_name FROM withdraw_req AS w INNER JOIN users AS u ON w.user_id=u.id INNER JOIN club_users AS c ON w.club_user_id=c.id AND w.status IN('{$status_post}')";

		if (isset($_POST["search"]["value"])) {
			$query .= ' AND
			 (username LIKE "%' . $_POST["search"]["value"] . '%"
			 OR club_name LIKE "%' . $_POST["search"]["value"] . '%"
			 OR account_number LIKE "%' . $_POST["search"]["value"] . '%"
			 OR from_no LIKE "%' . $_POST["search"]["value"] . '%")
			';
		}

		if (isset($_POST["order"])) {
			$columns = "";
			$query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$query .= 'ORDER BY id DESC ';
		}
		if ($_POST["length"] != -1) {
			$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		} else {
			$query1 = "";
		}

		$number_filter_row = $this->db->query($query)->num_rows();
		$fetch_data = $this->db->query($query . $query1)->result();
		$data = array();
		$i = 1;
		foreach ($fetch_data as $row) {
			$sub_array = array();
			if ($row->status == "PENDING") {
				$act_sts = $row->status == 'PENDING' ? 'SUCCESS' : '';
			} else {
				$act_sts = $row->status == 'SUCCESS' ? 'CANCEL' : 'SUCCESS';
			}
			$action_btn = "<a class=\"deposit-status-modal\" title=\"Edit\" onclick=\"return approve_withdraw($row->id,$row->amount,'$act_sts');\" ><i style=\"color:#20c997\" class=\"fa fa-check-square-o icon-edit\"></i></a>"; 
			$sub_array[] = $i;
			$sub_array[] = $row->username;
			$sub_array[] = $row->club_name;
			$sub_array[] = $row->created_at;
			$sub_array[] = $row->amount;
			$sub_array[] = $row->payment_method;
			$sub_array[] = $row->payment_type;
			$sub_array[] = $row->account_number;
			$sub_array[] = $row->from_no;
			$sub_array[] = status_bg_color($row->status);
			$sub_array[] = $action_btn;
			$data[] = $sub_array;
			$i++;
		}
		$recordsTotal = $this->db->query("SELECT w.*, u.name, c.club_name FROM withdraw_req AS w INNER JOIN users AS u ON w.user_id=u.id INNER JOIN club_users AS c ON w.club_user_id=c.id AND w.status IN('{$status_post}')")->num_rows();
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $number_filter_row,
			"data" => $data
		);
		echo json_encode($output);
	}

	public function approve_withdraw()
	{
	    $red = 'customer_withdraw';
		if ($this->input->post('submit')) {
		    
			$status = $this->input->post('status');
			$refund_coin = $this->input->post('refund_coin');
			$withdraw_id = $this->input->post('withdraw_id');
			if (!empty($status) && !empty($withdraw_id)) {
				$from_no = $this->input->post('from_no');

				$deposit_data = $this->db->query("SELECT * FROM withdraw_req WHERE id='{$withdraw_id}'")->row();
				$user_id = $deposit_data->user_id;
				$club_id = $deposit_data->club_user_id;
				$db_status = $deposit_data->status;
				$amount = $deposit_data->amount;
				$current_balance = get_user_current_balance($user_id);

				if ($db_status == "SUCCESS") {
					if ($status == "CANCEL") {
						$current_balance = $current_balance + $amount;
						$data_arr = array(
							'user_id' => $user_id,
							'club_id' => $club_id,
							'coin' => $amount,
							'current_balance' => $current_balance,
							'coin_type' => 'WITHDRAW_CANCEL',
							'method' => 'GET',
							'created_at' => date('Y-m-d H:i:s')
						);
						$this->db->insert('my_coin', $data_arr);
					}
				}
				if ($db_status == "CANCEL") {
					if ($status == "SUCCESS") {
						$current_balance = $current_balance - $amount;
						$data_arr = array(
							'user_id' => $user_id,
							'club_id' => $club_id,
							'coin' => $amount,
							'current_balance' => $current_balance,
							'coin_type' => 'WITHDRAW',
							'method' => 'POST',
							'created_at' => date('Y-m-d H:i:s')
						);
						$this->db->insert('my_coin', $data_arr);
					}
				}
				if ($db_status == "PENDING") {
					if ($status == "CANCEL") {
						$current_balance = $current_balance + $amount;
						$data_arr = array(
							'user_id' => $user_id,
							'club_id' => $club_id,
							'coin' => $amount,
							'current_balance' => $current_balance,
							'coin_type' => 'WITHDRAW_CANCEL',
							'method' => 'GET',
							'created_at' => date('Y-m-d H:i:s')
						);
						$this->db->insert('my_coin', $data_arr);
					}
				}

				$data_arr2 = array(
					'status' => $status,
					'from_no' => $from_no,
					'updated_at' => date("Y-m-d H:i:s")
				);

				
				if($status=='SUCCESS' && $refund_coin>0) {

					$current_balance = $current_balance + $refund_coin;
					$data_arr = array(
						'user_id' => $user_id,
						'club_id' => $club_id,
						'coin' => $refund_coin,
						'current_balance' => $current_balance,
						'coin_type' => 'WITHDRAW',
						'method' => 'GET',
						'created_at' => date('Y-m-d H:i:s')
					);
					$this->db->insert('my_coin', $data_arr);
					
					$amount = $amount - $refund_coin;
    				$data_arr2 = array(
    					'status' => $status,
    					'amount' => $amount,
    					'from_no' => $from_no,
    					'updated_at' => date("Y-m-d H:i:s")
    				);

				}

				$this->db->where('id', $withdraw_id);
				$this->db->update('withdraw_req', $data_arr2);
				redirect($red); 
				return;
			}
		}
	}
 


// club withdraw function
	public function club_withdraw()
	{
		$data = array();
		$data['title'] = 'Club Withdraw'; 
		$this->load->view('admin/customer/club_withdraw', $data);
	}

	public function club_withdraw_dt()
	{
		$status_post = $this->input->post('status');
		$query = "SELECT cw.*, c.club_name FROM club_withdraw_req AS cw INNER JOIN club_users AS c ON cw.club_user_id=c.id AND cw.status IN('{$status_post}')";

		if (isset($_POST["search"]["value"])) {
			$query .= ' AND
			 (club_name LIKE "%' . $_POST["search"]["value"] . '%"
			 OR account_number LIKE "%' . $_POST["search"]["value"] . '%"
			 OR from_no LIKE "%' . $_POST["search"]["value"] . '%")
			';
		}

		if (isset($_POST["order"])) {
			$columns = "";
			$query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$query .= 'ORDER BY id DESC ';
		}
		if ($_POST["length"] != -1) {
			$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		} else {
			$query1 = "";
		}

		$number_filter_row = $this->db->query($query)->num_rows();
		$fetch_data = $this->db->query($query . $query1)->result();
		$data = array();
		$i = 1;
		foreach ($fetch_data as $row) {
			$sub_array = array();
			if ($row->status == "PENDING") {
				$act_sts = $row->status == 'PENDING' ? 'SUCCESS' : '';
			} else {
				$act_sts = $row->status == 'SUCCESS' ? 'CANCEL' : 'SUCCESS';
			}
			$action_btn = "<a class=\"deposit-status-modal\" title=\"Edit\" onclick=\"return approve_withdraw($row->id,$row->amount,'$act_sts');\" ><i style=\"color:#20c997\" class=\"fa fa-check-square-o icon-edit\"></i></a>";
			$remove_btn = "<a onclick=\"return del_withdraw($row->id);\" title=\"Delete\" ><i class=\"fa fa-times icon-delete\"></i></a>";
			$sub_array[] = $i;
			$sub_array[] = $row->club_name;
			$sub_array[] = $row->created_at;
			$sub_array[] = $row->account_number;
			$sub_array[] = $row->amount;
			$sub_array[] = $row->payment_method;
			$sub_array[] = $row->payment_type;
			$sub_array[] = $row->from_no;
			$sub_array[] = status_bg_color($row->status);
			$sub_array[] = $action_btn . "&nbsp;&nbsp;" . $remove_btn;
			$data[] = $sub_array;
			$i++;
		}
		$recordsTotal = $this->db->query("SELECT cw.*, c.club_name FROM club_withdraw_req AS cw INNER JOIN club_users AS c ON cw.club_user_id=c.id AND cw.status IN('{$status_post}')")->num_rows();
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $number_filter_row,
			"data" => $data
		);
		echo json_encode($output);
	}

	public function approve_club_withdraw()
	{
		if ($this->input->post('submit')) {
			$status = $this->input->post('status');
			$withdraw_id = $this->input->post('withdraw_id');
			if (!empty($status) && !empty($withdraw_id)) {
				$from_no = $this->input->post('from_no');
				$deposit_data = $this->db->query("SELECT * FROM club_withdraw_req WHERE id='{$withdraw_id}'")->row();
				$club_id = $deposit_data->club_user_id;
				$db_status = $deposit_data->status;
				$amount = $deposit_data->amount;
				$current_balance = get_club_current_balance($club_id);

				if ($db_status == "SUCCESS") {
					if ($status == "CANCEL") {
						$current_balance = $current_balance + $amount;
						$data_arr = array(
							'club_id' => $club_id,
							'coin' => $amount,
							'current_balance' => $current_balance,
							'source' => 'WITHDRAW_CANCEL',
							'method' => 'GET',
							'created_at' => date('Y-m-d H:i:s')
						);
						$this->db->insert('club_coin', $data_arr);
					}
				}
				if ($db_status == "CANCEL") {
					if ($status == "SUCCESS") {
						$current_balance = $current_balance - $amount;
						$data_arr = array(
							'club_id' => $club_id,
							'coin' => $amount,
							'current_balance' => $current_balance,
							'source' => 'WITHDRAW',
							'method' => 'POST',
							'created_at' => date('Y-m-d H:i:s')
						);
						$this->db->insert('club_coin', $data_arr);
					}
				}
				if ($db_status == "PENDING") {
					if ($status == "CANCEL") {
						$current_balance = $current_balance + $amount;
						$data_arr = array(
							'club_id' => $club_id,
							'coin' => $amount,
							'current_balance' => $current_balance,
							'source' => 'WITHDRAW_CANCEL',
							'method' => 'GET',
							'created_at' => date('Y-m-d H:i:s')
						);
						$this->db->insert('club_coin', $data_arr);
					}
				}

				$data_arr2 = array(
					'status' => $status,
					'from_no' => $from_no,
					'updated_at' => date("Y-m-d H:i:s")
				);
				$this->db->where('id', $withdraw_id);
				$this->db->update('club_withdraw_req', $data_arr2);
				echo json_encode(array('st' => 200, 'msg' => 'Club Withdraw status updated'));
				return;
			}
		}
	}

 


//	others function
	public function customer_complain()
	{
		$data = array();
		$data['title'] = 'Customer Complain'; 
		$this->load->view('admin/customer/customer_complain', $data);
	}

	public function customer_complain_dt()
	{
		if ($this->input->post('all')) {
			$query = "SELECT c.*, u.username FROM complain AS c INNER JOIN users AS u ON c.user_id=u.id WHERE c.reply IS NOT NULL";
		} else {
			$query = "SELECT c.*, u.username FROM complain AS c INNER JOIN users AS u ON c.user_id=u.id WHERE c.reply IS NULL ";
		}

		if (isset($_POST["search"]["value"])) {
			$query .= ' AND
			 (username LIKE "%' . $_POST["search"]["value"] . '%")
			';
		}

		if (isset($_POST["order"])) {
			$columns = "";
			$query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$query .= 'ORDER BY id DESC ';
		}
		if ($_POST["length"] != -1) {
			$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		} else {
			$query1 = "";
		}

		$number_filter_row = $this->db->query($query)->num_rows();
		$fetch_data = $this->db->query($query . $query1)->result();
		$data = array();
		$i = 1;
		foreach ($fetch_data as $row) {

			$sub_array = array();
			$del_link  = base_url('remove_complain/' . $row->id);
			$str_msg   = trim(preg_replace('/\s\s+/', ' ', $row->message));
			$edit_btn  = "<a onclick=\"return relpyAns($row->id,'$row->username','$str_msg');\" title=\"Reply to this Complain\"><i style=\"color:green\" class=\"fa fa-check-square-o icon-edit\"></i></a>";
			$del_btn   = "<a onclick=\"return confirm('Are you sure to remove this complain?');\" title=\"Delete Withdraw\" href=\"$del_link\"><i class=\"fa fa-times icon-delete\"></i></a>";
			$sub_array[] = $i;
			$sub_array[] = $row->username;
			$sub_array[] = $row->complain_to;
			$sub_array[] = $row->subject;
			$sub_array[] = $row->message;
			$sub_array[] = $row->reply;
			$sub_array[] = $row->created_at;
			$sub_array[] = $edit_btn . " &nbsp; " . $del_btn;
			$data[] = $sub_array;
			$i++;
		}
		$recordsTotal = $this->db->query("SELECT c.*, u.username FROM complain AS c INNER JOIN users AS u ON c.user_id=u.id")->num_rows();
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $number_filter_row,
			"data" => $data
		);
		echo json_encode($output);
	}

	public function reply_complain()
	{
		$red = 'complain_history';
		if ($this->input->post('submit')) {
			$reply = $this->input->post('reply');
			$complain_id = $this->input->post('complain_id');
			if (!empty($reply) && !empty($complain_id)) {

				$data_arr2 = array(
					'reply' => $reply,
					'updated_at' => date("Y-m-d H:i:s")
				);
				$this->db->where('id', $complain_id);
				$this->db->update('complain', $data_arr2);
				$this->session->set_flashdata('msg', 'Reply message sent to user successfully');
				redirect($red);
				return;

			}
		}
	}

	public function remove_complain()
	{
		$id = $this->uri->segment(2);
		$red = 'complain_history/';

		$res = $this->db->query("DELETE FROM complain WHERE id='{$id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'Complain deleted successfully');
		redirect($red);
	}


//	customer balance transfer function
	public function customer_balance_transfer()
	{
		$data = array();
		$data['title'] = 'Customer Balance Transfer';
		$this->load->view('admin/customer/customer_balance_transfer', $data);
	}

	public function customer_balance_transfer_dt()
	{

		$query = "SELECT * FROM balance_transfer";

		if (isset($_POST["search"]["value"])) {
			$query .= ' WHERE
			 (transfer_to_name LIKE "%' . $_POST["search"]["value"] . '%"
			 OR transfer_by_name LIKE "%' . $_POST["search"]["value"] . '%"
			 OR created_at LIKE "%' . $_POST["search"]["value"] . '%"
			 OR amount LIKE "%' . $_POST["search"]["value"] . '%")
			';
		}

		if (isset($_POST["order"])) {
			$columns = "";
			$query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$query .= 'ORDER BY id DESC ';
		}
		if ($_POST["length"] != -1) {
			$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		} else {
			$query1 = "";
		}

		$number_filter_row = $this->db->query($query)->num_rows();
		$fetch_data = $this->db->query($query . $query1)->result();
		$data = array();
		$i = 1;
		foreach ($fetch_data as $row) {
			$sub_array = array();

			$sub_array[] = $i;
			$sub_array[] = $row->transfer_to_name;
			$sub_array[] = $row->amount;
			$sub_array[] = $row->transfer_by_name;
			$sub_array[] = $row->created_at;
			$data[] = $sub_array;
			$i++;
		}
		$recordsTotal = $this->db->query("SELECT * FROM balance_transfer")->num_rows();
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $number_filter_row,
			"data" => $data
		);
		echo json_encode($output);
	}


	// user panel data
	public function club_user()
	{
		$data = array();
		$data['title'] = 'Club User';
		$data['club_data'] = $this->db->query("SELECT * FROM club_users ORDER BY id DESC")->result();
		$this->load->view('admin/user/club_user', $data);
	}

	public function admin_user()
	{
		$data = array();
		$data['title'] = 'Customer User';
		$data['role_data'] = $this->db->query("SELECT * FROM role_management WHERE id!=1")->result();
		$data['admin_data'] = $this->db->query("SELECT * FROM admin ORDER BY id DESC LIMIT 20")->result();
		$this->load->view('admin/user/admin_user', $data);
	}

	public function remove_admin()
	{
		$id = $this->uri->segment(3);
		$red = 'admin_user/';

		$res = $this->db->query("DELETE FROM admin WHERE id='{$id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'Admin user deleted successfully');
		redirect($red);
	}

	public function remove_admin_role()
	{
		$id = $this->uri->segment(3);
		$red = 'manage_role/';

		$res = $this->db->query("DELETE FROM role_management WHERE id='{$id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'Admin role deleted successfully');
		redirect($red);
	}

	public function manage_role()
	{
		$data = array();
		$data['title'] = 'Admin Role';
		$data['roles'] = $this->db->query("SELECT * FROM role_data")->result();
		// dd($data['roles']);
		$data['role_data'] = $this->db->query("SELECT * FROM role_management ORDER BY id DESC LIMIT 20")->result();
		$this->load->view('admin/user/manage_role', $data);
	}

	public function notice_panel()
	{
		$data = array();
		$data['title'] = 'Notice Panel';
		$data['get_data'] = $this->db->query("SELECT * FROM notice")->result();
		$this->load->view('admin/notice_panel', $data);
	}


//	deposit account

	public function deposit_account()
	{
		$data = [];
		$data['title'] = 'Deposit Account';
		$data['get_data'] = $this->db->query("SELECT * FROM deposit_account WHERE status IN(0,1)")->result();
		$this->load->view('admin/deposit_account', $data);
	}

	public function add_deposit_account()
	{
		$data = array();
		$red = 'deposit_account';
		if ($this->input->post('submit')) {
			$account_name = $this->input->post('account_name');
			$account_no = $this->input->post('account_no');

			if (!empty($account_name) && !empty($account_no)) {
				$data_arr = array(
					'account_name' => $account_name,
					'account_no' => $account_no,
					'created_at' => date("Y-m-d H:i:s")
				);
				$this->db->insert('deposit_account', $data_arr);
				$this->session->set_flashdata('msg', 'Account created successfully');
				redirect($red);
			}
		}
	}

	public function account_inactive_status()
	{
		$id = $this->uri->segment(3);
		$red = 'deposit_account';
		$this->db->query("UPDATE deposit_account SET status=0 WHERE id='{$id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'Account status changed successfully');
		redirect($red);
	}

	public function account_active_status()
	{
		$id = $this->uri->segment(3);
		$red = 'deposit_account';
		$this->db->query("UPDATE deposit_account SET status=1 WHERE id='{$id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'Account status changed successfully');
		redirect($red);
	}

	public function remove_deposit_account()
	{
		$id = $this->uri->segment(3);
		$red = 'deposit_account';
		$this->db->query("DELETE FROM deposit_account WHERE id='{$id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'Account deleted successfully');
		redirect($red);
	}

//	withdraw account

	public function withdraw_account()
	{
		$data = [];
		$data['title'] = 'Withdraw Account';
		$data['get_data'] = $this->db->query("SELECT * FROM withdraw_account")->result();
		$this->load->view('admin/withdraw_account', $data);
	}

	public function add_withdraw_account()
	{
		$data = array();
		$red = 'withdraw_account';
		if ($this->input->post('submit')) {
			$account_name = $this->input->post('account_name');
			$account_no = $this->input->post('account_no');

			if (!empty($account_name) && !empty($account_no)) {
				$data_arr = array(
					'account_name' => $account_name,
					'account_no' => $account_no,
					'created_at' => date("Y-m-d H:i:s")
				);
				$this->db->insert('withdraw_account', $data_arr);
				$this->session->set_flashdata('msg', 'Account created successfully');
				redirect($red);
			}
		}
	}

	public function w_account_inactive_status()
	{
		$id = $this->uri->segment(3);
		$red = 'withdraw_account';
		$this->db->query("UPDATE withdraw_account SET status=0 WHERE id='{$id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'Account status changed successfully');
		redirect($red);
	}

	public function w_account_active_status()
	{
		$id = $this->uri->segment(3);
		$red = 'withdraw_account';
		$this->db->query("UPDATE withdraw_account SET status=1 WHERE id='{$id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'Account status changed successfully');
		redirect($red);
	}

	public function remove_withdraw_account()
	{
		$id = $this->uri->segment(3);
		$red = 'withdraw_account';
		$this->db->query("DELETE FROM withdraw_account WHERE id='{$id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'Account deleted successfully');
		redirect($red);
	}


//	end deposit and withdraw account


	public function post_create_role() {
		$data = array();

		if($this->input->post('submit')) {
			$role_name = $this->input->post('role_name');
			$role_data = $this->input->post('role_data');
			$red = 'manage_role/';

			if(empty($role_name) || empty($role_data)) {
				$this->session->set_flashdata('error', 'All fields are required');
				redirect($red);
			}

			// -- if club exists
			$x_club = $this->db->query("SELECT * FROM role_management WHERE role_name='{$role_name}'");
			$x_club = $x_club->row();
			if(!empty($x_club)) {
				$this->session->set_flashdata('error', 'Sorry, This admin role already exists');
				redirect($red);
			}

	        $data_arr = array(
	        	'role_name'		=> $role_name,
	        	'role_data'			=> implode(",", $role_data),
	        	'created_at'	=> date("Y-m-d H:i:s")
	        );
	        $this->db->insert('role_management', $data_arr);
			$this->session->set_flashdata('msg', 'Admin role created successfully');
			redirect($red);
		}
	}

	public function post_edit_role() {
		$data = array();

		if($this->input->post('submit')) {
			$role_name = $this->input->post('role_name');
			$role_data = $this->input->post('role_data');
			$role_id = $this->input->post('edit_role_id');
			$red = 'manage_role/';

			if(empty($role_name) || empty($role_data) || empty($role_id)) {
				$this->session->set_flashdata('error', 'All fields are required');
				redirect($red);
			}

			// -- if club exists
			$x_club = $this->db->query("SELECT * FROM role_management WHERE role_name='{$role_name}' AND id !='{$role_id}'");
			$x_club = $x_club->row();
			if(!empty($x_club)) {
				$this->session->set_flashdata('error', 'Sorry, This admin role already exists');
				redirect($red);
			}

	        $data_arr = array(
	        	'role_name'		=> $role_name,
	        	'role_data'			=> implode(",", $role_data),
	        	'updated_at'	=> date("Y-m-d H:i:s")
	        );
	        $this->db->where('id', $role_id);
	        $this->db->update('role_management', $data_arr);
			$this->session->set_flashdata('msg', 'Admin role updated successfully');
			redirect($red);
		}
	}


	public function post_create_admin() {
		$data = array();

		if($this->input->post('submit')) {
			$full_name = $this->input->post('full_name');
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$role_id = $this->input->post('role_id');
			$red = 'admin_user/';

			if(empty($full_name) || empty($email) || empty($password)) {
				$this->session->set_flashdata('error', 'All fields are required');
				redirect($red);
			}

			// -- if club exists
			$x_club = $this->db->query("SELECT * FROM admin WHERE email='{$email}'");
			$x_club = $x_club->result();
			if(!empty($x_club)) {
				$this->session->set_flashdata('error', 'Sorry, This admin user already exists');
				redirect($red);
			}

			$role_data = $this->db->query("SELECT role_data FROM role_management WHERE id='{$role_id}'")->row();
			if(empty($role_data)) {
				$this->session->set_flashdata('error', 'Sorry, no role found');
				redirect($red);
			}

	        $data_arr = array(
	        	'role_id'		=> $role_id,
	        	'full_name'		=> $full_name,
	        	'email'			=> $email,
	        	'password'		=> md5($password),
	        	'role_data'		=> $role_data->role_data,
	        	'created_at'	=> date("Y-m-d H:i:s")
	        );
	        $this->db->insert('admin', $data_arr);
			$this->session->set_flashdata('msg', 'Admin created successfully');
			redirect($red);
		}
	}

	public function post_edit_admin() {
		$data = array();

		if($this->input->post('submit')) {
			$admin_id = $this->input->post('admin_id');
			$full_name = $this->input->post('full_name');
			$email = $this->input->post('email');
			$password = trim($this->input->post('password'));
			$role_id = $this->input->post('role_id');
			$status = $this->input->post('status');
			$red = 'admin_user/';

			if( empty($admin_id) ) {
				$this->session->set_flashdata('error', 'All fields are required');
				redirect($red);
			}

			// -- if club exists
			$x_club = $this->db->query("SELECT * FROM admin WHERE email='{$email}' AND id!='{$admin_id}'");
			$x_club = $x_club->result();
			if(!empty($x_club)) {
				$this->session->set_flashdata('error', 'Sorry, This admin user already exists');
				redirect($red);
			}

			$role_data = $this->db->query("SELECT role_data FROM role_management WHERE id='{$role_id}'")->row();
			if(empty($role_data)) {
				$this->session->set_flashdata('error', 'Sorry, no role found');
				redirect($red);
			}

	        $data_arr = array(
	        	'role_id'		=> $role_id,
	        	'full_name'		=> $full_name,
	        	'email'			=> $email,
	        	'role_data'		=> $role_data->role_data,
	        	'status'		=> $status,
	        	'created_at'	=> date("Y-m-d H:i:s")
	        );
			if(!empty($password)) {
				$data_arr['password'] = md5($password);
			}

			$this->db->where('id', $admin_id);
			$this->db->update('admin', $data_arr);
			$this->session->set_flashdata('msg', 'Admin account updated successfully');
			redirect($red);
		}
	}


	public function customer_user()
	{
		$data = array();
		$data['title'] = 'Customer User';
		$data['customer_data'] = $this->db->query("SELECT * FROM users ORDER BY id DESC")->result();
		$this->load->view('admin/user/customer_user', $data);
	}

 

	public function customer_user_dt()
	{

		$club_id = $this->input->post('club_id');
		 	
		 	if (!empty($club_id)) 
		 	{
		 		$query = "SELECT * FROM users WHERE club_id = '{$club_id}'";
		 		if (isset($_POST["search"]["value"])) {
					$query .= ' AND
				 (username LIKE "%' . $_POST["search"]["value"] . '%"
				 OR email LIKE "%' . $_POST["search"]["value"] . '%"
				 OR phone LIKE "%' . $_POST["search"]["value"] . '%" 
				 OR country LIKE "%' . $_POST["search"]["value"] . '%")
				';
				}
		 	}
		 	else
		 	{
				$query = "SELECT * FROM users";
				if (isset($_POST["search"]["value"])) {
					$query .= ' WHERE
				 (username LIKE "%' . $_POST["search"]["value"] . '%"
				 OR email LIKE "%' . $_POST["search"]["value"] . '%"
				 OR phone LIKE "%' . $_POST["search"]["value"] . '%" 
				 OR country LIKE "%' . $_POST["search"]["value"] . '%")
				';
				}
		 	}
 

			if (isset($_POST["order"])) {
				$columns = "";
				$query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
			} else {
				$query .= 'ORDER BY id DESC ';
			}
			if ($_POST["length"] != -1) {
				$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			} else {
				$query1 = "";
			}

			$number_filter_row = $this->db->query($query)->num_rows();
			$fetch_data = $this->db->query($query . $query1)->result();
			$data = array();
			$i = 1;
			foreach ($fetch_data as $val) {
				$sub_array = array();

				if($val->status == 1) {
                    $status_user =  '<span class="badge badge-success">Active</span>';
                    $ac_s = "<i style='color:red' class='fa fa-power-off fa-lg'></i>";
                    $sts = 0;
                } else {
                    $status_user =  '<span class="badge badge-danger">Inactive</span>';
                    $ac_s = "<i style='color: #0ea432' class='fa fa-check-square fa-lg'></i>";
                    $sts=1;
                }

                

				$action_btn = "<a href='javascript:void(0);' onclick='return statusChangeUser($val->id,$sts);' title='Change User Status'>$ac_s</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='javascript:void(0);' onclick='return change_user_password($val->id);' title='Change User Password'><i class='fa fa-key'></i></a>";
				 

				$sub_array[] = $i;
				$sub_array[] = $val->username;
				$sub_array[] = get_user_current_balance($val->id);
				$sub_array[] = get_club_name($val->club_id);
				$sub_array[] = $val->club_bonus. " <a href=\"javascript:void(0);\" onclick=\"return update_club_bonus($val->id);\" class=\"badge badge-warning\">*</a>";
				$sub_array[] = $val->email;
				$sub_array[] = $val->phone;
				$sub_array[] = $val->country; 
				$sub_array[] = $status_user; 
				$sub_array[] = $val->created_at; 
				$sub_array[] = $action_btn;
				$data[] = $sub_array;
				$i++;
			}
 

			$recordsTotal = $this->db->query($query)->num_rows();
			$output = array(
				"draw" => intval($_POST["draw"]),
				"recordsTotal" => $recordsTotal,
				"recordsFiltered" => $number_filter_row,
				"data" => $data 
			);
			echo json_encode($output);
		 
	}

	public function update_club_bonus()
	{
		$id = $this->input->post("id");
		$club_bonus = $this->input->post("club_bonus");
		 
		$data_arr = array(
			'club_bonus' => $club_bonus,
			'updated_at' => date("Y-m-d H:i:s")
		);
		$this->db->where('id', $id);
		$this->db->update('users', $data_arr);
		
		echo json_encode(array('st'=>200,'msg'=>'Successfully update club bonus'));
	}


	// -- end user panel data // may be its unused fun
	public function create_match()
	{
		$data = array();
		$data['title'] = "Create Match";
		$data['sports'] = $this->db->query("SELECT * FROM sportscategory")->result();

		if ($this->input->post('submit')) {
			$survey_id = $this->input->post('survey_id');
			$sponsor_title = $this->input->post('sponsor_title');
			$upload = $_FILES['upload_file']['name'];
			$red = 'admin/create_sponsor/';

			if (!$upload || empty($sponsor_title)) {
				$this->session->set_flashdata('error', 'All fields are required');
				redirect($red);
			}

			if ($upload) {
				$filename = $_FILES['upload_file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$ext = strtolower($ext);
				$accept_files = ["jpeg", "jpg", "png", "bmp", "gif"];
				if (!in_array($ext, $accept_files)) {
					$this->session->set_flashdata('error', 'Invalid file extension. permitted file is .jpg, .jpeg & .png');
					redirect($red);
				}
				$destination = "uploads/sponsor/" . $filename;
				move_uploaded_file($_FILES['upload_file']['tmp_name'], $destination);
			}
			$attachment = ($upload) ? $upload : "";

			$papana = array(
				'survey_id' => $survey_id,
				'sponsor_title' => $sponsor_title,
				'upload_file' => $attachment,
				'created_at' => now(),
				'status' => 1
			);
			$this->db->insert('sponsor_data', $papana);
			$this->session->set_flashdata('msg', 'Sponsor created successfully');
			redirect('admin/manage_sponsor');

		}
		$this->load->view('admin/liveinplay/create_match', $data);
	}


	public function settings()
	{
		$data = [];
		$data['get_data'] = $this->db->query("SELECT * FROM settings")->row();
		$id = $data['get_data']->id;

		if ($this->input->post('submit')) {

			$multibet_enable = $this->input->post('multibet_enable');
			$multibet_limit = $this->input->post('multibet_limit');

			$club_withdraw_limit = $this->input->post('club_withdraw_limit');
			$club_withdraw_limit_max = $this->input->post('club_withdraw_limit_max');
			$bet_limit_min = $this->input->post('bet_limit_min');
			$bet_limit_max = $this->input->post('bet_limit_max');
			$min_balance_for_bet = $this->input->post('min_balance_for_bet');
			$withdraw_per_day = $this->input->post('withdraw_per_day');

			$deposit_bonus_ratio = $this->input->post('deposit_bonus_ratio');
			$bet_cancel_rate = $this->input->post('bet_cancel_rate');
			$withdraw_charge = $this->input->post('withdraw_charge');
			$bet_cancel_time = $this->input->post('bet_cancel_time');
			$copyright = $this->input->post('copyright');
			$contact_no = $this->input->post('contact_no');
			$facebook = $this->input->post('facebook');
			$youtube = $this->input->post('youtube');

			$isDeposit = $this->input->post('isDeposit');
			$isWithdraw = $this->input->post('isWithdraw');
			$isClubWithdraw = $this->input->post('isClubWithdraw');
			$min_deposit = $this->input->post('min_deposit');
			$max_deposit = $this->input->post('max_deposit');
			$min_withdraw = $this->input->post('min_withdraw');
			$max_withdraw = $this->input->post('max_withdraw');
			$min_transfer = $this->input->post('min_transfer');
			$max_transfer = $this->input->post('max_transfer');
			//mn-keranchi-on-user-balance
			$user_balance_plus_minus = $this->input->post('user_balance_plus_minus');
			$data_arr = array(

				'multibet_enable' => $multibet_enable,
				'multibet_limit' => $multibet_limit,

				'club_withdraw_limit' => $club_withdraw_limit,
				'club_withdraw_limit_max' => $club_withdraw_limit_max,
				'bet_limit_min' => $bet_limit_min,
				'bet_limit_max' => $bet_limit_max,
				'min_balance_for_bet' => $min_balance_for_bet,
				'withdraw_per_day' => $withdraw_per_day,

				'deposit_bonus_ratio' => $deposit_bonus_ratio,
				'bet_cancel_rate' => $bet_cancel_rate,
				'withdraw_charge' => $withdraw_charge,
				'bet_cancel_time' => $bet_cancel_time,
				'copyright' => $copyright,
				'contact_no' => $contact_no,
				'facebook' => $facebook,
				'youtube' => $youtube,

				'isDeposit' => $isDeposit,
				'isWithdraw' => $isWithdraw,
				'isClubWithdraw' => $isClubWithdraw,
				'min_deposit' => $min_deposit,
				'max_deposit' => $max_deposit,
				'min_withdraw' => $min_withdraw,
				'max_withdraw' => $max_withdraw,
				'min_transfer' => $min_transfer,
				'max_transfer' => $max_transfer,
				'user_balance_plus_minus' => $user_balance_plus_minus,
				'updated_at' => date("Y-m-d H:i:s")
			);
			$this->db->where('id', $id);
			$this->db->update('settings', $data_arr);
			$this->session->set_flashdata('msg', 'Settings updated successfully');
			redirect('settings');
		}

		$this->load->view('admin/settings', $data);
	}
	
	public function live_tv_link()
	{
		$data = [];
		$data['get_data'] = $this->db->query("SELECT * FROM settings")->row();
		$id = $data['get_data']->id;

		if ($this->input->post('submit')) {
			$live_tv = $this->input->post('live_tv');

			$data_arr = array(
				'live_tv' => $live_tv,
				'updated_at' => date("Y-m-d H:i:s")
			);
			$this->db->where('id', $id);
			$this->db->update('settings', $data_arr);
			$this->session->set_flashdata('msg', 'Live TV updated successfully');
			redirect('live-tv-link');
		}

		$this->load->view('admin/live_tv_link', $data);
	}


	// history functions
	public function customer_deposit_history()
	{
		$data = array();
		$data['title'] = 'Customer Deposit'; 
		$this->load->view('admin/history/customer_deposit_history', $data);
	}

	public function customer_withdraw_history()
	{
		$data = array();
		$data['title'] = 'Customer Withdraw'; 

		$this->load->view('admin/history/customer_withdraw_history', $data);
	}

	public function club_withdraw_history()
	{
		$data = array();
		$data['title'] = 'Club Withdraw History';
		$data['withdraw_data'] = $this->db->query("SELECT cw.*, c.club_name FROM club_withdraw_req AS cw INNER JOIN club_users AS c ON cw.club_user_id=c.id ORDER BY id DESC LIMIT 20")->result();
		if ($this->input->post('submit')) {
			$search_data = $this->input->post('search_data');
			if (!empty($search_data)) {
				$data['withdraw_data'] = $this->db->query("SELECT cw.*, c.club_name FROM club_withdraw_req AS cw INNER JOIN club_users AS c ON cw.club_user_id=c.id
					WHERE
					c.club_name LIKE '%$search_data%' OR
					cw.payment_type LIKE '%$search_data%' OR
					cw.payment_method LIKE '%$search_data%' OR
					cw.from_no LIKE '%$search_data%' OR
					cw.account_number LIKE '%$search_data%'
					ORDER BY id DESC")->result();
			}
		}
		$this->load->view('admin/history/club_withdraw_history', $data);
	}


	public function match_bit_coin_history()
	{
		$data = array();
		$data['title'] = 'Match Bet Coin';
		$this->load->view('admin/history/match_bit_coin_history', $data);
	}

	public function complain_history()
	{
		$data = array();
		$data['title'] = 'Customer Complain'; 
		$this->load->view('admin/history/complain_history', $data);
	}

	public function balance_transfer_history()
	{

		$data = array();
		$data['title'] = 'Customer Balance Transfer'; 
		$this->load->view('admin/history/balance_transfer_history', $data);

	}

	public function bet_option_details_hide_show()
	{
		$match_option_details_id = $this->uri->segment(3);
		$match_id = $this->uri->segment(4);
		if(!empty($match_option_details_id)){
			$this->db->query("UPDATE `match_option_details` SET `status` = '4' WHERE `match_option_details`.`id` = '{$match_option_details_id}'");
		 
		  	// trigger_pusher('bet_option_ch','bet_option_ev');  

			$this->session->set_flashdata('msg', 'Match bet option has been hide');
			redirect('match_details/view/' . $match_id);
		}
	}

	public function get_bet_options_for_result()
	{
		if (!empty($_POST)) {
			$bet_id = $_POST['hidden_bet_id'];
			$data = $this->db->query("SELECT id, option_title, option_coin FROM match_option_details WHERE match_option_id='{$bet_id}'")->result();
			$string = "";
			foreach ($data as $val) {
				$string .= "<option value='" . $val->id . "'>$val->option_title</option>";
			}
			echo $string;
		}
	}


	// -- statement functionality
	public function user_statement()
	{
		$this->load->view('admin/report/user_statement');
	}

	public function user_statement_dt()
	{
		 

		$date1 = $this->input->post('date1') == 'NaN-NaN-NaN' ? '' : $this->input->post('date1');
		$date2 = $this->input->post('date2') == 'NaN-NaN-NaN' ? '' : $this->input->post('date2');;
		$user = get_user_id_by_username($this->input->post('user'));
		$d1 = "";
		if (!empty($date1) && empty($date2)) {
			$d1 = "AND created_at LIKE '$date1%' ";
		} else if (!empty($date1) && !empty($date2)) {
			$d1 = "AND created_at >= '" . $date1 . " 00:00:00' AND created_at <= '" . $date2 . " 23:59:59'";
		}

		if (!empty($user)) {
			 

			$query = "SELECT * FROM my_coin WHERE user_id='{$user}' AND coin_type NOT IN('DEPO') $d1";

			if (isset($_POST["search"]["value"])) {
				$query .= ' AND
			 (created_at LIKE "%' . $_POST["search"]["value"] . '%"
			 OR coin_type LIKE "%' . $_POST["search"]["value"] . '%"
			 OR method LIKE "%' . $_POST["search"]["value"] . '%")
			';
			}
			if (isset($_POST["order"])) {
				$columns = "";
				$query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
			} else {
				$query .= 'ORDER BY id DESC ';
			}
			if ($_POST["length"] != -1) {
				$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}else{
				$query1='';
			}

			$number_filter_row = $this->db->query($query)->num_rows();
			$fetch_data = $this->db->query($query . $query1)->result();
			$data = array();
			$purpose = null;
			$i = 1;
			foreach ($fetch_data as $row) {

				$bet_type ="Others";
				if ($row->single_bet_id!=null || $row->multi_bet_id!=null) {
					$bet_type = $row->single_bet_id==null?"MultiBet":"SingleBet";
				}
				$get_bet_st = "";
				if ($row->single_bet_id!=null) {
					$get_bet_st = get_matchbet_coin_status($row->single_bet_id);
				}
				if ($row->multi_bet_id!=null) {
					$get_bet_st = get_multi_bet_status($row->multi_bet_id);
				}

				if ($get_bet_st=="LOST" || $get_bet_st=="CANCEL_ADMIN" || $get_bet_st=="USER_CANCEL") {
					$get_bet_st = $get_bet_st;
					$badge = 'danger';
				} else {
					$badge = 'info';
					$get_bet_st = "";
				}

				$bet_type_id = $row->single_bet_id==null?$row->multi_bet_id:$row->single_bet_id;

				if ($bet_type_id==null) {
					$bet_type_id = 0;
				}

				if ($row->coin_type == 'DEPOSIT') {
					$purpose = 'Deposit Coin';
				} else if ($row->coin_type == 'TRANSFER_GET') {
					$purpose = 'Received Coin';
				} else if ($row->coin_type == 'WITHDRAW') {
					$purpose = 'Withdraw';
				} else if ($row->coin_type == 'BONUS') {
					$purpose = 'Bonus Coin';
				} else if ($row->coin_type == 'BETWIN') {
					$purpose = '<a style="cursor:pointer" class="badge badge-success" onclick="return get_statement_details(\''.$bet_type.'\',\''.$bet_type_id.'\')">Match Win</a>';
				} else if ($row->coin_type == 'BETLOSS') {
					$purpose = 'Bet Loss';
				} else if ($row->coin_type == 'BETCANCEL') {
					$purpose = 'Bet Return';
				} else if ($row->coin_type == 'TRANSFER_POST') {
					$purpose = 'Send Coin';
				} else if ($row->coin_type == 'RUNNING_BET') {
					$purpose = '<a style="cursor:pointer" class="badge badge-'.$badge.'" onclick="return get_statement_details(\''.$bet_type.'\',\''.$bet_type_id.'\')">Take Bet '.$get_bet_st.'</a>';
				} else if ($row->coin_type == 'ADD_COIN') {
					$purpose = 'Coin Add';
				} else if ($row->coin_type == 'RETURN_COIN') {
					$purpose = 'Coin Return';
				} else if ($row->coin_type == 'WITHDRAW_CANCEL') {
					$purpose = 'Withdraw Cancel';
				} else if ($row->coin_type == 'DEPOSIT_CANCEL') {
					$purpose = 'Deposit Cancel';
				}
				
				

				$sub_array = array();
				$sub_array[] = $i;
				$sub_array[] = get_username($row->user_id);
				$sub_array[] = get_club_name($row->club_id);
				$sub_array[] = $purpose;
				$sub_array[] = $bet_type;
				$sub_array[] = $row->created_at;
				$sub_array[] = $row->method == "POST" ? $row->coin : "0.00";
				$sub_array[] = $row->method == "GET" ? $row->coin : "0.00";
				$sub_array[] = $row->current_balance;
				$data[] = $sub_array;
				$i++;
			}

			$recordsTotal = $this->db->query("SELECT * FROM my_coin WHERE user_id='{$user}' $d1 ")->num_rows();

			$output = array(
				"draw" => intval($_POST["draw"]),
				"recordsTotal" => $recordsTotal,
				"recordsFiltered" => $number_filter_row,
				"data" => $data
			);
			echo json_encode($output);
		}
	}

	public function club_statement()
	{
		$this->load->view('admin/report/club_statement');
	}

	public function club_statement_dt()
	{

		$date1 = $this->input->post('date1') == 'NaN-NaN-NaN' ? '' : $this->input->post('date1');
		$date2 = $this->input->post('date2') == 'NaN-NaN-NaN' ? '' : $this->input->post('date2');;
		$user = get_club_id_by_username($this->input->post('user'));
		$d1 = "";
		if (!empty($date1) && empty($date2)) {
			$d1 = "AND created_at LIKE '$date1%' ";
		} else if (!empty($date1) && !empty($date2)) {
			$d1 = "AND created_at >= '" . $date1 . " 00:00:00' AND created_at <= '" . $date2 . " 23:59:59'";
		}

		if (!empty($user)) {
			$query = "SELECT * FROM club_coin WHERE club_id='{$user}' $d1";

			if (isset($_POST["search"]["value"])) {
				$query .= ' AND
			 (created_at LIKE "%' . $_POST["search"]["value"] . '%")
			';
			}
			if (isset($_POST["order"])) {
				$columns = "";
				$query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
			} else {
				$query .= 'ORDER BY id DESC ';
			}
			if ($_POST["length"] != -1) {
				$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}else{
				$query1='';
			}

			$number_filter_row = $this->db->query($query)->num_rows();
			$fetch_data = $this->db->query($query . $query1)->result();
			$data = array();
			$purpose = null;
			$i = 1;
			foreach ($fetch_data as $row) {
				if ($row->source == 'BET') {
					$purpose = 'From Bet';
				} else if ($row->source == 'BONUS') {
					$purpose = 'Received Bonus';
				} else if ($row->source == 'WITHDRAW') {
					$purpose = 'Withdraw';
				} else if ($row->source == 'WITHDRAW_CANCEL') {
					$purpose = 'Withdraw Cancel';
				}
				$sub_array = array();
				$sub_array[] = $i;
				$sub_array[] = get_club_name($row->club_id);
				$sub_array[] = get_username($row->club_user_id);
				$sub_array[] = $purpose;
				$sub_array[] = $row->created_at;
				$sub_array[] = $row->method == "POST" ? $row->coin : "0.00";
				$sub_array[] = $row->method == "GET" ? $row->coin : "0.00";
				$sub_array[] = $row->current_balance;
				$data[] = $sub_array;
				$i++;
			}

			$recordsTotal = $this->db->query("SELECT * FROM club_coin WHERE club_id='{$user}' $d1")->num_rows();

			$output = array(
				"draw" => intval($_POST["draw"]),
				"recordsTotal" => $recordsTotal,
				"recordsFiltered" => $number_filter_row,
				"data" => $data
			);
			echo json_encode($output);
		}
	}

//	ajax query
	public function user_ajax_call()
	{
		$username = $this->input->post("user");
		$data_query = $this->db->query("SELECT username FROM `users` WHERE username LIKE '$username%'")->result();
		$data = array();
		if (!empty($data_query)) {
			foreach ($data_query as $val) {
				$data[] = $val->username;
			}
		}
		echo json_encode($data);
	}

	public function club_ajax_call()
	{
		$username = $this->input->post("user");
		$data_query = $this->db->query("SELECT club_name FROM `club_users` WHERE club_name LIKE '$username%'")->result();
		$data = array();
		if (!empty($data_query)) {
			foreach ($data_query as $val) {
				$data[] = $val->club_name;
			}
		}
		echo json_encode($data);
	}


	public function create_bulk_match_option_viewpage()
	{

		$red = $_POST['match_id'];
		for ($i = 1; $i <= count($_POST['question']); $i++) {
			$data_arr = array(
				'match_id' => $_POST['match_id'],
				'match_option_title' => $_POST['question'][$i],
				'match_option_serial' => $_POST['question_serial'][$i],
				'created_at' => date('Y-m-d H:i:s')
			);
			$this->db->insert('match_option', $data_arr);
			$last_id = $this->db->insert_id();

			for ($ii = 0; $ii < count($_POST['question_option'][$i]); $ii++) {
				$data_arrr = array(
					'match_id' => $_POST['match_id'],
					'match_option_id' => $last_id,
					'option_title' => $_POST['question_option'][$i][$ii],
					'option_coin' => $_POST['option_coin'][$i][$ii],
					'multi_option_coin' => $_POST['multi_option_coin'][$i][$ii],
					'option_serial' => $_POST['option_serial'][$i][$ii],
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->db->insert('match_option_details', $data_arrr);
			}
		}
 

		echo json_encode(array('st' => 200, 'sid' => $red, 'msg' => 'Match option created successfully'));
	}

	public function get_total_statement()
	{
		$date1 = $this->input->post('date1') == 'NaN-NaN-NaN' ? '' : $this->input->post('date1');
		$date2 = $this->input->post('date2') == 'NaN-NaN-NaN' ? '' : $this->input->post('date2');
		$club_id = get_club_id_by_username($this->input->post('user'));
		$club_id = $club_id == ''?"":" AND club_id = ".$club_id;
		$club_user_id = $club_id == ''?"":" AND club_user_id = ".$club_id;
		$data = array();

		$get_matchbit_coin_data = $this->db->query("
					SELECT 
						SUM(CASE WHEN bet_status='LOST' THEN bet_coin ELSE 0 END) AS total_fail,
						SUM(CASE WHEN bet_status='LOST' THEN total_coin ELSE 0 END) AS total_fail_return,
						SUM(CASE WHEN bet_status='MATCH_RUNNING' THEN bet_coin ELSE 0 END) AS running_bet,
						SUM(CASE WHEN bet_status='MATCH_RUNNING' THEN total_coin ELSE 0 END) AS running_bet_return,
						SUM(CASE WHEN bet_status='USER_CANCEL' THEN bet_coin ELSE 0 END) AS total_cancel_u,
						SUM(CASE WHEN bet_status='CANCEL_ADMIN' THEN bet_coin ELSE 0 END) AS total_cancel_a,
						SUM(CASE WHEN bet_status='WIN' THEN total_coin ELSE 0 END) AS total_win,
						SUM(bet_coin) AS total_bet,SUM(total_coin) AS total_coin_return
					FROM `matchbit_coin` 
					WHERE created_at >= '" . $date1 . " 00:00:00' AND created_at <= '" . $date2 . " 23:59:59' $club_id")->row();

		$data['total_bet'] =  $get_matchbit_coin_data->total_bet;

		
		$data['total_fail'] =  $get_matchbit_coin_data->total_fail;
		
		$data['running_bet'] =  $get_matchbit_coin_data->running_bet;

		$data['total_cancel_u'] =  $get_matchbit_coin_data->total_cancel_u;
		
		$data['total_cancel_a'] =  $get_matchbit_coin_data->total_cancel_a;

		$data['total_win'] =  $get_matchbit_coin_data->total_win;

		$data['total_coin_return'] =  $get_matchbit_coin_data->total_coin_return;
		$data['running_bet_return'] =  $get_matchbit_coin_data->running_bet_return;
		$data['total_fail_return'] =  $get_matchbit_coin_data->total_fail_return;

		
		$data['total_deposit'] = $this->db->query("SELECT SUM(amount) AS amount FROM `deposit` WHERE status = 'SUCCESS' AND created_at >= '" . $date1 . " 00:00:00' AND created_at <= '" . $date2 . " 23:59:59' $club_user_id")->row()->amount;
		
		$data['total_withdraw_u'] = $this->db->query("SELECT SUM(amount) AS amount FROM `withdraw_req` WHERE status = 'SUCCESS' AND created_at >= '" . $date1 . " 00:00:00' AND created_at <= '" . $date2 . " 23:59:59'  $club_user_id")->row()->amount;
		
		$data['total_withdraw_c'] = $this->db->query("SELECT SUM(amount) AS amount FROM `club_withdraw_req` WHERE status = 'SUCCESS' AND created_at >= '" . $date1 . " 00:00:00' AND created_at <= '" . $date2 . " 23:59:59'  $club_user_id")->row()->amount;

		$multi_bet_data = $this->db->query("SELECT SUM(CASE WHEN status = 'MATCH_RUNNING' THEN total_coin ELSE 0 END) AS running_multi_bet,SUM(CASE WHEN status = 'WIN' THEN total_coin ELSE 0 END) AS total_multi_bet_win,SUM(CASE WHEN status = 'LOST' THEN total_coin ELSE 0 END) AS total_multi_bet_failed FROM `multibet` WHERE created_at >= '" . $date1 . " 00:00:00' AND created_at <= '" . $date2 . " 23:59:59' $club_id")->row();

		$data['running_multi_bet'] = $multi_bet_data->running_multi_bet;
		$data['total_multi_bet_win'] = $multi_bet_data->total_multi_bet_win;
		$data['total_multi_bet_failed'] = $multi_bet_data->total_multi_bet_failed;
		
		if ($club_id!='') {
			$club_id = " WHERE club_id = ".$club_id;
		}
		$coins = $this->db->query("SELECT current_balance FROM my_coin WHERE `id` IN ( SELECT MAX(`id`) FROM my_coin $club_id GROUP BY `user_id` )")->result();
		$amount = [];
		foreach($coins as $coin) {
		    $amount[] = $coin->current_balance;
		}
		$data['total_user_coin'] = round(array_sum($amount), 2);
		
		echo json_encode($data);
	}



	public function change_score_live_game()
	{
		
		$match_id = $_POST['match_name_id'];
		$this->db->query("UPDATE matchname SET
			score_1='{$_POST['score_1']}',
			score_2='{$_POST['score_2']}'
			WHERE id='{$match_id}'");
		 
		$data = [];
		 

		$data['id'] = $match_id;
		$data['score1'] = $_POST['score_1'];
		$data['score2'] = $_POST['score_2'];
		
	 
		 

		$this->session->set_flashdata('msg', 'Score changed successfully');
		redirect('match_details');
	}

	public function show_to_slider_game()
	{

		$match_id = $_POST['id'];
		$show_in = $_POST['show_in'];
 
		$this->db->query("UPDATE matchname SET
			score_show_in='{$show_in}' 
			WHERE id='{$match_id}'");
  
			$data = [];
			 
			$data['id'] = $match_id; 
			$data['show_in'] = $show_in; 
 
		$this->session->set_flashdata('msg', 'Score changed successfully');
		redirect('match_details');
	}
	
	
	
	
//	game page function here

	public function game_page(){
		$data = [];
		$data['title'] = 'Game Page';
		$data['get_data'] = $this->db->query("SELECT * FROM game_page ORDER BY serial ASC")->result();
		$this->load->view('admin/game/game_page', $data);
	}
	public function game_page_image()
	{
		if (isset($_FILES["image_file"]["name"])) { 
			$game_page_id = $this->input->post('game_page_id');
			$config['upload_path'] = './assets/game/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['max_size'] = 2000;
			$config['max_width'] = 1500;
			$config['max_height'] = 1500;
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('image_file')) {
				echo $this->upload->display_errors() . "<br>";
				echo "Image max size 2MB, max width/height 1500px";
			} else {
				$data = $this->upload->data();
				$file_name = $data["file_name"];
				
				$img_path = base_url(). "assets/game/" . $file_name;
				
				$this->db->query("UPDATE game_page SET page_image = '{$file_name}' WHERE id = '{$game_page_id}' ");

				echo '<img src="' . $img_path . '" width="200" height="200" class="img-thumbnail" />';
			}
		}
	}
	public function game_page_inactive(){
		$id = $this->uri->segment(2);
		$red = 'game_page';
		$this->db->query("UPDATE game_page SET status='Inactive' WHERE id='{$id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'Game page status changed successfully');
		redirect($red);
	}
	public function game_page_active(){
		$id = $this->uri->segment(2);
		$red = 'game_page';
		$this->db->query("UPDATE game_page SET status='Active' WHERE id='{$id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'Game page status changed successfully');
		redirect($red);
	}

	public function change_game_page_serial(){
		$sl = $this->uri->segment(3);
		$id = $this->uri->segment(4);

		$red = 'game_page';
		$this->db->query("UPDATE game_page SET serial='{$sl}' WHERE id='{$id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'Serial changed successfully');
		redirect($red);
	}

	public function game_page_banner(){
		$data = array();
		$data['title'] = 'View Details';
		$game_id = $this->uri->segment(3);
		$data['game_id'] = $game_id;
		$data['get_game_slider'] = $this->db->query("SELECT * FROM game_page_slider WHERE game_page_id='{$game_id}'")->result();
		$this->load->view('admin/game/game_page_slider', $data);
	}



	public function add_game_page_slider(){
		if (isset($_FILES["image_file"]["name"])) {
			$slider_serial = $this->input->post('slider_serial');
			$game_page_id = $this->input->post('game_page_id');
			$config['upload_path'] = './assets/game/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
			$config['max_size'] = 2000;
			$config['max_width'] = 1500;
			$config['max_height'] = 1500;
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('image_file')) {
				echo $this->upload->display_errors() . "<br>";
				echo "Image max size 2MB, max width/height 1500px";
			} else {
				$data = $this->upload->data();
				$file_name = $data["file_name"];
				$img_path = base_url(). "assets/game/" . $file_name;
				$this->db->query("INSERT INTO game_page_slider VALUES (null,'$game_page_id','$file_name','$slider_serial','1')");
				echo '<img src="' . $img_path . '" width="200" height="200" class="img-thumbnail" />';
			}
		}
	}

	public function game_page_slider_status_change(){
		$game_page_id = $this->input->post('id');
		$status_change = $this->input->post('status');
		if (isset($game_page_id) && isset($status_change)) {
			if ($this->db->query("UPDATE game_page_slider SET status='$status_change' WHERE id ='$game_page_id'")) {
				echo json_encode(array('st' => 200, 'msg' => 'Successfully update status'));
			} else {
				echo json_encode(array('st' => 400, 'msg' => 'Error! something worng'));
			}
		}
	}

	public function game_page_slider_delete(){
		$del_id = $this->input->post('id');
		$icon_name = $this->db->query("SELECT file_name FROM game_page_slider WHERE id='{$del_id}'")->row()->file_name;
		$img_path = "assets/game/".$icon_name;
		if (!empty($del_id) && $icon_name) {
			if (unlink($img_path)) {
				$this->db->query("DELETE FROM game_page_slider WHERE id = '$del_id'");
				echo json_encode(array('st' => 200));
			}
		}
	}

	public function change_game_page_slider_serial(){
		$sl = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$page_id = $this->uri->segment(5);
		$this->db->query("UPDATE game_page_slider SET serial='{$sl}' WHERE id='{$id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'Serial changed successfully');
		redirect("game_page/view/".$page_id);
	}

	public function add_balance_to_user(){
		$user_id = $this->input->post("id");
		$input_coin = $this->input->post("amount");
		$get_cur_balance = @(get_user_current_balance($user_id) + $input_coin);
		$data_arr2 = array(
			'user_id' => $user_id,
			'club_id' => get_user_club_id($user_id),
			'coin' => $input_coin,
			'current_balance' => $get_cur_balance,
			'coin_type' => 'ADD_COIN',
			'method' => 'GET',
			'transfer_user_id' => 0,
			'created_at' => date("Y-m-d H:i:s")
		);
		if ($this->db->insert('my_coin', $data_arr2)){
			echo json_encode(array('st'=>200,'msg'=>'Successfully Add Coin'));
		}
	}

	public function return_balance_to_user(){
		$user_id = $this->input->post("id");
		$input_coin = $this->input->post("amount");
		$get_cur_balance = @(get_user_current_balance($user_id) - $input_coin);
		$data_arr2 = array(
			'user_id' => $user_id,
			'club_id' => get_user_club_id($user_id),
			'coin' => $input_coin,
			'current_balance' => $get_cur_balance,
			'coin_type' => 'RETURN_COIN',
			'method' => 'GET',
			'transfer_user_id' => 0,
			'created_at' => date("Y-m-d H:i:s")
		);
		if ($this->db->insert('my_coin', $data_arr2)){
			echo json_encode(array('st'=>200,'msg'=>'Successfully Return Coin'));
		}
	}

	public function backup_db() {
		$this->load->helper('file');
		$this->load->helper('download');
		$this->load->library('zip');

		$this->load->dbutil();

		$prefs = array(     
		    'format'      => 'zip',             
		    'filename'    => 'my_db_backup.sql'
		    );


		$backup= $this->dbutil->backup($prefs); 

		$db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
		$save = base_url().'/'.$db_name;

		write_file($save, $backup); 
		$this->load->helper('download');
		force_download($db_name, $backup);

	}
 
	
	public function get_bet_option_values() {
	    $option_id = $_POST['option_id'];
	    $username = $_POST['username'];
	    
	    $data = $this->db->query("SELECT * FROM matchbit_coin WHERE id='{$option_id}'")->row()->match_bet_option_id;
	    $data2 = $this->db->query("SELECT * FROM match_option_details WHERE match_option_id='{$data}'")->result();
	    $str = "";
	    foreach($data2 as $val) {
	        $str .= '<option value="'.$val->id.'">'. $val->option_title . '</option>';
	    }
	    echo $str;
	}
	
	public function update_matchbet_option() {
	    $red = base_url('matchbit_coin');
	    $matchbit_id = $_POST['matchbet_option_id'];
	    $option_details_id = $_POST['matchbet_option'];
	    $this->db->query("UPDATE matchbit_coin SET match_bit_id='{$option_details_id}' WHERE id='{$matchbit_id}' LIMIT 1");
		$this->session->set_flashdata('msg', 'Status changed successfully');
		redirect($red);
	}
  
	public function change_user_password()
	{
		$id = $this->input->post("id");
		$password = $this->input->post("password");
		 
		$data_arr = array(
			'password' => md5($password),
			'updated_at' => date("Y-m-d H:i:s")
		);
		$this->db->where('id', $id);
		$this->db->update('users', $data_arr);
		
	 
		echo json_encode(array('st'=>200,'msg'=>'Successfully change password'));
		 
	}
	
	public function admin_password_change()
	{
		$id = $this->session->userdata['admin_user_data']->id;
		$password = $this->input->post("password");
	 
		$data_arr = array(
			'password' => md5($password),
			'updated_at' => date("Y-m-d H:i:s")
		);
		$this->db->where('id', $id);
		$this->db->update('admin', $data_arr);
	 
		echo json_encode(array('st'=>200,'msg'=>'Successfully change password'));
	}
	
	public function option_collapse_or_expand()
	{
		$red = 'match_details/view/' . $this->uri->segment(5);
		$this->db->query("UPDATE match_option SET collapse_or_expand='{$this->uri->segment(4)}' WHERE id='{$this->uri->segment(3)}' LIMIT 1"); 
 
 			 
		$this->session->set_flashdata('msg', 'Option '.$this->uri->segment(4).' updated successfully');
		redirect($red);
	}

	public function option_collapse_or_expand_all()
	{ 
		$update = $this->db->query("UPDATE match_option SET collapse_or_expand='{$this->input->post('value')}' WHERE match_id='{$this->input->post('match_id')}'"); 
 
 			 
		$this->session->set_flashdata('msg', 'Option '.$this->uri->segment(4).' updated successfully');
		echo json_encode(array(
			'st' => 200
		));
	}

	public function active_inactive_all()
	{ 
		$update = $this->db->query("UPDATE match_option SET status='{$this->input->post('value')}' WHERE match_id='{$this->input->post('match_id')}'"); 

		// trigger_pusher('show_right_side_bet_ch','show_right_side_bet_ev');
 			 
		$this->session->set_flashdata('msg', 'Option '.$this->uri->segment(4).' updated successfully');
		echo json_encode(array(
			'st' => 200
		));
	}


 


	public function published_bet_result()
	{
		$red = $_SERVER['HTTP_REFERER'];

		if ($this->input->post('submit')) {
			$bet_id = $this->input->post('hidden_bet_id');
			$bet_option_id = $this->input->post('bet_option_id');

			// -- update match option status
			$this->db->query("UPDATE match_option SET status=3 WHERE id='{$bet_id}'");

			// - update match option details status
			$this->db->query("UPDATE match_option_details SET status=2 WHERE id='{$bet_option_id}'");
			$this->db->query("UPDATE match_option_details SET status=3 WHERE id NOT IN('{$bet_option_id}') AND match_option_id IN ('{$bet_id}')");
 			
 			$data = $this->db->query("SELECT match_bit_id,user_id,total_coin,club_id FROM matchbit_coin WHERE match_bit_id='{$bet_option_id}' AND bet_status='MATCH_RUNNING'")->result();

			if (!empty($data)) {
				$ids = "";
				foreach ($data as $val) {
					$ids = $val->match_bit_id;
					 
				}
				$update_qry = "
					UPDATE matchbit_coin SET bet_status =
						CASE
							WHEN match_bit_id IN ('{$ids}') THEN 'WIN'
							WHEN match_bit_id NOT IN ('{$ids}') THEN 'LOST'
						END, updated_at = CURRENT_TIMESTAMP WHERE match_bet_option_id='{$bet_id}' AND bet_status='MATCH_RUNNING'
				";

				$this->db->query($update_qry);
 
			} else {
				// -- update match lost status to the match bit coin table
				$this->db->query("UPDATE matchbit_coin SET bet_status='LOST', updated_at = CURRENT_TIMESTAMP WHERE match_bet_option_id='{$bet_id}' AND bet_status='MATCH_RUNNING'");
			}
 

		  $this->session->set_flashdata('msg', 'Result done successfully');
		}

		redirect($red);
	}

	public function bet_match_cancel()
	{
		$red = $_SERVER['HTTP_REFERER'];
		$id = $this->uri->segment(3);
		if (!empty($id) && is_numeric($id)) {

			// -- update match option status
			$this->db->query("UPDATE match_option SET status='4' WHERE id='{$id}'");
			$this->db->query("UPDATE match_option_details SET status = '3' WHERE match_option_id='{$id}'");

			$data = $this->db->query("SELECT * FROM matchbit_coin WHERE match_bet_option_id = '{$id}'")->result();
			
			if (!empty($data)) {
				foreach ($data as $val) {
					// - update match bit coin
					$this->db->query("UPDATE matchbit_coin SET bet_status = 'CANCEL_ADMIN' WHERE user_id = '{$val->user_id}' AND match_bet_option_id = '{$id}'");
					if ($val->bet_type=="SINGLE_BET") {
						$user_balance = get_user_current_balance($val->user_id);
						$cur_balance = @($user_balance + $val->bet_coin);
						$data_arr2 = array(
							'user_id' => $val->user_id,
							'club_id' => $val->club_id,
							'coin' => $val->bet_coin,
							'current_balance' => $cur_balance,
							'coin_type' => 'BETCANCEL',
							'method' => 'GET',
							'bet_option_id' => $val->match_bit_id,
							'single_bet_id' => $val->id,
							'created_at' => date("Y-m-d H:i:s")
						);
						$this->db->insert('my_coin', $data_arr2); 
					}
				}
				$this->session->set_flashdata('msg', 'Match bet cancelled');
			}
		}
		redirect($red);
	}

	public function bet_rollback()
	{
		$match_option_details_id = $this->uri->segment(3);
		$match_id = $this->uri->segment(4);
		$match_option_id = $this->uri->segment(5);
		$rollback_query = "SELECT * FROM `my_coin` WHERE coin_type = 'BETWIN' AND method = 'GET' AND bet_option_id LIKE '%$match_option_details_id%'";
		$number_filter_row = $this->db->query($rollback_query)->num_rows();
		if ($number_filter_row>0) {
			$user_bet_coin_data = $this->db->query($rollback_query)->result();
			foreach ($user_bet_coin_data as $val_ubcd) {
				// -- insert data in my coin for deducted
				$user_balance = get_user_current_balance($val_ubcd->user_id);
				$cur_balance = $user_balance - $val_ubcd->coin;
				$data_arr2 = array(
					'user_id' => $val_ubcd->user_id,
					'club_id' => $val_ubcd->club_id,
					'coin' => $val_ubcd->coin,
					'current_balance' => $cur_balance,
					'coin_type' => 'BET_ROLLBACK',
					'method' => 'POST',
					'bet_option_id' => $val_ubcd->bet_option_id,
					'created_at' => date("Y-m-d H:i:s")
				);
				$this->db->insert('my_coin', $data_arr2);
			}	
		}

		$this->db->query("UPDATE matchbit_coin SET bet_status = 'MATCH_RUNNING', user_coin_update = 'No' WHERE match_bet_option_id='{$match_option_id}' AND bet_status NOT IN('CANCEL_ADMIN','USER_CANCEL')");
		$this->db->query("UPDATE multibet SET status = 'MATCH_RUNNING', user_multicoin_update = 'No' WHERE option_detail_ids LIKE '&$match_option_details_id%' AND status NOT IN('CANCEL_ADMIN','USER_CANCEL')");
		$this->db->query("UPDATE match_option SET status = '0' WHERE id='{$match_option_id}'");
		$this->db->query("UPDATE match_option_details SET status = '1' WHERE match_option_id='{$match_option_id}'");
	 
		$this->session->set_flashdata('msg', 'Rollback complete successfully');
		redirect('match_details/view/' . $match_id);
	}

	public function bet_rollback_if_failed()
	{
		// $match_option_details_id = $this->uri->segment(3);
		$match_option_id = $this->uri->segment(3);
		$match_id = $this->uri->segment(4);

		$match_option_details_id = $this->db->query("SELECT id FROM `match_option_details` WHERE `match_option_id` = '{$match_option_id}' ")->result();

		$m_dt = array();
		if (!empty($match_option_details_id)) {
			foreach ($match_option_details_id  as $value) {
				$m_dt[] = $value->id;
			}
		}

		// $ids = implode(',', $m_dt);

		$ids = join("','",$m_dt);   

		$rollback_query = "SELECT * FROM `my_coin` WHERE coin_type = 'BETCANCEL' AND method = 'GET' AND bet_option_id IN('$ids')";
		
		$number_filter_row = $this->db->query($rollback_query)->num_rows();

		// dd($match_id);

		if ($number_filter_row>0) {
			$user_bet_coin_data = $this->db->query($rollback_query)->result();
			foreach ($user_bet_coin_data as $val_ubcd) {
				// -- insert data in my coin for deducted
				$user_balance = get_user_current_balance($val_ubcd->user_id);
				$cur_balance = $user_balance - $val_ubcd->coin;
				$data_arr2 = array(
					'user_id' => $val_ubcd->user_id,
					'club_id' => $val_ubcd->club_id,
					'coin' => $val_ubcd->coin,
					'current_balance' => $cur_balance,
					'coin_type' => 'BET_ROLLBACK',
					'method' => 'POST',
					'bet_option_id' => $val_ubcd->bet_option_id,
					'created_at' => date("Y-m-d H:i:s")
				);
				$this->db->insert('my_coin', $data_arr2);
			}	
		}
		$this->db->query("UPDATE matchbit_coin SET bet_status = 'MATCH_RUNNING', user_coin_update = 'No' WHERE match_bet_option_id='{$match_option_id}' AND bet_status NOT IN('USER_CANCEL','WIN','LOST','MATCH_RUNNING')");


		$this->db->query("UPDATE match_option SET status = '0' WHERE id='{$match_option_id}'");
		$this->db->query("UPDATE match_option_details SET status = '1' WHERE match_option_id='{$match_option_id}'");
	 
		$this->session->set_flashdata('msg', 'Rollback complete successfully');
		redirect('match_details/view/' . $match_id);
	}

 

	public function user_statement_details()
	{
		$post_id = $this->input->post('post_id');
		$type = $this->input->post('type');
		if ($type=="SingleBet") {
			$query = "SELECT mbc.*, mopd.option_title, mopd.match_id, mopd.match_option_id, mp.match_option_title, m.league_title, m.title, s.name FROM matchbit_coin AS mbc INNER JOIN match_option_details AS mopd ON mbc.match_bit_id=mopd.id INNER JOIN match_option AS mp ON mopd.match_option_id=mp.id INNER JOIN matchname AS m ON mopd.match_id=m.id INNER JOIN sportscategory AS s ON m.sportscategory_id=s.id WHERE mbc.bet_type = 'SINGLE_BET' AND mbc.id = '{$post_id}'";

			$data = $this->db->query($query)->result();

			if (!empty($data)) {

				echo json_encode($data);
			}
		} 		
	}







	/*************************************************************
	**************************************************************
	***														   ***	
	***						//MultiBet//					   ***	
	***						CodeCanyon.Net 					   ***	
	***														   ***	
	**************************************************************
	*************************************************************/



	public function show_bet_list() {
		$data = array();
		$bet_id = $this->uri->segment(2);
		$bet_details = $this->db->query("SELECT mop.match_option_title, m.league_title, m.title FROM match_option AS mop INNER JOIN matchname AS m ON mop.match_id=m.id WHERE mop.id='{$bet_id}'")->row();
		$data['bet_title'] = $bet_details->title . ' => ' . $bet_details->league_title . ' => ' . ' >> ' . $bet_details->match_option_title;

		$query_string = "SELECT mbc.*, mopd.option_title, mopd.match_id, mopd.match_option_id, mp.match_option_title, m.league_title, m.title, s.name FROM matchbit_coin AS mbc INNER JOIN match_option_details AS mopd ON mbc.match_bit_id=mopd.id INNER JOIN match_option AS mp ON mopd.match_option_id=mp.id INNER JOIN matchname AS m ON mopd.match_id=m.id INNER JOIN sportscategory AS s ON m.sportscategory_id=s.id WHERE mp.id='{$bet_id}' ORDER BY mbc.id DESC";
		$data['match_bit'] = $this->db->query($query_string)->result();
    	$this->load->view('admin/liveinplay/show_bet_list', $data);
	}

	public function multibets_data() {
		$data = [];
		$query_string = "SELECT m.*, u.username, c.club_name FROM multibet AS m INNER JOIN users AS u ON m.user_id=u.id INNER JOIN club_users AS c ON m.club_id=c.id ORDER BY m.created_at DESC";
		//$data['get_data'] = $this->db->query($query_string)->result();
		$this->load->view('admin/multibets/multibets_data', $data);
	}

	public function multibets_datatable()
	{
		$query = "SELECT m.*, u.username, c.club_name FROM multibet AS m INNER JOIN users AS u ON m.user_id=u.id INNER JOIN club_users AS c ON m.club_id=c.id ";

		if (isset($_POST["search"]["value"])) {
			$query .= ' AND
			 (u.username LIKE "%' . $_POST["search"]["value"] . '%"
			 OR c.club_name LIKE "%' . $_POST["search"]["value"] . '%")
			';
		}

		if (isset($_POST["order"])) {
			$columns = "";
			$query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$query .= 'ORDER BY m.created_at DESC ';
		}
		if ($_POST["length"] != -1) {
			$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		} else {
			$query1 = "";
		}

		$number_filter_row = $this->db->query($query)->num_rows();
		$fetch_data = $this->db->query($query . $query1)->result();
		$data = array();
		$i = 1;
		foreach ($fetch_data as $row) {
			$sub_array = array();
		 	$result_btn ="";
			if($row->status=='MATCH_RUNNING') {
    	        $result_able = $this->db->query("SELECT * FROM matchbit_coin WHERE bet_status='MATCH_RUNNING' AND match_bit_id IN({$row->option_detail_ids}) AND multi_bet_id = '{$row->id}' AND user_id='{$row->user_id}'")->result();
    	        if(empty($result_able)) { 
						$result_btn = "<a onclick=\"status_modal($row->id)\" class=\"status-modal btn btn-success btn-sm\" style=\"color:#FFF\" data-toggle=\"modal\" data-target=\"#updateStatusModal\" title=\"Set Result\">Result</a>";
    	        }
    	    }


    	    $bet_list_btn = "<a data-toggle=\"modal\" data-target=\"#multibetModal\" onclick=\"show_bets($row->id,$row->user_id)\" href=\"javascript:void(0);\" class=\"bet-btn btn btn-sm btn-primary\" style=\"color:#FFF\">Bet List</a>";

			$sub_array[] = $i;
			$sub_array[] = $row->username;
			$sub_array[] = $row->club_name;
			$sub_array[] = date("D j F Y, g.iA", strtotime($row->created_at));
			$sub_array[] = $row->total_stake;
			$sub_array[] = $row->total_coin;
			$sub_array[] = $row->possible_win;
			$sub_array[] = bet_history_status_color($row->status); 
			$sub_array[] = $bet_list_btn." ".$result_btn;
			$data[] = $sub_array;
			$i++;
		}
		$recordsTotal = $this->db->query("SELECT m.*, u.username, c.club_name FROM multibet AS m INNER JOIN users AS u ON m.user_id=u.id INNER JOIN club_users AS c ON m.club_id=c.id ")->num_rows();
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $recordsTotal,
			"recordsFiltered" => $number_filter_row,
			"data" => $data
		);
		echo json_encode($output);
	}

	public function ajax_multibet_details() {
		$id = $_POST['option_detail_ids'];
		$user_id = $_POST['user_id']; 
		$data = [];
		$get_bet = $this->db->query("SELECT * FROM multibet WHERE id='{$id}' AND user_id='{$user_id}'")->row();
		if(empty($get_bet)) {
			redirect($red);
			return;
		}
		$option_ids = $get_bet->option_detail_ids;
		$query_string = "SELECT mbc.*, mopd.option_title, mopd.match_id, mopd.match_option_id, mp.match_option_title, m.league_title, m.title, m.starting_time, s.name FROM matchbit_coin AS mbc INNER JOIN match_option_details AS mopd ON mbc.match_bit_id=mopd.id INNER JOIN match_option AS mp ON mopd.match_option_id=mp.id INNER JOIN matchname AS m ON mopd.match_id=m.id INNER JOIN sportscategory AS s ON m.sportscategory_id=s.id WHERE mbc.bet_type='MULTI_BET' AND mbc.match_bit_id IN({$option_ids}) AND mbc.user_id='{$user_id}' GROUP BY mbc.match_bit_id ORDER BY mbc.id DESC";
		$get_data = $this->db->query($query_string)->result();
		$data['get_data'] = $get_data;
		$view_data = $this->load->view('admin/multibets/ajax_multibet_details', $data, true);
		$new_data = [];
		$new_data['error'] = 0;
		$new_data['get_new_data'] = $view_data;
		$new_data['error_msg'] = "";
		echo json_encode($new_data);
	}

	public function set_multibet_result() {
		$red = $_SERVER['HTTP_REFERER'];
		$multibet_id = $_POST['multibet_id'];
		$status = $_POST['status'];

		if(!empty($multibet_id) && !empty($status)) {

			if($status=='WIN') {
				$data = $this->db->query("SELECT * FROM multibet WHERE id='{$multibet_id}'")->row();
				$possible_win = $data->possible_win;
				$current_balance = get_user_current_balance($data->user_id);
				$current_balance = $current_balance + $possible_win;

		        $data_arr = array(
		        	'user_id'			=> $data->user_id,
		        	'club_id'			=> $data->club_id,
		        	'coin'				=> $possible_win,
		        	'current_balance'	=> $current_balance,
		        	'coin_type'			=> 'BETWIN',
		        	'method'			=> 'GET',
		        	'multi_bet_id'		=> $multibet_id,
		        	'created_at'		=> date('Y-m-d H:i:s')
		        );
		        $this->db->insert('my_coin', $data_arr);
			}

			$this->db->query("UPDATE multibet SET status='{$status}' WHERE id='{$multibet_id}'");
			$this->session->set_flashdata('msg', 'Result published successfully');
			redirect($red);

		}
	}

	// updt:: 30-04
	public function user_balance_statement_update()
	{
		$u_id = $this->input->post("id"); 
		$get_bet_data = $this->db->query("SELECT id,current_balance AS bal, CASE WHEN method='GET' THEN coin ELSE 0 END AS Credit, CASE WHEN method='POST' THEN coin ELSE 0 END AS Debit FROM `my_coin` WHERE user_id = '{$u_id}' ORDER BY id ASC")->result();

		if (!empty($get_bet_data)) {
			foreach ($get_bet_data as $key => $value) {
				$bal = @($bal+$value->Credit-$value->Debit);
				$this->db->query("UPDATE my_coin SET current_balance='{$bal}' WHERE id='{$value->id}'");
			}
		}
		header('Content-Type: application/json');
		echo json_encode(array('st'=>200,'data'=>"Update Balance Is:: ".get_user_current_balance($u_id)));
		return;
	}

	public function updt($u_id)
	{
		$get_bet_data = $this->db->query("SELECT id,current_balance AS bal, CASE WHEN method='GET' THEN coin ELSE 0 END AS Credit, CASE WHEN method='POST' THEN coin ELSE 0 END AS Debit FROM `my_coin` WHERE user_id = '{$u_id}' ORDER BY id ASC")->result();

		if (!empty($get_bet_data)) {
			foreach ($get_bet_data as $key => $value) {
				$bal = @($bal+$value->Credit-$value->Debit);
				$this->db->query("UPDATE my_coin SET current_balance='{$bal}' WHERE id='{$value->id}'");
			}
		}
	}
 

}


