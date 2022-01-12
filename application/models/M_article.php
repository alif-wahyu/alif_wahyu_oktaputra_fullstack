<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_article extends CI_Model {

    public function get_article($filter, $limit, $page, $data_session) {
        if ($page != 1) {
			$offset = (($page-1) * $limit);
		} else {
			$offset = $page-1;
		}
		
		if ($limit != -1) {
			$this->db->limit($limit, $offset);
		}
        $this->db->select('a.*');
        $this->db->from('article a');
		$this->db->order_by('a.created_at','desc');
		
        if (isset($filter['judul']) && $filter['judul'] != "") {
			$this->db->where('a.title LIKE', '%'.$filter['judul'].'%');
		}
		
        $query = $this->db->get();
        return $query->result();
    }

    public function record_count($filter, $data_session) {
        $this->db->select('count(id) as numrows');
        $this->db->from('article');
		$this->db->order_by('created_at','desc');
		
        if (isset($filter['judul']) && $filter['judul'] != "") {
			$this->db->where('title LIKE', '%'.$filter['judul'].'%');
		}

        $query = $this->db->get();
        return $query->row();
	}
	
	public function get_article_by_id($id) {
		$this->db->select('*');
		$this->db->from('article');
		$this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
	}
}?>