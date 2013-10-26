<?php
class practice_controller extends base_controller {

		//========================
		//! /* DATABASE TESTS */
		//========================
		public function test_db() {
			
			# Runs through DB.php in core - puts Albert Einstein into users
			/*	
			$q = 'INSERT INTO users
				SET first_name = "Albert",
				last_name = "Einstein"';
				
			echo $q;
			*/
			
			
			# Runs through DB.php in core - adds email address
			/*
			$q = 'UPDATE users
			SET email = "albert@aol.com"
			WHERE first_name = "Albert"';
			
			echo $q;
			
			DB::instance(DB_NAME)->query($q);
			*/
			
			# Using query builder
			/*
			$new_user = Array(
				'first_name' => 'Albert',
				'last_name' => 'Einstein',
				'email' => 'albert@gmail.com',
			);
				
			DB::instance(DB_NAME)->insert('users',$new_user);
			*/
			
			# Example of data received from a form
			$_POST['first_name'] = 'Albert';
			
			# Sanitizing POST
			$_POST = DB::instance(DB_NAME)->sanitize($_POST);
			
			# Build the query
			$q = 'SELECT email
				FROM users
				WHERE first_name = "'.$_POST['first_name'].'"';
				
			echo $q;
				
			# Run the query, echo what it returns
			//echo DB::instance(DB_NAME)->select_field($q);
		}
		
		
		//========================================
		//! /*  Demonstrating Classes/Objects */
		//========================================
		public function test1() {
		
			# access to class 
			# N.B. with Auto-loading libraries, you don't need this 'require' as it looks for # 'Image'
		
			# Test: localhost/practice/test1
			require(APP_PATH.'/libraries/Image.php');
			
			# instantiate an object from class
			$imageObj = new Image('http://placekitten.com/1000/1000');
			
			# resize
			$imageObj->resize(200,200);

			# display
			$imageObj->display();
		
		}
		
		//==================================
		//! /*  Demonstrating Timestamp */
		//==================================

		public function test2() {
		
			# Static - accessing the method directly. A class where its methods you use independently e.g. 				User
			echo Time::now();
		}
	
	
}