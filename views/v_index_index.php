<div class="content-home">

	<?php if($user): 
		
		# Send to Profile Page
		Router::redirect('/users/profile');
	?>

	<?php else: ?>

		<div id="welcome">
			Welcome to ChatterBox.<br>
			Login if you already have an account<br>
			or sign up to create an account and<br>
			join in the chatter!
		</div>
	
	<?php endif; ?>

</div>