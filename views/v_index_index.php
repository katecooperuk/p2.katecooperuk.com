<div class="content">

	<?php if($user): ?>
	
		Hello <?=$user->first_name;?>, welcome back to ChatterBox!
	
	<?php else: ?>

		Welcome to ChatterBox.<br>
		Login if you already have an account<br>
		or sign up to create an account and join the chatter!
	
	
	<?php endif; ?>

</div>