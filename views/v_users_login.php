<div class="formcontent">
	
	<h2>LOG IN</h2>

		<form method='POST' action='/users/p_login'>

    		Email<br>
			<input type='text' name='email'>

			<br><br>

			Password<br>
			<input type='password' name='password'>

			<br><br>
			
			<?php if($error && $error == 'user-exists'): ?>
				<div class='error'>
					This user already exists
				</div>
			<?php elseif(isset($error) && $error == 'blank-fields'): ?>
				<div class='error'>
					All fields need to be completed
				</div>
			<?php elseif(isset($error) && $error == 'invalid-login'): ?>
				<div class='error'>
					Invalid Login, please try again
				</div>
			<?php endif; ?>

			<input type='submit' value='Log in'>

		</form>
</div>
	