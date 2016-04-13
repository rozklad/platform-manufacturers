<select name="manufacturers[]" class="form-control" {{ $multiple ? 'multiple' : '' }}>
	
	<option>--------</option>

	@foreach($manufacturers as $manufacturer)

		<option value="{{ $manufacturer->id }}" {{ in_array($manufacturer->id, $active_manufacturers) ? 'selected' : '' }}>{{ $manufacturer->manufacturer_title }}</option>

	@endforeach

</select>