<?php
if (! defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/doctors-functions.php';

function rostest_theme_setup()
{
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    
    register_nav_menus(
        array(
            'rostest-menu-1' => esc_html__('Primary', 'rostest_theme'),
        )
    );
}
add_action('after_setup_theme', 'rostest_theme_setup');

function rostest_theme_scripts()
{
    wp_enqueue_style('rostest-theme-style', get_stylesheet_uri(), array(), '1.0');
    wp_enqueue_script('rostest-theme-scripts', get_template_directory_uri() . '/js/scripts.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'rostest_theme_scripts');


/* ACF JSON */
add_filter('acf/settings/load_json', function ($paths) {
    unset($paths[0]); // убираем стандартный путь
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
});

add_filter('acf/settings/save_json', function () {
    return get_stylesheet_directory() . '/acf-json';
});
