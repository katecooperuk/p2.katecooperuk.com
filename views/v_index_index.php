<?php if($user): ?>

	<pre>
	<?php
	print_r($user);
	?>
	</pre>
	
	Hello <?=$user->first_name;?>
<?php else: ?>
	Welcome to my app.  Please sign up or log in
<?php endif; ?>