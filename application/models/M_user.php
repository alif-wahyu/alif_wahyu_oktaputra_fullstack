<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {

	public function cekDataLogin($username, $password) {
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('username', $username);
		$q = $this->db->get();
        
		if($q->num_rows() > 0){
			if (password_verify($password, $q->row()->password)) {
				return array('status' => 200, 'result' => $q->result());
			} else {
				return array('status' => 101,'result' => 'username atau password salah');
			}
		} else {
			return array('status' => 100,'result' => 'username atau password salah');
		}
	}

	
	public function check_email($mail) {
        $this->db->select('a.id,b.nama_karyawan');
        $this->db->from('user a');
        $this->db->join('karyawan b','b.id = a.karyawan_id');
        $this->db->where('a.email',$mail);
        $query = $this->db->get();
        return $query->result();
	}

	public function get_user_by_id($id) {
        $this->db->select('a.*,b.nama_karyawan,b.npp');
        $this->db->from('user a');
        $this->db->join('karyawan b','a.karyawan_id = b.id');
        $this->db->where('a.id',$id);
        $query = $this->db->get();
        return $query->row();
	}

} ?>