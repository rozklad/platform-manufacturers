<?php
    $childId   = ! empty($child) ? "{$child->id}_%s" : 'new-child_%s';
    $childName = ! empty($child) ? "children[{$child->id}]%s" : 'new-child_%s';
?>

<div class="form-group{{ (empty($child) || ( ! empty($child) and $child->type != 'manufacturer')) ? ' hide' : null }}" data-item-type="manufacturer">
	<label class="control-label" for="{{ sprintf($childId, 'manufacturer_id') }}">Select a manufacturer</label>

	<select class="form-control input-sm" data-item-form="{{{ ! empty($child) ? $child->id : 'new-child' }}}" name="{{ sprintf($childName, '[manufacturer][manufacturer_id]') }}" id="{{ sprintf($childId, 'manufacturer_uri') }}">
		@foreach ($manufacturers as $manufacturer)
		<option value="{{ $manufacturer->id }}"{{ Input::old('manufacturer.manufacturer_id', ! empty($child) ? $child->manufacturer_id : null) == $manufacturer->id ? ' selected="selected"' : null }}>{{ $manufacturer->uri ?: '/' }}</option>
		@endforeach
	</select>
</div>
