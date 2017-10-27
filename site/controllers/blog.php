<?php

return function ($site, $pages, $page) {
	$posts = $page->grandChildren()->visible()->sortBy('date', 'desc');

	$designers = $site->index()->filterBy('intendedTemplate', 'post')->visible();
	$medias = site()->index()->files();

	$themes = [];
	$technics = [];
	$materials = [];
	$colors = [];

	foreach ($medias as $key => $media) {
		$themes = array_merge($themes, $media->themes()->split(','));
		$technics = array_merge($technics, $media->technics()->split(','));
		$materials = array_merge($materials, $media->materials()->split(','));
		$colors = array_merge($colors, $media->colors()->split(','));
	}

	$themes = array_unique($themes);
	asort($themes);
	$technics = array_unique($technics);
	asort($technics);
	$materials = array_unique($materials);
	asort($materials);
	$colors = array_unique($colors);
	asort($colors);

	return array(
	'posts' => $posts,
	'designers' => $designers,
	'themes' => $themes,
	'technics' => $technics,
	'materials' => $materials,
	'colors' => $colors,
	);
}

?>
