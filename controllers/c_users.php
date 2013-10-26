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
	    
	    # Sanitize User
	    $_POST = DB::instance(DB_NAME)->sanitize($_POST);
	    
	    # Compare password to database
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
	    
	    # Fail to find matching token
	    if(!$token) {
	    	
	    	# Send back to login page
	    	Router::redirect('/users/login/');
		    
	    }
	    # Successful login
	    else {
	    	/* 
			Store this token in a cookie using setcookie()
			Important Note: *Nothing* else can echo to the page before setcookie is called
			Not even one single white space.
			param 1 = name of the cookie
			param 2 = the value of the cookie
			param 3 = when to expire
			param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
			*/
			setcookie('token', $token, strtotime('+1 year'), '/');
			
			# Send to main page
			Router::redirect('/');
		    
	    }
	    

    }

    public function logout() {

    	# Generate and save a new token for next login
		$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

		# Create the data array we'll use with the update method
		# In this case, we're only updating one field, so our array only has one entry
		$data = Array("token" => $new_token);

		# Do the update
		DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

		# Delete their token cookie by setting it to a date in the past - effectively logging them out
		setcookie("token", "", strtotime('-1 year'), '/');

		# Send them back to the main index.
		Router::redirect("/");

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