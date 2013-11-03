<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
    } 

    public function index() {
        echo "This is the index page";
    }


	/*-------------------------------------------------------------------------------------------------
	Signup Function
	-------------------------------------------------------------------------------------------------*/

    public function signup() {
        
        #Set up the view
        $this->template->content = View::instance('v_users_signup');
        $this->template->title = "Sign Up";
        
        # Render the view (localhost/users/signup)
        echo $this->template;
    }
    
    /*-------------------------------------------------------------------------------------------------
	Process Signup Function
	-------------------------------------------------------------------------------------------------*/

    public function p_signup() {
    
    	# Sanitize Data Entry
    	$_POST = DB::instance(DB_NAME)->sanitize($_POST);
    
    	# Set up Email / Password Query
    	$q = "SELECT * FROM users WHERE email = '".$_POST['email']."'"; 
    	
    	# Query Database
    	$user_exists = DB::instance(DB_NAME)->select_rows($q);
    	
    	# Check if email exists in database
    		if(!empty($user_exists)){
    		
    			# Send to Login page
	    		Router::redirect('/users/login');
    		}
    		
    		else {
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
  
    }
    
    /*-------------------------------------------------------------------------------------------------
	Login Function
	-------------------------------------------------------------------------------------------------*/

    public function login() {
        
        # Setup view
        $this->template->content = View::instance('v_users_login');
        $this->template->title   = "Login";

		# Render template
        echo $this->template;
    }
    
    /*-------------------------------------------------------------------------------------------------
	Process Login Function
	-------------------------------------------------------------------------------------------------*/

    public function p_login() {
	    
	    # Compare password to database
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
	    
	    # Search the db for this email and password
		# Retrieve the token if it's available
		$q = 
			'SELECT token
			FROM users 
			WHERE email = "'.$_POST['email'].'" 
			AND password = "'.$_POST['password'].'"';
	
	    
	    # If there was, this will return the token
	    $token = DB::instance(DB_NAME)->select_field($q);
	    
	    # Success
	    if($token) {
	    	
	    	# Don't echo anything to the page before setting this cookie!
	    	setcookie('token', $token, strtotime('+1 year'), '/');
	    	
	    	# Send to Homepage
	    	Router::redirect('/');
		    
	    }
	    # Fail
	    else {
	    
			//echo "Login failed! <a href='/users/login'>Try again?</a>";
			# Send to Homepage
	    	Router::redirect('/users/login');
		    
	    }
	    
    }

	/*-------------------------------------------------------------------------------------------------
	Logout Function
	-------------------------------------------------------------------------------------------------*/

    public function logout() {

    	# Generate and save a new token for next login
		$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

		# Create the data array we'll use with the update method
		# In this case, we're only updating one field, so our array only has one entry
		$data = Array('token' => $new_token);

		# Do the update
		DB::instance(DB_NAME)->update('users', $data, 'WHERE token = "'.$this->user->token.'"');

		# Delete their token cookie by setting it to a date in the past - effectively logging them out
		setcookie('token', '', strtotime('-1 year'), '/');

		# Send them back to the main index.
		Router::redirect('/');

}

	/*-------------------------------------------------------------------------------------------------
	Profile Function
	-------------------------------------------------------------------------------------------------*/

	public function profile() {
    
    	# If user is blank, they're not logged in; redirect to login page
    	if(!$this->user) {
	    	Router::redirect('/users/login');
    	}    	
    	
    	# If they weren't redirected away, continue:
    	
    	# Setup view
    	$this->template->content = View::instance('v_users_profile');
    	$this->template->title = "Profile of".$this->user->first_name;
    	
    	# Query Load posts from user
    	$q = 'SELECT * FROM posts WHERE user_id = '.$this->user->user_id;
    	
    	# Run Query
    	$posts = DB::instance(DB_NAME)->select_rows($q);
    	$this->template->content->posts = $posts;
    	

    	
    	# Render template
    	echo $this->template;
    }  
    
	
	/*-------------------------------
	Process Image Uploads
	-------------------------------*/
	
	public function picture() {
	
        # Upload Image
        if ($_FILES['avatar']['error'] == 0) {
            
            
            $avatar = Upload::upload($_FILES, "/uploads/avatars/", array('jpg', 'jpeg', 'gif', 'png'), $this->user->user_id);

            if($avatar == 'Invalid file type.') {
                
                # Error
                Router::redirect("/users/profile/error"); 
            }
            
            else {
                
                # Upload Image
                $data = Array('avatar' => $avatar);
                DB::instance(DB_NAME)->update('users', $data, 'WHERE user_id = '.$this->user->user_id);

                # Resize and Save Image
                $imageObj = new Image($_SERVER['DOCUMENT_ROOT'].'/uploads/avatars/'.$avatar);
                $imageObj->resize(100,100);
            }
        }
        
        else {
        
            # Error
            Router::redirect("/users/profile/error");  
        }

        # Send to Profile Page
        Router::redirect('/users/profile'); 
    }  
	  
  } # end of class