<div class="content">
	
	<h2><?=$user->first_name?>'s Profile</h2>
	<img src="<?=$user->avatar; ?>">
	
	<form method='POST' action="/users/picture/" enctype="multipart/form-data" >
    	<input type='file' accept='image' name='avatar'><br>
		<input type='submit' name='submit' value='Upload Avatar'>
	</form>
	
	<h2>My Posts</h2>
	<?php foreach($posts as $post): ?>
	
		<div id="post"><?=$post['content']?></div>
		<div id="time"><?=Time::display($post['created'])?></div>
		<br>
	
	<?php endforeach;?>  

</div>