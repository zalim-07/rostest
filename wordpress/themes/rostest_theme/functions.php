<?php
if (! defined('ABSPATH')) {
    exit;
}

function rostest_theme_setup()
{
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

/* Регистрация Custom Post Type для докторов */
function rostest_register_doctors_cpt()
{
    register_post_type('doctors', array(
        'labels' => array(
            'name' => __('Доктора', 'rostest_theme'),
            'singular_name' => __('Доктор', 'rostest_theme'),
            'add_new' => __('Добавить нового', 'rostest_theme'),
            'add_new_item' => __('Добавить нового доктора', 'rostest_theme'),
            'edit_item' => __('Редактировать доктора', 'rostest_theme'),
            'new_item' => __('Новый доктор', 'rostest_theme'),
            'view_item' => __('Просмотреть доктора', 'rostest_theme'),
            'search_items' => __('Искать докторов', 'rostest_theme'),
            'not_found' => __('Докторов не найдено', 'rostest_theme'),
            'not_found_in_trash' => __('В корзине докторов не найдено', 'rostest_theme'),
            'all_items' => __('Все доктора', 'rostest_theme'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-businessman',
        'rewrite' => array('slug' => 'doctors'),
    ));
}
add_action('init', 'rostest_register_doctors_cpt');

/* Регистрация Taxonomies для докторов */
function rostest_register_doctors_taxonomies()
{
    register_taxonomy('specialization', 'doctors', array(
        'labels' => array(
            'name' => __('Специализации', 'rostest_theme'),
            'singular_name' => __('Специализация', 'rostest_theme'),
            'search_items' => __('Искать специализации', 'rostest_theme'),
            'all_items' => __('Все специализации', 'rostest_theme'),
            'edit_item' => __('Редактировать специализацию', 'rostest_theme'),
            'update_item' => __('Обновить специализацию', 'rostest_theme'),
            'add_new_item' => __('Добавить новую специализацию', 'rostest_theme'),
            'new_item_name' => __('Название новой специализации', 'rostest_theme'),
        ),
        'hierarchical' => true,
        'public' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'specialization'),
    ));

    register_taxonomy('city', 'doctors', array(
        'labels' => array(
            'name' => __('Города', 'rostest_theme'),
            'singular_name' => __('Город', 'rostest_theme'),
            'search_items' => __('Искать города', 'rostest_theme'),
            'all_items' => __('Все города', 'rostest_theme'),
            'edit_item' => __('Редактировать город', 'rostest_theme'),
            'update_item' => __('Обновить город', 'rostest_theme'),
            'add_new_item' => __('Добавить новый город', 'rostest_theme'),
            'new_item_name' => __('Название нового города', 'rostest_theme'),
        ),
        'hierarchical' => true,
        'public' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'city'),
    ));
}
add_action('init', 'rostest_register_doctors_taxonomies');


/* ACF JSON */
add_filter('acf/settings/load_json', function ($paths) {
    unset($paths[0]); // убираем стандартный путь
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
});

add_filter('acf/settings/save_json', function () {
    return get_stylesheet_directory() . '/acf-json';
});
