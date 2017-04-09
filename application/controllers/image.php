<?php
class image extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
    }

    public function view($image_id){
    	$view_data = [
    		'content' => 'pages/view',
    		'image_id' => $image_id,
    		'tags' => []
    	];

        $view_data['image_data'] = $this->get_image_data($image_id);
    	$view_data['tags'] = $this->get_tags_from_db($image_id, null);
        $this->load->view('layout', $view_data);
    }

    public function delete($image_id){
        $view_data = [
            'content' => 'pages/gallery'
        ];

        $this->db->select('file_name');
        $this->db->from('images');
        $this->db->where('image_id',$image_id);

        $file_name = $this->db->get()->row_array()['file_name'];

        $this->db->where('image_id',$image_id);
        $this->db->delete('images');

        unlink( $_SERVER['DOCUMENT_ROOT'] . '/static/collections/' . $file_name);

        $this->load->view('layout', $view_data);
        $this->load->helper('url');


        redirect('/gallery/');
    }

    public function edit_tags(){
    	$image_id = $this->input->post('image_id');
    	$submitted_tags = $this->input->post('submitted_tags');
        $tags = $this->get_tags_from_db($new_id, $submitted_tags);

        $this->save_tags_to_db($image_id, $tags);
        redirect('/image/view/' . $image_id);
    }

    public function submit(){
    	if($this->input->method()=='post'){
            $this->submit_post();
    	}

    	if($this->input->method()=='get'){
    		$this->submit_get();
    	}
    }

    private function submit_get(){
        $view_data = ['content' => 'pages/submit'];

        $this->load->helper(['form', 'url']);
        $this->load->library('form_validation');
        $this->load->view('layout', $view_data);
    }

    private function submit_post(){
        
        $original_file_name = '';
        $original_file_path = $_SERVER['DOCUMENT_ROOT'] . '/static/collections_temp/';

        if (empty($_FILES['image_file']['name'])) {
            $image_url = $this->input->post('image_url');
            $original_file_name = basename($image_url);
            $original_file_path .= $original_file_name; 
            $input_stream = fopen($image_url, 'r');
            file_put_contents($original_file_path, $input_stream);
        } else {
            $original_file_name = $_FILES['image_file']['name'];
            $original_file_path .= $original_file_name;
            move_uploaded_file($_FILES['image_file']['tmp_name'], $original_file_path);
        }

        $file_hash = md5_file($original_file_path);
        $extension = pathinfo($original_file_name, PATHINFO_EXTENSION);

        $new_file_name = $file_hash . '.' . $extension;
        $new_file_path = $_SERVER['DOCUMENT_ROOT'] . '/static/collections/' . $new_file_name;
        $new_id = $this->db->query("select nextval('pictures_imageid_seq')")->row_array()['nextval'];
        
        rename($original_file_path, $new_file_path);

        $source = $this->input->post('source');

        //Check duplicates
        $image_duplicates = $this->get_image_duplicate($file_hash);

        if(sizeof($image_duplicates)>0){
            $image_duplicate = $image_duplicates[0];
            $new_id = $image_duplicate['image_id'];
            $image_data = [
                'original_url' => $image_url,
                'original_file_name' => $original_file_name,
                'source' => $source
            ];
            $this->db->where('image_id', $new_id);
            $this->db->update('images', $image_data);
        } else {
            $image_size = getimagesize($new_file_path);
            $image_data = [
                'original_url' => $image_url,
                'original_file_name' => $original_file_name,
                'image_id' => $new_id,
                'file_hash' => $file_hash,
                'extension' => $extension,
                'source' => $source,
                'width' => $image_size[0],
                'height' => $image_size[1],
                'checked' => false
            ];
            $this->db->insert('images', $image_data); 
        }

        $submitted_tags = $this->input->post('submitted_tags');
        $tags = $this->get_tags_from_db($new_id, $submitted_tags);
        $this->save_tags_to_db($new_id, $tags);

        redirect('/image/view/' . $new_id);
    }

    private function get_image_duplicate($file_hash){
        $this->db->from('images');
        $this->db->where('file_hash', $file_hash);
        return $this->db->get()->result_array();
    }

    private function get_tags_from_db($image_id, $submitted_tags){

        $this->db->select("array_to_string(tags, ' ') tags");
        $this->db->from('images');
        $this->db->where('image_id',$image_id);

        $raw_tags = $this->db->get()->row_array()['tags']; 
        
        $tags = [];

        if(!empty($submitted_tags)) {
            $submitted_tags = urldecode($submitted_tags);
            $submitted_tags = strtolower($submitted_tags);
            $raw_tags .= $submitted_tags; 
        }

        $raw_tags = trim($raw_tags);
        $raw_tags = preg_split('/[ \r\n\t]+/', $raw_tags);

        foreach ($raw_tags as $raw_tag) {
            if(!in_array($raw_tag, $tags)){
                $tags[] = $raw_tag;
            }
        }

        return implode(' ', $tags);
    }

    private function save_tags_to_db($image_id, $tags){
        $this->db->set('tags', "string_to_array( '" . $tags . "' , ' ')", FALSE);
        $this->db->where('image_id', $image_id);
        $this->db->update('images');
    } 

    private function get_image_data($image_id){
    	$this->db
    		->select('*')
    		->from('images')
    		->where('image_id',$image_id);
        $image_data = $this->db->get()->row_array();
        $image_data['file_name'] = $image_data['file_hash'] . '.' . $image_data['extension'];
    	return  $image_data;
    }
}