<?php

class posts_controller extends base_controller {

	public function __construct() {
                
		# Make sure the base controller construct gets called
		parent::__construct();
                
		# Only let logged in users access the methods in this controller
		if(!$this->user) {
			die("Members only");
		}
                
    }  

	/*-------------------------------
	Display New Post Form
	-------------------------------*/
	
	public function add() {
	
		$this->template->content = View::instance('v_posts_add');
		$this->template->title = "Add Post";
		
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
		
		Router::redirect('/posts/');
		
	}

	/*-------------------------------
	View All Posts
	-------------------------------*/
	public function index() {
	
	 	# Set up view
	 	$this->template->content = View::instance('v_posts_index');
		
		# Set up Query
		$q = 'SELECT 
					posts.content,
					posts.created,
					posts.user_id AS post_user_id,
					users_users.user_id AS follower_id,
					users.first_name,
					users.last_name
				FROM posts
				INNER JOIN users_users 
					ON posts.user_id = users_users.user_id_followed
				INNER JOIN users 
					ON posts.user_id = users.user_id
				WHERE users_users.user_id = '.$this->user->user_id.'
				ORDER BY post_id DESC';
							
		# Run Query
		$posts = DB::instance(DB_NAME)->select_rows($q);
		
		# Pass $posts array to the view
		$this->template->content->posts = $posts;
		
		# Render view
		echo $this->template;
		
	}
	
	/*-------------------------------
	View Users
	-------------------------------*/
	
	public function users(){
		
		# Set up view
	 	$this->template->content = View::instance('v_posts_users');
		
		# Set up Query - All users
		$q = 'SELECT *
				FROM users';
			
		# Run Query
		$users = DB::instance(DB_NAME)->select_rows($q);
		
		# Set up Query - Connections from users_users table
		$q = 'SELECT *
				FROM users_users
				WHERE user_id = '.$this->user->user_id;
				
		# Run Query
		$connections = DB::instance(DB_NAME)->select_array($q,'user_id_followed');
		
		//print_r($connections);
		
		# Pass $users array to the view
		$this->template->content->users       = $users;
		$this->template->content->connections = $connections;
		
		# Render view
		echo $this->template;
	}
	
	/*------------------------------------------------------------------------------------
	Follow - creates row in users_users table representing one user is following another
	------------------------------------------------------------------------------------*/
	
	public function follow($user_id_followed) {

    	# Prepare the data array to be inserted
		$data = Array(
        "created" => Time::now(),
        "user_id" => $this->user->user_id,
        "user_id_followed" => $user_id_followed
        );

		# Do the insert
		DB::instance(DB_NAME)->insert('users_users', $data);

		# Send them back
		Router::redirect("/posts/users");

	}
	
	/*------------------------------------------------------------------------------------
	UnFollow - removes specified row in users_users table, removing 'follow' between users
	------------------------------------------------------------------------------------*/

	public function unfollow($user_id_followed) {

    	# Delete this connection
		$where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
		DB::instance(DB_NAME)->delete('users_users', $where_condition);

		# Send them back
		Router::redirect("/posts/users");

	}
	
} #eoc