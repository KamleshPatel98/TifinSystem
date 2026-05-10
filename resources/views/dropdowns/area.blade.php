@if (count($areas) > 0)
    <option value="">Select Area here ..</option>
    @foreach ($areas as $id => $name)
        <option value="{{ $id }}" @selected(old('area_id')==$id)>{{ $name }}</option>
    @endforeach
@else
    <option value="">No Area found.</option>
@endif