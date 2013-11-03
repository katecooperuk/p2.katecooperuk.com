<div class="content">	
	
	<?php if (count($posts) == 0) :?>
		<h4>You are not following anyone yet,<br>
			choose some <a href="/posts/users/">ChatterBoxes</a>to follow
		</h4>
	<?php endif; ?>
	
	<?php foreach($posts as $post): ?>
		<img class="posts" src="/uploads/avatars/<?=$post['avatar']?>" >
		<div id="name"><?=$post['first_name']?></div>
		<div id="post"><?=$post['content']?></div>
		<div id="time"><?=Time::display($post['created'])?></div>
		<br>
		
	<?php endforeach; ?>
		
</div>