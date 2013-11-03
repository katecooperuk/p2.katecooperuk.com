<div class="content">

	<?php if($user): 
		
		# Send to Profile Page
		Router::redirect('/users/profile');
	?>
	
		
	
	<?php else: ?>

		Welcome to ChatterBox.<br>
		Login if you already have an account<br>
		or sign up to create an account and join the chatter!
	
	
	<?php endif; ?>

</div>