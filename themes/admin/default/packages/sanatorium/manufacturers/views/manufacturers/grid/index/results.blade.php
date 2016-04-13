<script type="text/template" data-grid="manufacturers" data-template="results">

	<% _.each(results, function(r) { %>

		<tr data-grid-row>
			<td><input content="id" input data-grid-checkbox="" name="entries[]" type="checkbox" value="<%= r.id %>"></td>
			<td><a href="<%= r.edit_uri %>"><%= r.id %></a></td>
			<td><a href="<%= r.edit_uri %>"><%= r.manufacturer_title %></a></td>
			<td><a href="<%= r.edit_uri %>"><%= r.slug %></a></td>
			<td><%= r.created_at %></td>
		</tr>

	<% }); %>

</script>
