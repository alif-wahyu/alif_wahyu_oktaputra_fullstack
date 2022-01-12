<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class User extends CI_Controller {

	public function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");    
		$this->load->helper('url');
		$this->load->model('M_user');
		$this->load->model('M_article');
        $this->load->library('session'); 
		$this->load->library('pagination');
	}

	public function simpan_user() {
		if (!$_POST['username'] || !$_POST['password']) {
			redirect('/');
		}
		$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE);

		$user = $_POST['username'];
		$password = $_POST['password'];
		$phone = $_POST['phone'];
		$error_ar = [];
		
		$data = [
			'username' => $user,
			'password' => password_hash($password,PASSWORD_DEFAULT),
			'phone' => $phone
		];
		$ins_user = $this->db->insert('user',$data);
		if (!$ins_user) {
			$error_ar = [
				'pesan'	=> $this->db->_error_message()
			];
		}
		
		if (count($error_ar) > 0) {
			$res_data = [
				'status_code' => 100,
				'pesan' => $error_ar
			];
		} else {
			$this->db->trans_commit();
			$res_data = [
				'status_code' => 200
			];
		}
		echo json_encode($res_data, JSON_PRETTY_PRINT);
	}

    public function auth() {
        $q = $this->M_user->cekDataLogin($this->input->post('lusername'), $this->input->post('lpassword'));
        if ($q['status'] == 200) {
            foreach ($q['result'] as $dataUser) {
                $data_session = array(
                    'id' => $dataUser->id,
                    'username' => $dataUser->username,
                    'phone' => $dataUser->phone
                );
                $this->session->set_userdata('login_sess', $data_session);

                $last_url = base_url('user/article');
                redirect($last_url);
            }
        } else {
            $this->session->set_flashdata('message', 'Email/Password Salah!');
            redirect(base_url('/'));
        }
    }
    
	public function dashboard() {
		if (!$this->session->userdata('login_sess')) {
			redirect('/');
		}
		$data_session 		= $this->session->userdata('login_sess');
		$data['session']	= $data_session;
		$data['judul_tab'] 	= 'Beranda User';
		$data['judul_page'] = 'Beranda';
		$this->load->view('user/nav_bar/header',$data);
		$this->load->view('user/dashboard');
		$this->load->view('user/nav_bar/footer');
	}
    
	public function article() {
		if (!$this->session->userdata('login_sess')) {
			redirect('/');
		}
		$data_session 	= $this->session->userdata('login_sess');
		$filter 		= $this->input->get();
		if($_SERVER['QUERY_STRING'] != "") {
			$q_string = "?".$_SERVER['QUERY_STRING'];
		} else {
			$q_string = "";
		}
		
		$per_page = 10;
		if($this->uri->segment(3) != ""){
			$page = ($this->uri->segment(3));
		} else {
			$page = 1;
		}
		
		$total_rows = $this->M_article->record_count($filter, $data_session)->numrows;
		$config = array();
		$config["base_url"] 		= base_url('/user/article/');
		$config["suffix"] 			= $q_string;
		$config["first_url"] 		= base_url('/user/article/1').$q_string;
		$config["per_page"] 		= $per_page;
		$config["total_rows"] 		= $total_rows;
		$config["uri_segment"] 		= 4;
		$choice = $config["total_rows"] / $config["per_page"];
		$config["num_links"] 		= 2;
		$config['use_page_numbers'] = TRUE;
		$config['data_page_attr'] 	= ' class="page-link" ';
		$config['full_tag_open']    = '<ul class="pagination pagination-sm m-0 float-right">';
		$config['full_tag_close']   = '</ul><!--pagination-->';
		$config['first_link']     	= '&laquo; First';
		$config['first_tag_open']	= '<li class="page-item">';
		$config['first_tag_close']	= '</li>';
		$config['last_link']		= 'Last &raquo;';
		$config['last_tag_open']	= '<li class="page-item">';
		$config['last_tag_close']	= '</li>';
		$config['next_link']		= '&raquo;';
		$config['next_tag_open']	= '<li class="page-item">';
		$config['next_tag_close']	= '</li>';
		$config['prev_link']		= '&laquo;';
		$config['prev_tag_open']	= '<li class="page-item">';
		$config['prev_tag_close']	= '</li>';
		$config['cur_tag_open']		= '<li class="page-item active"><a class="page-link" style="pointer-events:none" href="">';
		$config['cur_tag_close']	= '</a></li>';
		$config['num_tag_open']		= '<li class="page-item">';
		$config['num_tag_close']	= '</li>';
		$this->pagination->initialize($config);

		$cur_page = $page;
		if ($cur_page == 0) {
			$cur_page = 1;
		} else {
			$cur_page = $page;
		}

		if($cur_page == 1) {
			$start = $cur_page;
		} else {
			if ($config["total_rows"] == 1) {
				$start = 1;
			} else {
				$start = (($cur_page - 1) * $this->pagination->per_page) + 1;
			}
		}

		if($cur_page * $this->pagination->per_page > $config["total_rows"]) {
			$end = $config["total_rows"];
		} else {
			if ($config["total_rows"] == 1) {
				$end = 1;
			} else {
				$end = (($cur_page * $this->pagination->per_page));
			}
		}

		$data_record            = $this->M_article->get_article($filter, $config["per_page"], $page, $data_session);
		$data['session']	    = $data_session;
		$data['judul_tab'] 	    = 'Article User';
		$data['judul_page']     = 'Article User';
		$data['download']       = $data_record;
		$data['data_session']   = $data_session;
		
		if(isset($_GET['cari'])) {	
			if(count($data_record) == 10) {
				$data["links"] = $this->pagination->create_links();
			} else if($this->uri->segment(4) != ""){
				if($this->uri->segment(4) > 1){
					$data["links"] = $this->pagination->create_links();
				}
			} 
			if(count($data_record) == 0) {
				$data["links"] = "";
				$data['pagination_info'] = "Data Tidak Ditemukan!";
			} else {
				$data["links"] = $this->pagination->create_links();
				$data['pagination_info'] = "Menampilkan ".$start." s/d ".$end." dari ".$config["total_rows"]." total data";
			}
		} else {
			if(count($data_record) != 0) {
				$data["links"] = $this->pagination->create_links();
				$data['pagination_info'] = "Menampilkan ".$start." s/d ".$end." dari ".$config["total_rows"]." total data";
			} else {
				$data["links"] = "";
				$data['pagination_info'] = "";
			}
		}
        
		$this->load->view('user/nav_bar/header',$data);
		$this->load->view('user/article',$data);
		$this->load->view('user/nav_bar/footer');
    }

	public function simpan_article() {
		if (!$_POST['title']) {
			redirect('user/article');
		}
		$this->db->trans_start();
		$this->db->trans_strict(FALSE);
		$data_session = $this->session->userdata('login_sess');
		$error_ar = [];
        
        $text = preg_replace('~[^\pL\d]+~u', '-', $_POST['title']);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            $text = 'n-a';
        }

		$data = [
			'title' => $_POST['title'],
			'content' => $_POST['content'],
			'slug' => $text,
		];
		$ins_data = $this->db->insert('article', $data);
		if (!$ins_data) {
			$error_ar[] = [
				'general_' => 'Gagal menyimpan ke dalam table article',
				'error' => $this->db->_error_message()
			];
		} else {
			$ins_data_id = $this->db->insert_id();
			if (isset($_FILES['file'])) {
				$target_file = FCPATH.'assets/image/';
				$nama_file = $ins_data_id.'.'.pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

				$update_data = [
					'image' => pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)
				];
				$this->db->where('id',$ins_data_id);
				$up_data = $this->db->update('article', $update_data);
				if (!$up_data) {
					$error_ar[] = [
						'general_' => 'Gagal mengupdate foto thumbnail ke dalam table article',
						'error' => $this->db->_error_message()
					];
				} else {
					move_uploaded_file($_FILES['file']['tmp_name'], $target_file.$nama_file);
				}
			}
		}

		if (count($error_ar) > 0) {
			$this->db->trans_rollback();
			$res_data = [
				'status_code' => 100,
				'pesan' => $error_ar
			];
		} 
		else {
			$this->db->trans_commit();
			$res_data = [
				'status_code' => 200,
				'pesan' => 'Status Berhasil Disimpan.',
				'tanggal' => date('Y-m-d H:i:s')
			];
		}
		echo json_encode($res_data, JSON_PRETTY_PRINT);
	}

	public function update_article() {
		if (!$_POST['title']) {
			redirect('user/article');
		}
		$this->db->trans_start();
		$this->db->trans_strict(FALSE);
		$data_session = $this->session->userdata('login_sess');
		$error_ar = [];
        
        $text = preg_replace('~[^\pL\d]+~u', '-', $_POST['title']);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            $text = 'n-a';
        }

		$data = [
			'title' => $_POST['title'],
			'content' => $_POST['content'],
			'slug' => $text,
		];
        $this->db->where('id',$_POST['id']);
        $ins_data = $this->db->update('article', $data);
		if (!$ins_data) {
			$error_ar[] = [
				'general_' => 'Gagal menyimpan ke dalam table article',
				'error' => $this->db->_error_message()
			];
		} else {
			if (isset($_FILES['file'])) {
				$target_file = FCPATH.'assets/image/';
				$nama_file = $_POST['id'].'.'.pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

				$update_data = [
					'image' => pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)
				];
				$this->db->where('id',$_POST['id']);
				$up_data = $this->db->update('article', $update_data);
				if (!$up_data) {
					$error_ar[] = [
						'general_' => 'Gagal mengupdate foto thumbnail ke dalam table article',
						'error' => $this->db->_error_message()
					];
				} else {
					move_uploaded_file($_FILES['file']['tmp_name'], $target_file.$nama_file);
				}
			}
		}

		if (count($error_ar) > 0) {
			$this->db->trans_rollback();
			$res_data = [
				'status_code' => 100,
				'pesan' => $error_ar
			];
		} 
		else {
			$this->db->trans_commit();
			$res_data = [
				'status_code' => 200,
				'pesan' => 'Status Berhasil Disimpan.',
				'tanggal' => date('Y-m-d H:i:s')
			];
		}
		echo json_encode($res_data, JSON_PRETTY_PRINT);
	}

    public function hapus_artikel() {
        if (!$_POST['id']) {
			redirect('user/article');
		}
		$this->db->trans_start();
		$this->db->trans_strict(FALSE);
		$error_ar = [];
        $up_data = $this->db->delete('article', array('id' => $_POST['id']));
        if (!$up_data) {
            $error_ar[] = [
                'general_' => 'Gagal menghapus artikel',
                'error' => $this->db->_error_message()
            ];
        }
        if (count($error_ar) > 0) {
			$this->db->trans_rollback();
			$res_data = [
				'status_code' => 100,
				'pesan' => $error_ar
			];
		} 
		else {
			$this->db->trans_commit();
			$res_data = [
				'status_code' => 200,
				'pesan' => 'Status Berhasil Disimpan.',
				'tanggal' => date('Y-m-d H:i:s')
			];
		}
		echo json_encode($res_data, JSON_PRETTY_PRINT);
    }

	public function get_article_by_id() {
		if (!$_POST['id']) {
			redirect('user/article');
		}
		$q = $this->M_article->get_article_by_id($_POST['id']);
		echo json_encode($q, JSON_PRETTY_PRINT);
	}

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url('/'));
    }
}?>
