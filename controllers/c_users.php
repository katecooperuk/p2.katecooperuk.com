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
        $this->template->title = "Sign Up";
        
        # Render the view (localhost/users/signup)
        echo $this->template;
    }
    
    public function p_signup() {
        	
    	# More data we want stored with the user
    	$_POST['created'] = Time::now();
    	$_POST['modified'] = Time::now();
    	
    	# Encrypt password
    	$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
    	
    	# Create encrypted token via email and random string
    	$_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
    	
    	# Insert this user into the database
    	$user_id = DB::instance(DB_NAME)->insert('users', $_POST);
    	
    	# Debugging - results of POST
    	//echo "<pre>";
    	//print_r($_POST);
    	//echo "<pre>";
    	
    	# Send to the login page
    	Router::redirect('/users/login');
	
    }

    public function login() {
        
        # Setup view
        $this->template->content = View::instance('v_users_login');
        $this->template->title   = "Login";

		# Render template
        echo $this->template;
    }
    
    public function p_login() {
	    
	    $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
	    
	    # Search the db for this email and password
		# Retrieve the token if it's available
		$q = 
			'SELECT token
			FROM users 
			WHERE email = "'.$_POST['email'].'" 
			AND password = "'.$_POST['password'].'"';
			
			//echo $q;
	    
	    $token = DB::instance(DB_NAME)->select_field($q);
	    
	    # Success
	    if($token) {
	    	setcookie('token', $token, strtotime('+1 year'), '/');
	    	echo "You are logged in!";
		    
	    }
	    #Fail
	    else {
	    	echo "Login failed!";
		    
	    }
	    
	    echo "<pre>";
	    print_r($_POST);
	    echo "<pre>";
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