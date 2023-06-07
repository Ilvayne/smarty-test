<?php
/*
Plugin Name: Real Estate Object
Description: Plugin for creating & filtering a post type "Property" for Wordpress
Version: 1.0
Author: Illia Shamrai
License: GPL2
*/

function create_property_post_type() {
    $labels = array(
        'name'               => 'Объекты недвижимости',
        'singular_name'      => 'Объект недвижимости',
        'add_new'            => 'Добавить новый',
        'add_new_item'       => 'Добавить новый объект недвижимости',
        'edit_item'          => 'Редактировать объект недвижимости',
        'new_item'           => 'Новый объект недвижимости',
        'view_item'          => 'Просмотреть объект недвижимости',
        'search_items'       => 'Искать объекты недвижимости',
        'not_found'          => 'Объекты недвижимости не найдены',
        'not_found_in_trash' => 'В корзине объекты недвижимости не найдены',
    );
    
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'publicly_queryable' => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'property' ),
        'capability_type'    => 'post',
        'supports'           => array( 'title', 'editor' ),
    );
    
    register_post_type( 'property', $args );
}
add_action( 'init', 'create_property_post_type' );

function create_district_taxonomy() {
    $labels = array(
        'name'              => 'Районы',
        'singular_name'     => 'Район',
        'search_items'      => 'Искать районы',
        'all_items'         => 'Все районы',
        'parent_item'       => 'Родительский район',
        'parent_item_colon' => 'Родительский район:',
        'edit_item'         => 'Редактировать район',
        'update_item'       => 'Обновить район',
        'add_new_item'      => 'Добавить новый район',
        'new_item_name'     => 'Новое название района',
        'menu_name'         => 'Районы',
    );
    
    $args = array(
        'labels'        => $labels,
        'hierarchical'  => true,
        'public'        => true,
        'rewrite'       => array( 'slug' => 'district' ),
    );
    
    register_taxonomy( 'district', 'property', $args );
}
add_action( 'init', 'create_district_taxonomy' );

function add_property_fields() {
    if ( function_exists( 'acf_add_local_field_group' ) ) {
        acf_add_local_field_group( array(
            'key'      => 'group_property_fields',
            'title'    => 'Поля объекта недвижимости',
            'fields'   => array(
                array(
                    'key'       => 'field_property_name',
                    'label'     => 'Название дома',
                    'name'      => 'property_name',
                    'type'      => 'text',
                ),
                array(
                    'key'       => 'field_property_coordinates',
                    'label'     => 'Координаты местонахождения',
                    'name'      => 'property_coordinates',
                    'type'      => 'text',
                ),
                array(
                    'key'       => 'field_property_floors',
                    'label'     => 'Количество этажей',
                    'name'      => 'property_floors',
                    'type'      => 'number',
                    'min'       => 1,
                    'max'       => 20,
                    'step'      => 1,
                ),
                array(
                    'key'       => 'field_property_building_type',
                    'label'     => 'Тип строения',
                    'name'      => 'property_building_type',
                    'type'      => 'radio',
                    'choices'   => array(
                        'panel'    => 'Панель',
                        'brick'    => 'Кирпич',
                        'block'    => 'Пеноблок',
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'property',
                    ),
                ),
            ),
        ) );
    }
}
add_action( 'acf/init', 'add_property_fields' );

function property_filter_shortcode() {
    ob_start();
    
    include 'templates/property-filter.php';

    return ob_get_clean();
}
add_shortcode( 'property_filter', 'property_filter_shortcode' );

include 'templates/ajax_handler.php';

add_action( 'wp_ajax_property_search', 'property_search_ajax_handler' );
add_action( 'wp_ajax_nopriv_property_search', 'property_search_ajax_handler' );

add_action( 'wp_enqueue_scripts', 'my_custom_scripts' );

function my_custom_scripts() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'filter-ajax', plugins_url( '/js/filter-ajax.js', __FILE__ ), array( 'jquery' ), '1.0', true );
    wp_localize_script('filter-ajax', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}