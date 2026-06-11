<?php
declare(strict_types=1);

$root = dirname(__DIR__);
$wp_dir = $root . '/.local-wordpress/wordpress';

define('WP_INSTALLING', true);

require_once $wp_dir . '/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/upgrade.php';

if (! is_blog_installed()) {
	wp_install(
		'Sons of the Beach Local',
		'admin',
		'admin@example.test',
		true,
		'',
		'admin',
		'en_US'
	);
}

update_option('blogname', 'Sons of the Beach Local');
update_option('blogdescription', 'Ambiente locale');
update_option('timezone_string', 'Europe/Rome');
update_option('show_on_front', 'page');

$pages = [
	'home' => ['Home', ''],
	'news' => ['News', ''],
	'tornei' => ['Tornei', ''],
	'contatti' => ['Contatti', ''],
];

$page_ids = [];
foreach ($pages as $slug => [$title, $content]) {
	$page = get_page_by_path($slug);

	if ($page) {
		$page_ids[$slug] = (int) $page->ID;
		continue;
	}

	$page_ids[$slug] = wp_insert_post([
		'post_title' => $title,
		'post_name' => $slug,
		'post_status' => 'publish',
		'post_type' => 'page',
		'post_content' => $content,
	]);
}

if (! empty($page_ids['home'])) {
	update_option('page_on_front', $page_ids['home']);
}

if (! empty($page_ids['news'])) {
	update_option('page_for_posts', $page_ids['news']);
}

switch_theme('sotb');

$menu_name = 'Menu principale';
$menu = wp_get_nav_menu_object($menu_name);
$menu_id = $menu ? (int) $menu->term_id : wp_create_nav_menu($menu_name);

foreach (wp_get_nav_menu_items($menu_id) ?: [] as $item) {
	wp_delete_post((int) $item->ID, true);
}

$order = 1;
foreach (['home' => 'Home', 'news' => 'News', 'tornei' => 'Tornei', 'contatti' => 'Contatti'] as $slug => $title) {
	if (empty($page_ids[$slug])) {
		continue;
	}

	wp_update_nav_menu_item($menu_id, 0, [
		'menu-item-title' => $title,
		'menu-item-object-id' => $page_ids[$slug],
		'menu-item-object' => 'page',
		'menu-item-type' => 'post_type',
		'menu-item-status' => 'publish',
		'menu-item-position' => $order++,
	]);
}

set_theme_mod('nav_menu_locations', [
	'primary' => $menu_id,
	'footer' => $menu_id,
]);

flush_rewrite_rules();
