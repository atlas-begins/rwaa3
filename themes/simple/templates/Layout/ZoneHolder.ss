<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			<div class="left ObjectTable">
				<table>
				<thead><tr><th>Zone</th></tr></thead>
				<tbody>
				<% if CurrentMember %>
					<tr><td><a href="$getZoneLink(add)" title="Add a new Zone record" class="addObject">add a zone</a></td></tr>
				<% end_if %>
				<% if getAllZones %>
					<% loop getAllZones %>
						<tr><td><a href="$getZoneDetailPageLink" title="Show detail for zone $ZoneName">$ZoneName</a></td></tr>
					<% end_loop %>
				<% else %>
					<tr><td>No records available</td></tr>
				<% end_if %>
				</tbody>
				</table>
			</div>
		</div>
	</article>
		$Form
		$PageComments
</div>