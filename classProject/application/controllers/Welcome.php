<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ClassModel');
        $this->load->model('CommonModel');
        $this->load->config('myconfig');
    }
    public function index()
    {
    	$return_data = $this->ClassModel->getSubjectList();
    	$grade = $this->config->item('grade');
    	$subject = array();
    	foreach ($return_data as $value) {
    		$subject[$value['Grade']][] = $value;
    	}
    	$data['subject'] = $subject;
    	$data['grade'] = $grade;
        $this->load->view('WelcomePage',$data);
    }
}
