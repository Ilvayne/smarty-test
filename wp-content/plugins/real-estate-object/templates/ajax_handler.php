<?php 

function property_search_ajax_handler() {

$district = $_POST['district'];
$buildingType = isset($_POST['building_type']) ? $_POST['building_type'] : '';
$buildingName = isset($_POST['building_name']) ? $_POST['building_name'] : '';
$buildingСoordinates = isset($_POST['building_coordinates']) ? $_POST['building_coordinates'] : '';
$buildingFloors = isset($_POST['building_floors']) ? $_POST['building_floors'] : '';
$page = isset($_POST['page']) ? $_POST['page'] : 1;

$args = array(
    'post_type'      => 'property',
    'posts_per_page' => 3,
    'paged'          => $page,
    'tax_query'      => array(),
);

if (!empty($district)) {
    $args['tax_query'][] = array(
        'taxonomy' => 'district',
        'field'    => 'slug',
        'terms'    => $district,
    );
}

if (!empty($buildingName)) {
    $args['meta_query'][] = array(
        'key'     => 'property_name',
        'value'   => $buildingName,
        'compare' => 'LIKE',
    );
}

if (!empty($buildingСoordinates)) {
    $args['meta_query'][] = array(
        'key'     => 'property_coordinates',
        'value'   => $buildingСoordinates,
        'compare' => 'LIKE',
    );
}

if (!empty($buildingFloors)) {
    $args['meta_query'][] = array(
        'key'     => 'property_floors',
        'value'   => $buildingFloors,
        'compare' => '=',
    );
}

if (!empty($buildingType)) {
    $args['meta_query'][] = array(
        'key'     => 'property_building_type',
        'value'   => $buildingType, 
        'compare' => '=', 
    );
}

$query = new WP_Query($args);

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();

        $property_id = get_the_ID();

        $property_name = get_field('property_name', $property_id);
        $property_coordinates = get_field('property_coordinates', $property_id);
        $property_floors = get_field('property_floors', $property_id);
        $property_building_type = get_field('property_building_type', $property_id);

        echo '<div class="property"><h1>' . get_the_title() . '</h1>';

        echo '<p><strong>Название дома:</strong> ' . $property_name . '</p>';

        echo '<p><strong>Координаты местонахождения:</strong> ' . $property_coordinates . '</p>';

        echo '<p><strong>Количество этажей:</strong> ' . $property_floors . '</p>';

        $building_types = array(
            'panel' => 'Панель',
            'brick' => 'Кирпич',
            'block' => 'Пеноблок',
        );

        if (isset($building_types[$property_building_type])) {
            $building_type_text = $building_types[$property_building_type];
            echo '<p><strong>Тип строения:</strong> ' . $building_type_text . '</p></div>';
        } else {
            echo '<p><strong>Тип строения:</strong> ' . $property_building_type . '</p></div>';
        }
    }
    wp_reset_postdata();

    $total_pages = $query->max_num_pages;

    if ($total_pages > 1) {
        echo '<div class="pagination">';
        for ($i = 1; $i <= $total_pages; $i++) {
            $active_class = ($i == $page) ? 'active' : '';
            echo '<a href="#" class="page-number ' . $active_class . '" data-page="' . $i . '">' . $i . '</a>';
        }
        echo '</div>';
    }
} else {
    echo 'Нет результатов.';
}

wp_die();
}
?>