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
	
	 	# Set up view
	 	$this->template->content = View::instance('v_posts_index');
		
		# Set up Query
		$q = 'SELECT 
					posts.*,
					users.first_name,
					users.last_name
				FROM posts
				INNER JOIN users				
					ON posts.user_id = users.user_id';
							
		# Run Query
		$posts = DB::instance(DB_NAME)->select_rows($q);
		
		# Pass $posts array to the view
		$this->template->content->posts = $posts;
		
		# Render view
		echo $this->template;
		
	}
	
} #eoc