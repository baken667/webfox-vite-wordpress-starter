<?php

if (!defined("ABSPATH"))
    exit;

const IS_VITE_DEVELOPMENT = true;


include "inc/inc.vite.php";

function create_post_type()
{
    $labels = [
        'name' => 'Проекты',
        'singular_name' => 'Проект',
        'menu_name' => 'Проекты',
        'name_admin_bar' => 'Проекты',
        'add_new' => 'Добавить новый',
        'add_new_item' => 'Добавить новый проект',
        'new_item' => 'Новый проект',
        'edit_item' => 'Редактировать проект',
        'view_item' => 'Посмотреть проект',
        'all_items' => 'Все проекты',
        'search_items' => 'Искать проект',
        'parent_item_colon' => 'Родительский проект:',
        'not_found' => 'Проекты не найдены',
        'not_found_in_trash' => 'В корзине нет проектов',
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-portfolio',
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => ['title', 'editor', 'author', 'thumbnail', 'excerpt'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'projects'],
        'query_var' => true,
    ];

    register_post_type('webfox_projects', $args);
}

add_action('init', 'create_post_type');