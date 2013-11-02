<div class="formcontent">

	<h2><?php if(isset($user_exists)) echo 'This user already exists, please log in.'; ?><h2>
	
	<h2>LOG IN</h2>

		<form method='POST' action='/users/p_login'>

    		Email<br>
			<input type='text' name='email'>

			<br><br>

			Password<br>
			<input type='password' name='password'>

			<br><br>

			<input type='submit' value='Log in'>

		</form>
</div>
	