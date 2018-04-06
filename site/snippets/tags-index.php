<div id="tags-index">
	<div class="search-elem">
		<div class="search-category button black rounded"><span>Participants</span></div>
		<div class="scroller">
			<div>
				<?php foreach ($designers as $key => $p): ?>
					<a class="button rounded bump" href="<?= $p->url() ?>" data-target><?= $p->title()->html() ?></a>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	<div class="search-elem">
		<div class="search-category button black rounded"><span>Theme</span></div>
		<div class="scroller">
			<div>
				<?php foreach ($themes as $key => $tag): ?>
					<a class="button rounded bump" href="<?= $site->url().'/medias/themes:'.$tag ?>" data-target><?= html($tag) ?></a>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	<div class="search-elem">
		<div class="search-category button black rounded"><span>Technic</span></div>
		<div class="scroller">
			<div>
				<?php foreach ($technics as $key => $tag): ?>
					<a class="button rounded bump" href="<?= $site->url().'/medias/technics:'.$tag ?>" data-target><?= html($tag) ?></a>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	<div class="search-elem">
		<div class="search-category button black rounded"><span>Material</span></div>
		<div class="scroller">
			<div>
				<?php foreach ($materials as $key => $tag): ?>
					<a class="button rounded bump" href="<?= $site->url().'/medias/materials:'.$tag ?>" data-target><?= html($tag) ?></a>
				<?php endforeach ?>
			</div>
		</div>
	</div>
	<div class="search-elem">
		<div class="search-category button black rounded"><span>Color</span></div>
		<div class="scroller">
			<div>
				<?php foreach ($colors as $key => $tag): ?>
					<a class="color" href="<?= $site->url().'/medias/colors:'.$tag ?>" style="background: <?= $tag ?>" data-target></a>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</div>