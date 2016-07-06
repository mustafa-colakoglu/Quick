<div class="qCommentMain">
	<?php
		foreach($Comments as $Comment){
		?>
		<div class="qComment">
			<div class="qCommentUserName">
				<?php echo $Q["User"]->getUserInfo($Comment["UserId"],"UserName"); ?>
			</div>
			<div class="qTwoDot">
				:
			</div>
			<div class="qCommentComment">
				<?php echo $Comment["Comment"]; ?>
			</div>
		</div>
		<?php
		}
		
	?>
</div>