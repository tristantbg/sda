<nav class="languages" role="navigation">
	<ul>
		<?php foreach($site->languages() as $language): ?>
			<li<?php e($site->language() == $language, ' class="active"') ?>>
				<a href="<?php echo $page->url($language->code()) ?>" class="no-barba">
					<?= html($language->code()) ?>
				</a>
			</li>
		<?php endforeach ?>
	</ul>
</nav>

<div id="menu">
	<nav id="main-categories" role="navigation">
		<ul>
			<?php foreach($categories as $cat): ?>
				<li class="button rounded bump">
					<a href="<?php echo $cat->url() ?>" data-target>
						<?php echo html($cat->title()) ?>
					</a>
				</li>
			<?php endforeach ?>
			<li id="more-button" class="button black" event-target="additional-menu"><span></span></li>
		</ul>
	</nav>
	
	<form id="searchbar" class="no-ajax" action="<?= page("medias")->url() ?>">
		<input type="search" placeholder="search…" name="q" value="<?php if(isset($query)) echo esc($query) ?>" autocomplete="off" />
		<!-- <input type="submit" value="Search"> -->
	</form>

	<div id="close-additional-menu" class="close">
		<a event-target="menu">X</a>
	</div>
	<div id="close-menu" class="close">
		<a event-target="menu">X</a>
	</div>

	<?php snippet('tags-index') ?>
</div>