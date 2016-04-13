<div class="form-group<%= type != 'manufacturer' ? ' hide' : null %>" data-item-type="manufacturer">
	<label class="control-label" for="<%= slug %>_manufacturer_uri">Select a manufacturer</label>

	<select class="form-control input-sm" data-item-form="<%= slug %>" name="children[<%= slug %>][manufacturer][manufacturer_id]" id="<%= slug %>_manufacturer_uri" >
		@foreach ($manufacturers as $manufacturer)
		<option value="{{ $manufacturer->id }}"<%= manufacturer_uri == '{{ $manufacturer->id }}' ? ' selected="selected"' : null %>>/{{ $manufacturer->uri }}</option>
		@endforeach
	</select>
</div>
