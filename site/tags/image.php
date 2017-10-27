<?php

// image tag
kirbytext::$tags['image'] = array(
  'attr' => array(
    'width',
    'height',
    'alt',
    'text',
    'title',
    'class',
    'imgclass',
    'linkclass',
    'caption',
    'link',
    'target',
    'popup',
    'rel'
  ),
  'html' => function($tag) {

    $url     = $tag->attr('image');
    $alt     = $tag->attr('alt');
    $title   = $tag->attr('title');
    $link    = $tag->attr('link');
    $caption = $tag->attr('caption');
    $file    = $tag->file($url);

    // use the file url if available and otherwise the given url
    $url = $file ? $file->width(1000)->url() : url($url);

    // alt is just an alternative for text
    if($text = $tag->attr('text')) $alt = $text;

    // try to get the title from the image object and use it as alt text
    if($file) {

      if(empty($alt) and $file->alt() != '') {
        $alt = $file->alt();
      }

      if(empty($title) and $file->title() != '') {
        $title = $file->title();
      }

    }

    // at least some accessibility for the image
    if(empty($alt)) $alt = ' ';

    // link builder
    $_link = function($image) use($tag, $url, $link, $file) {

      if(empty($link)) return $image;

      // build the href for the link
      if($link == 'self') {
        $href = $url;
      } else if($file and $link == $file->filename()) {
        $href = $file->url();
      } else if($tag->file($link)) {
        $href = $tag->file($link)->url();
      } else {
        $href = $link;
      }

      return html::a(url($href), $image, array(
        'rel'    => $tag->attr('rel'),
        'class'  => $tag->attr('linkclass'),
        'title'  => $tag->attr('title'),
        'target' => $tag->target()
      ));

    };

    // image builder
    $_image = function($class) use($tag, $url, $alt, $title) {
      return html::img($url, array(
        'width'  => $tag->attr('width'),
        'height' => $tag->attr('height'),
        'class'  => $class,
        'title'  => $title,
        'alt'    => $alt
      ));
    };

    if(true) {
      $image  = $_link($_image($tag->attr('imgclass')));
      $figure = new Brick('figure');
      $figure->attr('data-scroll', $file->name());
      $figure->addClass($tag->attr('class'));
      $figure->append($image);
      $tags = '';
      // foreach ($file->tags()->split(',') as $key => $tag) {
      //   if($key == 0) {
      //     $tags .= "<a href='".site()->language()->url().'/medias/tag:'.urlencode($tag)."' data-target>".$tag."</a>";
      //   }
      //   else {
      //     $tags .= " + <a href='".site()->language()->url().'/medias/tag:'.urlencode($tag)."' data-target>".$tag."</a>";
      //   }
      // }
      foreach ($file->themes()->split(',') as $key => $tag) {
        $tags .= "<a class='button rounded' href='".site()->language()->url().'/medias/tag:'.urlencode($tag)."' data-target>".$tag."</a>";
      }
      foreach ($file->technics()->split(',') as $key => $tag) {
        $tags .= "<a class='button rounded' href='".site()->language()->url().'/medias/tag:'.urlencode($tag)."' data-target>".$tag."</a>";
      }
      foreach ($file->materials()->split(',') as $key => $tag) {
        $tags .= "<a class='button rounded' href='".site()->language()->url().'/medias/tag:'.urlencode($tag)."' data-target>".$tag."</a>";
      }
      foreach ($file->colors()->split(',') as $key => $tag) {
        $tags .= "<a class='button rounded' href='".site()->language()->url().'/medias/tag:'.urlencode($tag)."' data-target>".$tag."</a>";
      }
      if($tags != '') {
        // $figure->append('<figcaption data-scroll="'.$file->name().'"><span class="button rounded">' . html($tags) . '</span></figcaption>');
        $figure->append('<figcaption data-scroll="'.$file->name().'">' . html($tags) . '</figcaption>');
      }
      else if(!empty($caption)) {
        $figure->append('<figcaption data-scroll="'.$file->name().'"><span class="button rounded">' . html($caption) . '</span></figcaption>');
      } else {
        $figure->append('<figcaption data-scroll="'.$file->name().'"><span class="button rounded">' . $file->name() . '</span></figcaption>');
      }
      return $figure;
    } else {
      $class = trim($tag->attr('class') . ' ' . $tag->attr('imgclass'));
      return $_link($_image($class));
    }

  }
);