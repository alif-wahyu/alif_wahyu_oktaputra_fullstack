<?php
class M_api extends CI_model {
		function __construct()
		{
			// call the model constructur
            parent::__construct();
            $this->erp = $this->load->database('default',TRUE);
            $this->erp->db_debug = FALSE;
            error_reporting(1);
        }

		function get_article()
		{
			$this->erp->select('*');
            $this->erp->from('article');
            $dt = $this->erp->get();
            return $dt;			
		}

		function get_article_by_id($id)
		{
			$this->erp->select('*');
            $this->erp->from('article');
            $this->erp->where('id',$id);
            $dt = $this->erp->get()->row();
            return $dt;			
		}
        
} ?>