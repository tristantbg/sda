<?php

return function ($site, $pages, $page) {
	$title = $page->title()->html();
	$medias = site()->index()->files();
	$results = $medias;

	if ($tag = param('themes')) {
		$results = $results->filterBy('themes', $tag, ',');
	}
	if ($tag = param('technics')) {
		$results = $results->filterBy('technics', $tag, ',');
	}
	if ($tag = param('materials')) {
		$results = $results->filterBy('materials', $tag, ',');
	}
	if ($tag = param('colors')) {
		$results = $results->filterBy('colors', $tag, ',');
	}

	$designers = $site->index()->filterBy('intendedTemplate', 'post')->visible();

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
	'title' => $title,
	'medias' => $medias,
	'results' => $results,
	'designers' => $designers,
	'themes' => $themes,
	'technics' => $technics,
	'materials' => $materials,
	'colors' => $colors,
	);
}

?>
