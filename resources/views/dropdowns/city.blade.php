@if (count($cities) > 0)
<option value="">Select City here ..</option>
@foreach ($cities as $id => $name)
<option value="{{ $id }}" @selected(old('city_id')==$id)>{{ $name }}</option>
@endforeach
@else
<option value="">No City found.</option>
@endif