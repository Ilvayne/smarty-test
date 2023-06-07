<?php
get_header();

$property_id = get_the_ID();

$property_name = get_field('property_name', $property_id);
$property_coordinates = get_field('property_coordinates', $property_id);
$property_floors = get_field('property_floors', $property_id);
$property_building_type = get_field('property_building_type', $property_id);

echo '<h1>' . get_the_title() . '</h1>';

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
  echo '<p><strong>Тип строения:</strong> ' . $building_type_text . '</p>';
} else {
  echo '<p><strong>Тип строения:</strong> ' . $property_building_type . '</p>';
}
echo do_shortcode( '[property_filter]' );

get_footer();