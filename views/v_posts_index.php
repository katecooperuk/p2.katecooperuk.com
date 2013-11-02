<div class="content">	
	
	<?php foreach($posts as $post): ?>

		<div id="name"><?=$post['first_name']?></div>
		<div id="post"><?=$post['content']?></div>
		<div id="time"><?=Time::display($post['created'])?></div>
		<br><br>
	
	<?php endforeach; ?>
		
</div>