<div id="property-filter">
    <h2>Фильтр по объектам недвижимости</h2>

    <form id="property-filter-form">
        <div class="form-group">
            <label for="district-select">Район:</label>
            <select name="district" id="district-select">
                <option value="">Все районы</option>
                <?php

                $districts = get_terms( array(
                    'taxonomy'   => 'district',
                    'hide_empty' => false,
                ) );
                
                foreach ($districts as $district) {
                    echo '<option value="' . $district->slug . '">' . $district->name . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label>Название дома:</label>
            <input name="building_name" type="text">
        </div>

        <div class="form-group">
            <label>Координаты местонахождения:</label>
            <input name="building_coordinates" type="text">
        </div>

        <div class="form-group">
            <label>Количество этажей:</label>
            <input name="building_floors" type="number">
        </div>

        <div class="form-group">
            <label>Тип строения:</label>
            <div class="radio-group">
                <label>
                    <input type="radio" name="building_type" value="" checked> Любой тип
                </label>
                <label>
                    <input type="radio" name="building_type" value="panel"> Панель
                </label>
                <label>
                    <input type="radio" name="building_type" value="brick"> Кирпич
                </label>
                <label>
                    <input type="radio" name="building_type" value="block"> Пеноблок
                </label>
            </div>
        </div>

        <div class="form-group">
            <input type="submit" value="Применить фильтр">
        </div>
    </form>

    <div id="property-results">
 
    </div>
</div>