<?php if($user): ?>
	
	Hello <?=$user->first_name;?>
	
<?php else: ?>

	Welcome to ChatterBox.  Please sign up or log in
	
<?php endif; ?>