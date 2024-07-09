<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Morequestion extends CI_Controller
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

	public function match_option_save()
	{
		$data = array();
		$data['save_match'] = $this->db->query("SELECT bq.*,s.name FROM `more_bet_question` AS bq INNER JOIN sportscategory AS s ON bq.sports_id=s.id ORDER BY bq.sports_id ASC")->result();
		$this->load->view('admin/extra_settings/more_match_option_save', $data);
	}

	public function new_question_form()
	{
		$data = array();
		$data['sport_ids'] = $this->db->query("SELECT * FROM `sportscategory` ORDER BY serial ASC")->result();
		$this->load->view('admin/common/header');
		$this->load->view('admin/extra_settings/more_create_new_bet_question', $data);
	}

	public function save_bet_question()
	{
		$data_arr = array(
			'sports_id' => $_POST['sport_id'],
			'option_title' => $_POST['option_title'], 
			'status' => "Active"
		);
		$this->db->insert('more_bet_question', $data_arr);
		$last_id = $this->db->insert_id(); 

		for ($i = 1; $i <= count($_POST['question']); $i++) {

			for ($ii = 0; $ii < count($_POST['question_option'][$i]); $ii++) {

				$data_arrr = array(
					'sports_id' => $_POST['sport_id'],
					'question_id' => $last_id,
					'question_title' => $_POST['question'][$i],
					'question_title_serial' => $_POST['question_serial'][$i],
					'option_title' => $_POST['question_option'][$i][$ii],
					'option_coin' => $_POST['option_coin'][$i][$ii],
					'multi_option_coin' => $_POST['multi_option_coin'][$i][$ii],
					'option_serial' => $_POST['option_serial'][$i][$ii],
					'status' => "Active"
				);
				$this->db->insert('more_bet_question_option', $data_arrr);
			}
		}
		echo json_encode(array('st' => 200, 'msg' => 'Successfully Add New Question'));
	}

	public function match_option_view()
	{
		$data = array();
		$data['bet_question_id'] = $this->uri->segment(2);
		$data['option_title'] = $this->db->query("SELECT option_title FROM `more_bet_question` WHERE id = '{$this->uri->segment(2)}' ORDER BY id ASC LIMIT 1")->row()->option_title;
		$data['bet_question_sports_id'] = $this->db->query("SELECT sports_id FROM `more_bet_question` WHERE id = '{$this->uri->segment(2)}' ORDER BY id ASC LIMIT 1")->row()->sports_id;
		$data['sport_ids'] = $this->db->query("SELECT * FROM `sportscategory` ORDER BY serial ASC")->result();
		$this->load->view('admin/common/header');
		$this->load->view('admin/extra_settings/more_match_option_view', $data);
	}

	public function edit_bet_question(){
		$this->db->query("DELETE FROM more_bet_question WHERE id = '{$_POST['question_old_id']}' ");
		$this->db->query("DELETE FROM more_bet_question_option WHERE question_id = '{$_POST['question_old_id']}' ");

		$data_arr = array(
			'sports_id' => $_POST['sport_id'],
			'option_title' => $_POST['option_title'], 
			'status' => "Active"
		);
		$this->db->insert('more_bet_question', $data_arr);
		$last_id = $this->db->insert_id(); 

		for ($i = 1; $i <= count($_POST['question']); $i++) {

			for ($ii = 0; $ii < count($_POST['question_option'][$i]); $ii++) {

				$data_arrr = array(
					'sports_id' => $_POST['sport_id'],
					'question_id' => $last_id,
					'question_title' => $_POST['question'][$i],
					'question_title_serial' => $_POST['question_serial'][$i],
					'option_title' => $_POST['question_option'][$i][$ii],
					'option_coin' => $_POST['option_coin'][$i][$ii],
					'multi_option_coin' => $_POST['multi_option_coin'][$i][$ii],
					'option_serial' => $_POST['option_serial'][$i][$ii],
					'status' => "Active"
				);
				$this->db->insert('more_bet_question_option', $data_arrr);
			}
		}
		echo json_encode(array('st' => 200, 'msg' => 'Successfully Updated Question'));
	}

	public function status_change_for_bet_question(){
		$this->db->query("UPDATE more_bet_question SET status = '{$this->uri->segment(2)}' WHERE sports_id = '{$this->uri->segment(3)}'");
		$this->db->query("UPDATE more_bet_question_option SET status = '{$this->uri->segment(2)}' WHERE sports_id = '{$this->uri->segment(3)}'");
		$this->session->set_flashdata('msg', 'Successfully status Updated');
		redirect('more_match_option_save');
	}

	public function get_match_saved_question(){
		$data = array();
		$data['match_id'] = $this->uri->segment(3);
		$data['question_id'] = $this->uri->segment(4);
		$data['team_title'] = $this->db->query("SELECT title FROM `matchname` WHERE id='{$this->uri->segment(3)}'")->row()->title;
		$data['option_title'] = $this->db->query("SELECT option_title FROM `more_bet_question` WHERE id='{$this->uri->segment(4)}'")->row()->option_title;
		$this->load->view('admin/common/header');
		$this->load->view('admin/more_ajax_save_question',$data);
		 
	}
}