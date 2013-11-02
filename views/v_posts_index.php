<div class="content">	
	
	<?php foreach($posts as $post): ?>

		<strong><?=$post['first_name']?> posted:</strong><br>
		<?=$post['content']?><br>
		<i><?=Time::display($post['created'])?></i><br><br>
	
	<?php endforeach; ?>
		
</div>