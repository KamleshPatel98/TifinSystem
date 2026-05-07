@if (count($states) > 0)
<option value="">Select State here ..</option>
@foreach ($states as $id => $name)
<option value="{{ $id }}" @selected(old('state_id')==$id)>{{ $name }}</option>
@endforeach
@else
<option value="">No State found.</option>
@endif