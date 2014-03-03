<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			<table>
			<thead><tr><th>Branch</th><th>Group</th><th>Zone</th></tr>
			<tbody>
			<tr><td colspan="3"><a href="" class="addObject" title="Add a new Group">add a new Group</a></td></tr>
			<% if getGroupInformation %>
				<% loop getGroupInformation %>
					<tr>
						<td class="branch_{$GroupBranch}">$GroupBranch</td>
						<td><a href="$getGroupDetailPageLink" title="Edit details for $GroupName">$GroupName</a></td>
						<td><% loop GroupZone %><a href="$getZoneLink" title="View details for $ZoneName">$ZoneName</a><% end_loop %></td>
					</tr>
				<% end_loop %>
			<% else %>
				<tr><td colspan="3">Sorry, no groups available yet</td></tr>
			<% end_if %>
			</tbody>
			</table>
		</div>
	</article>
		$Form
		$PageComments
</div>