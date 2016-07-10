<div class="qPostMain">
	<div class="qPost">
		<?php
			foreach($Post as $p){
			?>
			<div class="qPostTitle"><?php echo $p["PostTitle"]; ?></div>
			<div class="qPostDetail">
				<div class="qPostDate">Tarih : <?php echo $p["PostDate"]; ?></div>
				<div class="qPostCommentNumber"><?php echo count($Q["Comment"]->getComments($p["PostId"])); ?> Yorum</div>
			</div>
			<div class="qPostPost">
				<?php echo nl2br($p["Post"]); ?>
			</div>
			<?php
			}
		?>
	</div>
</div>