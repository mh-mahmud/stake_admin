<?php

class User_model extends CI_Model {

	public function authentication($data)
	{
		/*$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email', $data['email'])->or_where('username', $data['email']);
		$this->db->where('password', md5($data['password']));
		$this->db->where('status', 1);
		$query = $this->db->get();
		$result = $query->row();*/
		$email = $data['email'];
		$password = md5($data['password']);
		// $result = $this->db->query("SELECT * FROM users WHERE (email='{$email}' OR username='{$email}') AND password='{$password}' AND status=1")->row();
		$result = $this->db->query("SELECT * FROM users WHERE email='{$email}' AND password='{$password}' AND status=1")->row();
		return $result;
	} 
	
	public function get_user_by_email($email)
	{
		$this->db->select('*');
		$this->db->where('email', $email);
		$this->db->from('users');
		$query = $this->db->get();
		$result = $query->row();
		
		return $result;
	}  
}