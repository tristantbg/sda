<?php

/*

---------------------------------------
License Setup
---------------------------------------

Please add your license key, which you've received
via email after purchasing Kirby on http://getkirby.com/buy

It is not permitted to run a public website without a
valid license key. Please read the End User License Agreement
for more information: http://getkirby.com/license

*/

c::set('license', 'put your license key here');

/*

---------------------------------------
Kirby Configuration
---------------------------------------

By default you don't have to configure anything to
make Kirby work. For more fine-grained configuration
of the system, please check out http://getkirby.com/docs/advanced/options

*/

c::set('debug', true);
c::set('home', 'blog');
c::set('autobuster', true);
c::set('plugin.embed.video.lazyload', true);
c::set('plugin.embed.video.lazyload.btn', 'assets/images/play.png');
c::set('kirbytext.image.figure', false);
//Typo
c::set('typography', true);
c::set('typography.ordinal.suffix', false);
c::set('typography.fractions', false);
c::set('typography.dashes.spacing', false);
c::set('typography.hyphenation', false);
//c::set('typography.hyphenation.language', 'fr');
//c::set('typography.hyphenation.minlength', 5);
c::set('typography.hyphenation.headings', false);
c::set('typography.hyphenation.allcaps', false);
c::set('typography.hyphenation.titlecase', false);
//Settings
c::set('sitemap.exclude', array('error'));
c::set('sitemap.important', array('contact'));
c::set('thumb.quality', 100);
//c::set('thumbs.driver', 'im');
c::set('routes', array(
	// array(
	// 	'pattern' => 'info/(:any)',
	// 	'action'  => function($uri,$uid) {
	// 		$page = site()->homePage();
	// 		go($page);
	// 	}
	// 	),
	array(
		'pattern' => 'robots.txt',
		'action' => function () {
			return new Response('User-agent: *
				Disallow: /content/*.txt$
				Disallow: /kirby/
				Disallow: /site/
				Disallow: /*.md$
				Sitemap: ' . u('sitemap.xml'), 'txt');
		}
		)
));
c::set('languages', array(
	array(
		'code'    => 'en',
		'name'    => 'English',
		'default' => true,
		'locale'  => 'en_US',
		'url'     => '/',
	),
	array(
		'code'    => 'it',
		'name'    => 'Italian',
		'locale'  => 'it_IT',
		'url'     => '/it',
	),
	array(
		'code'    => 'fr',
		'name'    => 'Français',
		'locale'  => 'fr_FR',
		'url'     => '/fr',
	),
	array(
		'code'    => 'de',
		'name'    => 'Deutsch',
		'locale'  => 'de_DE',
		'url'     => '/de',
	),
));