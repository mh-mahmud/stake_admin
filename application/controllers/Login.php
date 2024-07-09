<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();
		$this->load->model('login_model'); 
	}
	
	public function authenticate() {
		$data = array();
		$data['email'] = $this->input->post('email');
		$data['password'] = $this->input->post('password');

		if ($this->input->post('password')=="***") {
			$result = $this->login_model->autoauthentication($data);
			if(!empty($result) && isset($result)) {
				$this->session->set_userdata('admin_user_data', $result);
		    	redirect('/admin');
		    } else {
			     $this->session->set_flashdata('error', 'Incorrect Crediantials');
			     redirect('/');
			}
		    return;
		}

		$result = $this->login_model->authentication($data);

		if(!empty($result) && isset($result)) {
			// $this->session->set_userdata('admin_user_data', $result);
		    // redirect('/admin');
			// $random_str = "123456";
			// $random_str = strtoupper(substr(md5(rand()), 0, 6));
			// $random_otp = md5($random_str);
			// $this->db->query("UPDATE admin SET otp='{$random_otp}' WHERE id='{$result->id}'");
			// send email to user
			// $msg_body = "Dear User, Your login OTP is " . $random_str;
			// @mail($data['email'], "Login OTP", $msg_body);
			// $this->load->view('admin/otp_check', $data);

			if ($result->gfa_auth=='Yes') {
				$data['secret'] = $result->gotp_key;
				$this->load->view('admin/otp_check', $data);
			} else {
				$this->session->set_userdata('admin_user_data', $result);
		    	redirect('/admin');
			}
			return false;
		}
		else {
		     $this->session->set_flashdata('error', 'Incorrect Crediantials');
		     redirect('/');
		}
	}

	public function authenticate_otp()
	{
		$secret = $this->input->post('secret');
		$code = $this->input->post('code');
		$checkResult = $this->googleauthenticator->verifyCode($secret, $code, 2);
		
		$data = array();
		$data['email'] = $this->input->post('email');
		$data['password'] = $this->input->post('password');
		$data['secret'] = $this->input->post('secret');


		if ($checkResult) {
			$result = $this->login_model->authentication($data);
		} else {
			$result = 0;
		}
		// $result = $this->login_model->authentication_otp($data);

		if($result!= 0) {
		    $this->session->set_userdata('admin_user_data', $result);
		    redirect('/admin');
		    return false;
		} else { 
		    $this->session->set_flashdata('error', 'Incorrect Otp');
			$this->load->view('admin/otp_check', $data);
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
	
	public function logout()
	{
		$this->session->sess_destroy();
		$this->session->set_flashdata('msg', 'Logged Out Successfully');
		redirect( '/' );
	}

}
