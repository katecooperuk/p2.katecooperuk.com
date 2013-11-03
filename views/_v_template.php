<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<!-- JS/CSS File we want on every page -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    
    <!-- Google Font Link -->
    <link href='http://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>
		
	<!-- Controller Specific JS/CSS -->
	<link rel="stylesheet" href="/css/chatterbox.css" type="text/css">
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<body>	

	<!-- Page Wrapper -->
	<div id="pagewrapper">
	
		<!-- Masthead -->
		<header>ChatterBox</header>
		<!-- End Masthead -->
	
		<!-- Navigation Links -->
		<nav>
			<menu>
				<li><a href='/'>Home</a></li>
				
					<?php if($user): ?>
			
						<li><a href='/users/profile'>Profile</a></li>
						<li><a href='/posts/add'>Add Post</a></li>
						<li><a href='/posts/'>View Posts</a></li>
						<li><a href='/posts/users'>Users</a></li>
						<li><a href='/users/logout'>Logout</a></li>
				
					<?php else: ?>
			
						<li><a href='/users/signup'>Sign Up</a></li>
						<li><a href='/users/login'>Login</a><br></li>
				
					<?php endif; ?>
			
			</menu>
		</nav>
		<!-- End Navigation Links -->
	
		<!-- Page Content -->
			<?php if($user): ?>
				You are logged in as <?=$user->first_name?> <?=$user->last_name?><br>
			<?php endif; ?>
	
			<br>

			<?php if(isset($content)) echo $content; ?>

			<?php if(isset($client_files_body)) echo $client_files_body; ?>
			
			<?php if(isset($client_files_head)) echo $client_files_head; ?>
		<!-- End Page Content -->
		
		<!-- Footer -->
		<footer>
			<p class="footer">Kate Cooper - CSCI E15: Dynamic Web Applications - Project 2<br>
				+1 Feature - upload an avatar image, display image in profile page and posts<br>
				+1 Feature -
			</p>
			<p>
				<a href="http://validator.w3.org/check?uri=http%3A%2F%2Fp2.katecooperuk.com%2F">
				<img style="border:0; width:32px; height:32px" src="http://www.w3.org/html/logo/badge/html5-badge-h-solo.png" alt="Valid HTML5!" width="63" height="64" alt="HTML5 Powered" title="HTML5 Powered">
				</a>
				<a href="http://jigsaw.w3.org/css-validator/check/referer">
				<img style="border:0; width:88px; height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="Valid CSS!">
				</a>
			</p>
		</footer>
		<!-- End Footer -->
		
	</div>
	<!-- End Page Wrapper -->
	
</body>
</html>