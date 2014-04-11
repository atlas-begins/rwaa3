<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			<table>
			<thead><tr><th>Branch</th><th>Group</th><th>Zone</th></tr>
			<tbody>
			<% if CurrentMember %>
				<tr><td colspan="3"><a href="$getGroupActionPageLink" class="addObject" title="Add a Group">add a Group</a></td></tr>
			<% end_if %>
			<% if getGroupInformation %>
				<% loop getGroupInformation %>
					<tr>
						<td class="branch_{$GroupBranch}">$GroupBranch</td>
						<td><a href="$getGroupDetailPageLink" title="Edit details for $GroupName">$GroupName</a></td>
						<td><% loop GroupZone %><a href="$getZoneLink" title="View details for $ZoneName">$ZoneName</a><% end_loop %></td>
					</tr>
				<% end_loop %>
			<% else %>
				<tr><td colspan="3">Sorry, no records available</td></tr>
			<% end_if %>
			</tbody>
			</table>
		</div>
	</article>
</div>