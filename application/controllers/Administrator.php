<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {
	public function index()
		{	
			$data['contents'] = 'user/car';
			$this->load->view('user/index',$data);
		}
}
