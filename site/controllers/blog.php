<?php

return function ($site, $pages, $page) {
	date_default_timezone_set("Europe/Zurich");
	$posts = $site->index()->visible()->filterBy('intendedTemplate', 'in', ['post', 'news'])->filterBy('date', '<', time())->sortBy('date', 'desc');

	$designers = $site->index()->filterBy('intendedTemplate', 'post')->visible()->sortBy('title');
	
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
	'posts' => $posts->paginate(9),
	'designers' => $designers,
	'themes' => $themes,
	'technics' => $technics,
	'materials' => $materials,
	'colors' => $colors,
	);
}

?>
