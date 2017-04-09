<?php
class gallery extends CI_Controller {
	 function __construct(){
        parent::__construct();
        $this->load->helper('json');
    }

	public function view($tags, $current_page){
		
		$tags = urldecode($tags);

    	$page_size = 50;
		$start_row = ($current_page - 1) * $page_size;
		$end_row = $current_page * $page_size;


		$tags = preg_replace ("/ +/", "','", $tags);

		$this->db->select('*');
		$this->db->from('images');
		$this->db->where("tags @> array['". $tags ."']", null, false);

		$row_count = $this->db->count_all_results();
		$total_pages = ceil($row_count/$page_size);

		$this->db->select('*');
		$this->db->from('images');
		$this->db->where("tags @> array['". $tags ."']", null, false);
		$this->db->order_by('image_id','desc');
		$this->db->limit($page_size,$start_row);
		
		$images = $this->db->get()->result_array();

		for($index = 0; $index < sizeof($images); $index++){
			$tags = $images[$index]['tags'];
			$tags = preg_replace('/[\{\}]/','',$tags);
			$images[$index]['tags'] =  explode(',',$tags);
		}
		
		$result = [
			'page_size' => $page_size,
			'current_page' => $current_page,
			'total_pages' => $total_pages,
			'images' => $images 
		];

		return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(camel_case_json($result));
    }
 }