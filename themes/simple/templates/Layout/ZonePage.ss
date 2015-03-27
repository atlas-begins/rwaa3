<aside class="sidebar unit size1of4">
	<% include SecondaryNav %>
</aside>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			$Content
			
			<div class="left ObjectTable">
				<% loop Zone %>
					<table>
					<thead>
						<tr><th colspan="2">Groups in $ZoneName Zone</th></tr>
					</thead>
					<tbody>
						<tr><td colspan="2"><a href="$getZoneDetailPageLink(edit)" title="Edit details for $ZoneName"><i class="fa fa-pencil-square-o fa-lg"></i> edit details</a></td></tr>
						<% loop ScoutGroups %>
							<tr><td class="branch_{$GroupBranch}">$GroupBranch</td>
							<td><a href="$getGroupDetailPageLink" title="View details for $GroupName"><i class="fa fa-users"></i> ($GroupAcronym) $GroupName</a></td>
							</tr>
						<% end_loop %>
					</tbody>
					</table>
				<% end_loop %>
			</div>
		</div>
	</article>
</div>