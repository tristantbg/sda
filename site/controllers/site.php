<?php

return function ($site, $pages, $page) {
	$posts = $site->index()->filterBy('intendedTemplate', 'in', ['post', 'news'])->visible()->sortBy('date', 'desc');
	$designers = $site->index()->filterBy('intendedTemplate', 'post')->visible();
	
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

	$query   = get('q');

	$results = null;
  	if ($query) {
  		$results = search($medias, $query, 'filename|themes|technics|materials|colors');
  	}

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
	'categories' => $site->homePage()->children()->visible(),
	'results' => $results,
	'designers' => $designers,
	'themes' => $themes,
	'technics' => $technics,
	'materials' => $materials,
	'colors' => $colors,

	);
}

?>
