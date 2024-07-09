<?php

class Login_model extends CI_Model {

	public function authentication($data)
	{
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where('email', $data['email']);
		$this->db->where('password', md5($data['password']));
		$this->db->where('status', 1);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}

	public function autoauthentication($data)
	{
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where('email', $data['email']); 
		$this->db->where('status', 1);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}

	public function authentication_otp($data)
	{
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where('email', $data['email']);
		$this->db->where('otp', md5($data['password']));
		$this->db->where('status', 1);
		$query = $this->db->get();
		$result = $query->row();		
		return $result;
	}
}