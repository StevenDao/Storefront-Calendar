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
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'required|is_unique[client.name]|min_length[3]|max_length[50]'
		),
		array(
			'field' => 'phone',
			'label' => 'Phone',
			'rules' => 'is_unique[client.phone]|alpha_dash'
		)
	),

	'account/edit_client' => array(
		array(
			'field' => 'phone',
			'label' => 'Phone',
			'rules' => 'is_unique[client.phone]|alpha_dash'
		)
	)
);
