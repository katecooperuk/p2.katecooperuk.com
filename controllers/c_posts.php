<?php

class posts_controller extends base_controller {

	public function __construct() {
		# Make sure the base controller construct gets called
        parent::__construct();
    } 

	/*-------------------------------
	Display New Post Form
	-------------------------------*/
	
	public function add() {
	
		$this->template = View::instance('v_posts_add');
		
		echo $this->template;
		
	}
	
	/*-------------------------------
	Process New Posts
	-------------------------------*/
	public function p_add() {
	
		$_POST['user_id'] 	= $this->user->user_id;
		$_POST['created'] 	= Time::now();
		$_POST['modified'] 	= Time::now();
		
		DB::instance(DB_NAME)->insert('posts',$_POST);
		
	}

	/*-------------------------------
	View All Posts
	-------------------------------*/
	public function index() {
		
	}
	
} #eoc