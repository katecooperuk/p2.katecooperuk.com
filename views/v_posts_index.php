<div class="content">	
	
	<?php foreach($posts as $post): ?>
		<img class="posts" src="/uploads/avatars/<?=$post['avatar']?>" >
		<div id="name"><?=$post['first_name']?></div>
		<div id="post"><?=$post['content']?></div>
		<div id="time"><?=Time::display($post['created'])?></div>
		<br>
		
	<?php endforeach; ?>
		
</div>