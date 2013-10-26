<?php
class users_controller extends base_controller {

	#Testing localhost/users/signup

    public function __construct() {
        parent::__construct();
    } 

    public function index() {
        echo "This is the index page";
    }

    public function signup() {
        
        #Set up the view
        $this->template->content = View::instance('v_users_signup');
        
        # Render the view (localhost/users/signup)
        echo $this->template;
    }
    
    public function p_signup() {
    
    	# Debugging
    	echo "<pre>";
    	print_r($_POST);
    	echo "<pre>";
	    
    }

    public function login() {
        echo "This is the login page";
    }

    public function logout() {
        echo "This is the logout page";
    }

   public function profile($user_name = NULL) {
    
    	# Set up the View
    	$this->template->content = View::instance('v_users_profile');
    	$this->template->title = "Profile";
    	
    	# Define the Array for the Head
    	$client_files_head = Array(
    	'/css/profile.css',
    	'/css/master.css'
    	);
    	
    	# Load Client Files - Head
    	$this->template->client_files_head = Utils::load_client_files($client_files_head);
    	
    	# Define the Array for the Body
    	$client_files_body = Array(
    	'/js/profile.js'
    	);
    	
    	# Load Client Files - Body
    	$this->template->client_files_body = Utils::load_client_files($client_files_body);
    	    	
    	# Pass the data to the view
    	$this->template->content->user_name = $user_name;
    	
    	# Display the View
    	echo $this->template;
    	
    	# Create instance of view
    	//$view = View::instance('v_users_profile');
    	
    	# View has access to $user_name
    	//$view->user_name = $user_name;
    	
    	//echo $view;
    	
    }    
    
} # end of the class