{{-- state List --}}
function getStateList() {
    var editStateId = $('#edit_state_id').val();
    $.ajax({
        type: "GET",
        url: "{{ route('dropdowns.state') }}",
        success: function (response) {
            $('#state_id').html('');
            $('#state_id').html(response);
            $('#address_state_id').html(response);
            if(editStateId){
                $('#state_id').val(editStateId);
            }
        }
    });
}
getStateList();

{{-- City List--}}
function getCityList() {
    var stateId = $('#state_id').val();
    if(stateId == null){
        stateId = $('#edit_state_id').val();
    }
    var editCityId = $('#edit_city_id').val();

    $.ajax({
        type: "GET",
        url: "{{ route('dropdowns.city') }}",
        data: {
            state_id: stateId
        },
        success: function (response) {
            $('#city_id').html('');
            $('#city_id').html(response);
            $('#address_city_id').html(response);
            if(editCityId){
                $('#city_id').val(editCityId);
            }
        }
    });
}

{{-- Area List--}}
function getAreaList() {
    var cityId = $('#city_id').val();
    if(cityId == null){
        cityId = $('#edit_area_id').val();
    }
    var editAreaId = $('#edit_area_id').val();

    $.ajax({
        type: "GET",
        url: "{{ route('dropdowns.area') }}",
        data: {
            city_id: cityId
        },
        success: function (response) {
            $('#area_id').html('');
            $('#area_id').html(response);
            $('#address_area_id').html(response);
            if(editAreaId){
                $('#area_id').val(editAreaId);
            }
        }
    });
}