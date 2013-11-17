<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
	'account/create_new_user' => array(
		array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'required|is_unique[user.login]|min_length[3]|max_length[20]'
		),
		array(
			'field' => 'first',
			'label' => 'First',
			'rules' => 'required|max_length[20]'
		),
		array(
			'field' => 'last',
			'label' => 'Last',
			'rules' => 'required|max_length[20]'
		),
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|valid_email|max_length[120]|is_unique[user.email]'
		),
		array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'required|min_length[6]'
		),
		array(
			'field' => 'passconf',
			'label' => 'Password Confirmation',
			'rules' => 'required|min_length[6]|matches[password]'
		)
	),

	'account/create_new_client' => array(
		
		array(
			'field' => 'partnername',
			'label' => 'Partnername',
			'rules' => 'required|max_length[60]'
		),
		
		array(
			'field' => 'managerposition',
			'label' => 'Managerposition',
			'rules' => 'required|max_length[60]'
		),
		
		array(
			'field' => 'programfc',
			'label' => 'Programfc',
			'rules' => 'required|max_length[60]'
		),
		
		array(
			'field' => 'fcposition',
			'label' => 'Fcposition',
			'rules' => 'required|max_length[60]'
		),
		
		array(
			'field' => 'address',
			'label' => 'Address',
			'rules' => 'required'
		),
		
		array(
			'field' => 'phone',
			'label' => 'Phone',
			'rules' => 'required|regex_match[/^([a-zA-Z]+[:]{1})?\d{3}\-\d{3}\-\d{4}$/]'
		),
			
		array(
			'field' => 'fax',
			'label' => 'Fax'
		),
		
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|max_length[120]|valid_email|is_unique[client.email]'
		),
		
		array(
			'field' => 'agreement',
			'label' => 'Agreement',
			'rules' => 'max_length[40]'
		),
		
		array(
			'field' => 'insurance',
			'label' => 'Insurance',
			'rules' => 'max_length[40]'
		)
		
	),

	'account/edit_client' => array(
		
		array(
			'field' => 'managerposition',
			'label' => 'Managerposition',
			'rules' => 'required|max_length[60]'
		),
		
		array(
			'field' => 'programfc',
			'label' => 'Programfc',
			'rules' => 'required|max_length[60]'
		),
		
		array(
			'field' => 'fcposition',
			'label' => 'Fcposition',
			'rules' => 'required|max_length[60]'
		),
		
		array(
			'field' => 'address',
			'label' => 'Address',
			'rules' => 'required'
		),
		
		array(
			'field' => 'phone',
			'label' => 'Phone',
			'rules' => 'required|regex_match[/^([a-zA-Z]+[:]{1})?\d{3}\-\d{3}\-\d{4}$'
		),
			
		array(
			'field' => 'fax',
			'label' => 'Fax',
			'rules' => 'alpha_dash'
		),
		
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|max_length[120]|valid_email|is_unique[client.email]'
		),
		
		array(
			'field' => 'agreement',
			'label' => 'Agreement',
			'rules' => 'max_length[40]'
		),
		
		array(
			'field' => 'insurance',
			'label' => 'Insurance',
			'rules' => 'max_length[40]'
		)
	),

	'booking/add_event' => array(
		
		array(
			'field' => 'title',
			'label' => 'Title',
			'rules' => 'required|max_length[100]'
		),
		
		array(
			'field' => 'from_date',
			'label' => 'From Date',
			'rules' => 'required|callback_validate_from_date'
		)/*,
		
		array(
			'field' => 'fcposition',
			'label' => 'Fcposition',
			'rules' => 'required|max_length[60]'
		),
		
		array(
			'field' => 'address',
			'label' => 'Address',
			'rules' => 'required'
		),
		
		array(
			'field' => 'phone',
			'label' => 'Phone',
			'rules' => 'required|numberic'
		),
			
		array(
			'field' => 'fax',
			'label' => 'Fax',
			'rules' => 'alpha_dash'
		),
		
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|max_length[120]|valid_email|is_unique[client.email]'
		),
		
		array(
			'field' => 'agreement',
			'label' => 'Agreement',
			'rules' => 'max_length[40]'
		),
		
		array(
			'field' => 'insurance',
			'label' => 'Insurance',
			'rules' => 'max_length[40]'
		)*/
	)
    
    
    
    
    
    // Set validation rules for various fields
	//	$this->form_validation->set_rules('title', 'Title', 'required');
	//	$this->form_validation->set_rules('from_date', 'From', 'required|callback_validate_from_date');
	//	$this->form_validation->set_rules('to_date', 'To', 'required|callback_validate_to_date[from_date]');
    //  $this->form_validation->set_rules('from_date', 'From', 'required');
    //  $this->form_validation->set_rules('to_time', 'To', 'required|callback_validate_to_time[from_date, to_date, from_time]');
		
	
);
