<?php
class gallery extends CI_Controller {
	public function index(){
		$view_data = [
    		'content' => 'pages/search',
    		'tags' => []
    	];

    	$this->db->select('*');
    	$this->db->from('tags');
		$this->db->order_by('count','desc');
		$this->db->limit(50,0);

		$view_data['tags'] = $this->db->get()->result_array();

		$this->load->view('layout', $view_data);
	}

	public function view($tags, $current_page = 1){
		$tags = urldecode($tags);
    	$view_data = [
    		'content' => 'pages/gallery',
    		'tags' => $tags,
    		'current_page' => $current_page,
    	];
		$this->load->view('layout', $view_data);
    }
}