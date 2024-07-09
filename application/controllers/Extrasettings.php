<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Extrasettings extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
		$this->load->helper('betscore');
		$this->load->helper('form');
		$this->load->helper('url');
		if (empty($this->session->userdata('admin_user_data'))) {
			redirect('/');
		}
	}

	public function index()
	{

	}

	public function sports_icon()
	{
		$data = array();
		$data['title'] = 'Manage Sports Icon';
		$data['sports_icon'] = $this->db->query("SELECT * FROM `sports_icon`")->result();
		$this->load->view('admin/extra_settings/sports_icon', $data);
	}

	public function sports_icon_upload()
	{

		if (isset($_FILES["image_file"]["name"])) {
			$config['upload_path'] = './assets/img/icon/';
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
				$this->db->query("INSERT INTO sports_icon VALUES (null,'$file_name','1')");
				echo '<img src="' . base_url() . 'assets/img/icon/' . $file_name . '" width="100" height="100" class="img-thumbnail" />';
			}
		}

	}

	public function sports_icon_status_change()
	{
		$sports_id = $this->input->post('id');
		$status_change = $this->input->post('status');
		if (isset($sports_id) && isset($status_change)) {
			if ($this->db->query("UPDATE sports_icon SET status='$status_change' WHERE id ='$sports_id'")) {
				echo json_encode(array('st' => 200, 'msg' => 'Successfully update status'));
			} else {
				echo json_encode(array('st' => 400, 'msg' => 'Error! something worng'));
			}
		}
	}

	public function sports_icon_delete()
	{
		$del_id = $this->input->post('id');
		$icon_name = $this->db->query("SELECT file_name FROM sports_icon WHERE id='{$del_id}'")->row()->file_name;
		if (!empty($del_id) && $icon_name) {
			if ($this->db->query("DELETE FROM sports_icon WHERE id = '$del_id'")) {
				$imagePath = './assets/img/icon/';
				unlink($imagePath . $icon_name);
				echo json_encode(array('st' => 200));
			}
		}
	}

 

	public function slider_banner()
	{
		$data = array();
		$data['title'] = 'Manage Sports Icon';
		$data['slider'] = $this->db->query("SELECT * FROM `slider_banner`")->result();
		$this->load->view('admin/extra_settings/slider_banner', $data);
	}

	public function sports_slider_upload()
	{

		if (isset($_FILES["image_file"]["name"])) {
			$slider_serial = $this->input->post('slider_serial');
			$config['upload_path'] = './assets/img/slider/';
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
				$this->db->query("INSERT INTO slider_banner VALUES (null,'$file_name','$slider_serial','1')");
				echo '<img src="' . base_url() . 'assets/img/slider/' . $file_name . '" width="200" height="200" class="img-thumbnail" />';
			}
		}

	}

	public function sports_slider_status_change()
	{
		$sports_id = $this->input->post('id');
		$status_change = $this->input->post('status');
		if (isset($sports_id) && isset($status_change)) {
			if ($this->db->query("UPDATE slider_banner SET status='$status_change' WHERE id ='$sports_id'")) {
				echo json_encode(array('st' => 200, 'msg' => 'Successfully update status'));
			} else {
				echo json_encode(array('st' => 400, 'msg' => 'Error! something worng'));
			}
		}
	}

	public function sports_slider_delete()
	{
		$del_id = $this->input->post('id');
		$icon_name = $this->db->query("SELECT file_name FROM slider_banner WHERE id='{$del_id}'")->row()->file_name;
		if (!empty($del_id) && $icon_name) {
			if ($this->db->query("DELETE FROM slider_banner WHERE id = '$del_id'")) {
				$imagePath = './assets/img/slider/';
				unlink($imagePath . $icon_name);
				echo json_encode(array('st' => 200));
			}
		}
	}

	public function match_option_save()
	{
		$data = array();
		$data['save_match'] = $this->db->query("SELECT bq.*,s.name FROM `bet_question` AS bq INNER JOIN sportscategory AS s ON bq.sports_id=s.id GROUP BY bq.sports_id ORDER BY bq.sports_id ASC")->result();
		$this->load->view('admin/extra_settings/match_option_save', $data);
	}

	public function new_question_form()
	{
		$data = array();
		$data['sport_ids'] = $this->db->query("SELECT * FROM `sportscategory` ORDER BY serial ASC")->result();
		$this->load->view('admin/common/header');
		$this->load->view('admin/extra_settings/create_new_bet_question', $data);
	}

	public function save_bet_question()
	{
		for ($i = 1; $i <= count($_POST['question']); $i++) {
			$data_arr = array(
				'sports_id' => $_POST['sport_id'],
				'question' => $_POST['question'][$i],
				'serial' => $_POST['question_serial'][$i],
				'status' => "Active"
			);
			$this->db->insert('bet_question', $data_arr);
			$last_id = $this->db->insert_id();

			for ($ii = 0; $ii < count($_POST['question_option'][$i]); $ii++) {

				$data_arrr = array(
					'sports_id' => $_POST['sport_id'],
					'question_id' => $last_id,
					'option_title' => $_POST['question_option'][$i][$ii],
					'option_coin' => $_POST['option_coin'][$i][$ii],
					'multi_option_coin' => $_POST['multi_option_coin'][$i][$ii],
					'option_serial' => $_POST['option_serial'][$i][$ii],
					'status' => "Active"
				);
				$this->db->insert('bet_question_option', $data_arrr);
			}
		}
		echo json_encode(array('st' => 200, 'msg' => 'Successfully Add New Question'));
	}

	public function match_option_view()
	{
		$data = array();
		$data['bet_question_sports_id'] = $this->uri->segment(2);
		$data['sport_ids'] = $this->db->query("SELECT * FROM `sportscategory` ORDER BY serial ASC")->result();
		$this->load->view('admin/common/header');
		$this->load->view('admin/extra_settings/match_option_view', $data);
	}

	public function edit_bet_question(){
		$this->db->query("DELETE FROM bet_question WHERE sports_id = '{$_POST['sports_old_id']}' ");
		$this->db->query("DELETE FROM bet_question_option WHERE sports_id = '{$_POST['sports_old_id']}' ");

		for ($i = 1; $i <= count($_POST['question']); $i++) {
			$data_arr = array(
				'sports_id' => $_POST['sport_id'],
				'question' => $_POST['question'][$i],
				'serial' => $_POST['question_serial'][$i],
				'status' => "Active"
			);
			$this->db->insert('bet_question', $data_arr);
			$last_id = $this->db->insert_id();

			for ($ii = 0; $ii < count($_POST['question_option'][$i]); $ii++) {

				$data_arrr = array(
					'sports_id' => $_POST['sport_id'],
					'question_id' => $last_id,
					'option_title' => $_POST['question_option'][$i][$ii],
					'option_coin' => $_POST['option_coin'][$i][$ii],
					'multi_option_coin' => $_POST['multi_option_coin'][$i][$ii],
					'option_serial' => $_POST['option_serial'][$i][$ii],
					'status' => "Active"
				);
				$this->db->insert('bet_question_option', $data_arrr);
			}
		}
		echo json_encode(array('st' => 200, 'msg' => 'Successfully Updated Question'));
	}

	public function status_change_for_bet_question(){
		$this->db->query("UPDATE bet_question SET status = '{$this->uri->segment(2)}' WHERE sports_id = '{$this->uri->segment(3)}'");
		$this->db->query("UPDATE bet_question_option SET status = '{$this->uri->segment(2)}' WHERE sports_id = '{$this->uri->segment(3)}'");
		$this->session->set_flashdata('msg', 'Successfully status Updated');
		redirect('match_option_save');
	}

	public function get_match_saved_question(){
		$data = array();
		$data['match_id'] = $this->uri->segment(3);
		$data['sports_id'] = $this->uri->segment(4);
		$get_sp_qs = $this->db->query("SELECT sports_id FROM `bet_question_option` WHERE sports_id='{$this->uri->segment(4)}'")->result();
		if (!empty($get_sp_qs)){
			$data['team_title'] = $this->db->query("SELECT title FROM `matchname` WHERE id='{$this->uri->segment(3)}'")->row()->title;
			$this->load->view('admin/common/header');
			$this->load->view('admin/ajax_saved_match_show',$data);
		}
		else {
			$this->session->set_flashdata('msg', 'No data found');
			redirect("match_details/view/".$this->uri->segment(3));
		}
	}

	public function total_statement(){
		$data = array();
		$this->load->view("admin/report/total_statement",$data);
	}

 

	public function get_flag_icon_by_name()
	{
		$icon_name = $this->input->post("icon_name");

		$team_icon = $this->db->query("SELECT * FROM `team_icon` WHERE status='1' AND name LIKE '%{$icon_name}%' LIMIT 1")->result();
		$data = array();
		if ($team_icon) 
		{	
			foreach ($team_icon as $key => $value) 
			{
				$data = array('file_name' => $value->file_name,'img' => '<img src="' . base_url() . 'assets/img/flag/' . $value->file_name . '" width="100" height="100" class="img-thumbnail" />' );
			}
			echo json_encode($data);
		}
	}

	public function icon_flag_name_ajax_call()
	{
		$icon_name = $this->input->post("icon_name");
		$data_query = $this->db->query("SELECT name FROM `team_icon` WHERE name LIKE '$icon_name%'")->result();
		$data = array();
		if (!empty($data_query)) {
			foreach ($data_query as $val) {
				$data[] = $val->name;
			}
		}
		echo json_encode($data);
	}




}
