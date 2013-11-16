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
			'rules' => 'required|alpha_dash'
		),
			
		array(
			'field' => 'fax',
			'label' => 'Fax'
		),
		
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|max_length[120]'
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
			'rules' => 'required'
		),
			
		array(
			'field' => 'fax',
			'label' => 'Fax',
			'rules' => 'alpha_dash'
		),
		
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'required|max_length[120]'
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
	)
	
);
