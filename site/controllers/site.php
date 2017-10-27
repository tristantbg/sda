<?php

return function ($site, $pages, $page) {
	function search($files, $query, $params = []) {

  if(is_string($params)) {
    $params = array('fields' => str::split($params, '|'));
  }

  $defaults = array(
    'minlength' => 2,
    'fields'    => array(),
    'words'     => false,
    'score'     => array()
  );

  $options     = array_merge($defaults, $params);
  $collection  = clone $files;
  $searchwords = preg_replace('/(\s)/u',',', $query);
  $searchwords = str::split($searchwords, ',', $options['minlength']);

  if(!empty($options['stopwords'])) {
    $searchwords = array_diff($searchwords, $options['stopwords']);
  }

  if(empty($searchwords)) return $collection->limit(0);

  $searchwords = array_map(function($value) use($options) {
    return $options['words'] ? '\b' . preg_quote($value) . '\b' : preg_quote($value);
  }, $searchwords);

  $preg    = '!(' . implode('|', $searchwords) . ')!i';
  $results = $collection->filter(function($file) use($query, $searchwords, $preg, $options) {

    $data = $file->meta()->toArray();
    $keys = array_keys($data);

    if(!empty($options['fields'])) {
      $keys = array_intersect($keys, $options['fields']);
    }

    $file->searchHits  = 0;
    $file->searchScore = 0;

    foreach($keys as $key) {

      $score = a::get($options['score'], $key, 1);

      // check for a match
      if($matches = preg_match_all($preg, $data[$key], $r)) {

        $file->searchHits  += $matches;
        $file->searchScore += $matches * $score;

        // check for full matches
        if($matches = preg_match_all('!' . preg_quote($query) . '!i', $data[$key], $r)) {
          $file->searchScore += $matches * $score;
        }

      }

    }

    return $file->searchHits > 0 ? true : false;

  });

  $results = $results->sortBy('searchScore', SORT_DESC);

  return $results;

}

	$designers = $site->index()->filterBy('intendedTemplate', 'post')->visible();
	$medias = site()->index()->files();

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
	'results' => $results,
	'designers' => $designers,
	'themes' => $themes,
	'technics' => $technics,
	'materials' => $materials,
	'colors' => $colors,

	);
}

?>
