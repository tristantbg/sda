<!DOCTYPE html>
<html lang="en" class="no-js">
<head>

	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="dns-prefetch" href="//www.google-analytics.com">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="canonical" href="<?php echo html($page->url()) ?>" />
	<?php if($page->isHomepage()): ?>
		<title><?= $site->title()->html() ?></title>
	<?php else: ?>
		<title><?= $page->title()->html() ?> | <?= $site->title()->html() ?></title>
	<?php endif ?>
	<?php if($page->isHomepage()): ?>
		<meta name="description" content="<?= $site->description()->html() ?>">
	<?php else: ?>
		<meta name="DC.Title" content="<?= $page->title()->html() ?>" />
		<?php if(!$page->text()->empty()): ?>
			<meta name="description" content="<?= $page->text()->excerpt(250) ?>">
			<meta name="DC.Description" content="<?= $page->text()->excerpt(250) ?>"/ >
			<meta property="og:description" content="<?= $page->text()->excerpt(250) ?>" />
		<?php else: ?>
			<meta name="description" content="">
			<meta name="DC.Description" content=""/ >
			<meta property="og:description" content="" />
		<?php endif ?>
	<?php endif ?>
	<meta name="robots" content="index,follow" />
	<meta name="keywords" content="<?= $site->keywords()->html() ?>">
	<?php if($page->isHomepage()): ?>
		<meta itemprop="name" content="<?= $site->title()->html() ?>">
		<meta property="og:title" content="<?= $site->title()->html() ?>" />
	<?php else: ?>
		<meta itemprop="name" content="<?= $page->title()->html() ?> | <?= $site->title()->html() ?>">
		<meta property="og:title" content="<?= $page->title()->html() ?> | <?= $site->title()->html() ?>" />
	<?php endif ?>
	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?= html($page->url()) ?>" />
	<?php if($page->content()->name() == "project"): ?>
		<?php if (!$page->featured()->empty()): ?>
			<meta property="og:image" content="<?= $page->image($page->featured())->width(1200)->url() ?>"/>
		<?php endif ?>
	<?php else: ?>
		<?php if(!$site->ogimage()->empty()): ?>
			<meta property="og:image" content="<?= $site->ogimage()->toFile()->width(1200)->url() ?>"/>
		<?php endif ?>
	<?php endif ?>

	<meta itemprop="description" content="<?= $site->description()->html() ?>">
	<link rel="shortcut icon" href="<?= url('assets/images/favicon.ico') ?>">
	<link rel="icon" href="<?= url('assets/images/favicon.ico') ?>" type="image/x-icon">

	<?php 
	echo css('assets/css/build/build.min.css');
	echo js('assets/js/vendor/modernizr.min.js');
	?>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?= url('assets/js/vendor/jquery.min.js') ?>">\x3C/script>')</script>

	<?php if(!$site->customcss()->empty()): ?>
		<style type="text/css">
			<?php echo $site->customcss()->html() ?>
		</style>
	<?php endif ?>

</head>
<body>

<div id="outdated">
	<div class="inner">
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser.
	<br>Please <a href="http://outdatedbrowser.com" target="_blank">upgrade your browser</a> to improve your experience.</p>
	</div>
</div>

<div class="loader">
	<div class="button black rounded">
		<?= l::get('hi') ?>
	</div>
</div>

<div id="main">
	<header>
		<div id="menu-burger">
			<svg version="1.1" id="Calque_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 31 30" enable-background="new 0 0 31 30" xml:space="preserve">
			<g>
				<rect x="-0.1" y="0" width="31.1" height="4.2"/>
				<rect x="-0.1" y="12.9" width="31.1" height="4.2"/>
				<rect x="-0.1" y="25.8" width="31.1" height="4.2"/>
			</g>
			</svg>
		</div>

		<div id="site-title">
			<a href="<?= $site->language()->url() ?>" data-target><h1><?= $site->title()->html() ?></h1></a>
		</div>

		<div id="nav-language-placeholder"></div>

	</header>

	
	<nav class="languages" role="navigation">
	  <ul>
	    <?php foreach($site->languages() as $language): ?>
	    <li<?php e($site->language() == $language, ' class="active"') ?>>
	      <a href="<?php echo $page->url($language->code()) ?>">
	        <?php echo html($language->code()) ?>
	      </a>
	    </li>
	    <?php endforeach ?>
	  </ul>
	</nav>

	<nav class="categories" role="navigation">
	  <ul>
	    <?php foreach($site->homePage()->children()->visible() as $cat): ?>
	    <li class="button rounded">
	      <a href="<?php echo $cat->url() ?>" data-target>
	        <?php echo html($cat->title()) ?>
	      </a>
	    </li>
	    <?php endforeach ?>
	    <li class="more button black" event-target="additional-menu"><span></span></li>
	  </ul>
	</nav>
	
	<div id="additional-menu">
		<form id="search" class="no-ajax" action="<?= page("search")->url() ?>">
		<input type="search" placeholder="search" name="q" value="<?php if(isset($query)) echo esc($query) ?>" autocomplete="off" />
		<!-- <input type="submit" value="Search"> -->
		</form>
		<div id="close">
			<a event-target="additional-menu">X</a>
		</div>
		<?php snippet('search') ?>
	</div>

	<div id="container">