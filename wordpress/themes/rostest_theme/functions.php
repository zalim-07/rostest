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

/* Архив докторов - фильтрация и сортировка */
function rostest_doctors_archive_query($query)
{
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('doctors')) {
        $query->set('posts_per_page', 9);

        $tax_query = array();

        if (!empty($_GET['specialization'])) {
            $tax_query[] = array(
                'taxonomy' => 'specialization',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_GET['specialization']),
            );
        }

        if (!empty($_GET['city'])) {
            $tax_query[] = array(
                'taxonomy' => 'city',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_GET['city']),
            );
        }

        if (!empty($tax_query)) {
            $query->set('tax_query', $tax_query);
        }

        if (!empty($_GET['sort'])) {
            $sort = sanitize_text_field($_GET['sort']);
            
            switch ($sort) {
                case 'rating_desc':
                    $query->set('meta_key', 'doctor_rating');
                    $query->set('orderby', 'meta_value_num');
                    $query->set('order', 'DESC');
                    break;
                case 'price_asc':
                    $query->set('meta_key', 'doctor_price_from');
                    $query->set('orderby', 'meta_value_num');
                    $query->set('order', 'ASC');
                    break;
                case 'experience_desc':
                    $query->set('meta_key', 'doctor_experience');
                    $query->set('orderby', 'meta_value_num');
                    $query->set('order', 'DESC');
                    break;
            }
        }
    }
}
add_action('pre_get_posts', 'rostest_doctors_archive_query');
