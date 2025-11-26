<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author 		Oky Octaviansyah <oky.octaviansyah@yahoo.co.id>
 * @modified 	Maulana Rahman <maulana.code@gmail.com>
*/

class Api extends CI_Controller {

	//private $privilege;

	public function __construct()
	{
		parent::__construct();
		//$this->load->model('Api_model','model');
	}

	public function index()
	{
		echo "Server API Worked";
	}

	public function login()
    {       
        $this->form_validation->set_rules('token' , 'TOKEN', 'required|trim|max_length[25]');
        $this->form_validation->set_rules('email' , 'Email', 'required|trim|max_length[40]|valid_email');
        $this->form_validation->set_rules('password' , 'Password', 'required|trim|min_length[5]');

        if ($this->form_validation->run() == true)
        {
	        if( base64_decode($this->input->post('token', TRUE)) != "ALUS".date('Y-m-d'))
	        {
	          header('HTTP/1.1 401 Unauthorized');
	          header('Content-type: application/json');
	          echo json_encode(array("status" => FALSE, "msg" => "TOKEN INVALID"));
	          exit();
	        }
	        
	        if ($this->alus_auth->login($this->input->post('email',TRUE), $this->input->post('password',TRUE)))
			{
				$this->alus_auth->clear_login_attempts($this->input->post('identity'));
				$query = $this->db->select('*')
		                  ->where('abc', $this->alus_auth->encrypt($this->input->post('email',TRUE)))
		                  ->limit(1)
		    			  ->order_by('id', 'desc')
		                  ->get('alus_u')->row();

		        $data_user = [
		        	'id' 		=> $query->id,
		        	'username'	=> $query->username,
		        	'email'		=> $this->alus_auth->decrypt($query->abc),
		        	'first_name'=> $query->first_name,
		        	'last_name'	=> $query->last_name,
		        	'phone'		=> $query->phone,
		        	'picture'	=> base_url().'assets/avatar/'.$query->picture,
		        	'active'	=> $query->active
		        ];

		        header('HTTP/1.1 200 OK');
	        	header('Content-type: application/json');
    			echo json_encode(array("status" => TRUE, "msg" => "Selamat Datang", "data_user" => $data_user));
    			exit();
			}else
			{
	          	header('HTTP/1.1 401 Unauthorized');
	          	header('Content-type: application/json');
    			echo json_encode(array("status" => FALSE,"msg" => "Email / Password tidak sesuai"));
    			exit();
			}

	    }else{
	          header('HTTP/1.1 400 Bad Request');
	          header('Content-type: application/json');
	          echo json_encode(array("status" => FALSE,"msg" => validation_errors()));
	          exit();
	        }
	    }
}

/* End of file Api.php */
/* Location: ./application/modules/api/controllers/Api.php */