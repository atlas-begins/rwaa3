<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			$Content
			<div class="left ObjectTable">
				<% loop Zone %>
					<table>
					<thead>
						<tr><th colspan="2">Zone: $ZoneName</th></tr>
					</thead>
					<tbody>
						<tr><td colspan="2"><a href="$getZoneDetailPageLink(edit)" title="Edit details for $ZoneName" class="editObject">edit details</a></td></tr>
						
					</tbody>
					</table>
				<% end_loop %>
			</div>
			
			<div class="left ObjectTable">
				<% loop Zone %>
					<table>
					<thead>
						<tr><th colspan="2">Groups in Zone</th></tr>
					</thead>
					<tbody>
						<% loop ScoutGroups %>
							<tr><td class="branch_{$GroupBranch}">$GroupBranch</td>
							<td><a href="$getGroupDetailPageLink" title="View details for $GroupName" class="viewObject">($GroupAcronym) $GroupName</a></td>
							</tr>
						<% end_loop %>
					</tbody>
					</table>
				<% end_loop %>
			</div>
		</div>
	</article>
		$Form
		$PageComments
</div>