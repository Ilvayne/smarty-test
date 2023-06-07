jQuery(document).ready(function($) {

  $('#property-filter-form').on('submit', function(e) {
      e.preventDefault();
      
      var district = $('#district-select').val();
      var buildingType = $('input[name="building_type"]:checked').val();
      var buildingName = $('input[name="building_name"]').val();
      var buildingСoordinates = $('input[name="building_coordinates"]').val();
      var buildingFloors = $('input[name="building_floors"]').val();
      var data = {
          action: 'property_search',
          district: district,
          building_type: buildingType,
          building_name: buildingName,
          building_coordinates: buildingСoordinates,
          building_floors: buildingFloors,
      };
      
      $.ajax({
          url: ajax_object.ajax_url,
          type: 'POST',
          data: data,
          beforeSend: function() {
              $('#property-results').html('Загрузка...');
          },
          success: function(response) {
              $('#property-results').html(response);
          },
          error: function(xhr, status, error) {
              console.log(error);
          }
      });
  });

  $(document).on('click', '.pagination .page-number', function(e) {
      e.preventDefault();
      
      var page = $(this).data('page');

      var data = {
          action: 'property_search',
          page: page,
          district: $('#district-select').val(),
          building_type: $('input[name="building_type"]:checked').val(),
          building_name: $('input[name="building_name"]').val(),
          building_coordinates: $('input[name="building_coordinates"]').val(),
          building_floors: $('input[name="building_floors"]').val(),
      };

      $.ajax({
          url: ajax_object.ajax_url,
          type: 'POST',
          data: data,
          beforeSend: function() {
              $('#property-results').html('Загрузка...');
          },
          success: function(response) {
              $('#property-results').html(response);
          },
          error: function(xhr, status, error) {
              console.log(error);
          }
      });
  });
});
