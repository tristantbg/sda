<?php

return function ($site, $pages, $page) {
	$title = $page->title()->html();
	$posts = $site->index()->visible()->filterBy('intendedTemplate', 'in', ['post', 'news'])->sortBy('date', 'desc');

	// Search
	if ($query = get('q')) {
		$posts = $posts->search($query, 'title|text|sections|quote|pretitle');
	}

	// Get all images
    $medias = new Collection();
    foreach ($posts as $p) {
      foreach ($p->sections()->toStructure() as $s) {
      	if ($s->_fieldset() == "image" && $s->get("first")->toFile()) {
          $medias->data[] = $s->get("first")->toFile();
        }
      }
    }
	$medias = $medias->sortBy('sort', 'asc');
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

	$designers = $posts->filterBy('intendedTemplate', 'post')->sortBy('title');

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
	'categories' => $site->homePage()->children()->visible(),
	'query' => $query,
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
