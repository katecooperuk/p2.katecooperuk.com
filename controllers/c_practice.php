<?php
class practice_controller extends base_controller {
	
		/* Database Insert Test - N.B. Use double quotes "" */
		public function test_db() {
			
			$q = 'INSERT INTO users
				SET first_name = "Albert",
				last_name = "Einstein"';
				
			echo $q;
			
			# Runs through DB.php in core - puts Albert Einstein into users
			DB::instance(DB_NAME)->query($q);
			
		}
		
		/*  Demonstrating Classes/Objects */
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
		
		public function test2() {
		
			# Static - accessing the method directly. A class where its methods you use independently e.g. User
			echo Time::now();
	}
	
	
}