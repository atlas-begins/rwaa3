<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			$Content
			<div class="left ObjectTable">
				<% loop Group %>
					<table>
					<thead>
						<tr><th colspan="2">($GroupAcronym) $GroupName</th></tr>
					</thead>
					<tbody>
						<tr><td colspan="2"><a href="$getGroupDetailPageLink(edit)" title="Edit details for this group" class="editObject">edit details</a></td></tr>
						<tr><td>Branch</td><td>$GroupBranch</td></tr>
						<tr><td>Zone</td><td>
							<% loop GroupZone %><a href="$getZoneDetailPageLink" title="View detail about $ZoneName Zone">$ZoneName</a><% end_loop %>
						</td></tr>
						<tr><td>Short label</td><td>$GroupAcronym</td></tr>
						<tr><td>Located</td><td>$GroupLocality
						<% if GroupAddress %><br>$GroupAddress<% end_if %>
						<% if GroupPhone %><br>$GroupPhone<% end_if %></td></tr>
						<tr><td>Website</td><td><% if GroupWebsite %><a href="$GroupWebsite" title="Group website" target="_blank">$GroupWebsite</a><% end_if %></td></tr>
					</tbody>
					</table>
				<% end_loop %>
			</div>
			
			<div class="left ObjectTable">
				<% loop Group %>
					<table>
					<thead>
						<tr><th colspan="2">People</th></tr>
					</thead>
					<tbody>
						<tr><td colspan="2"><a href="$getGroupDetailPageLink(add)" title="Add a person to this group" class="addObject">add a person</a></td></tr>
					<% loop GroupPeople %>
						<tr>
						<td>
						<% loop PersonRole %>
							$RoleAbbrev 
						<% end_loop %>
						</td>
						<td><a href="$getPersonDetailPageLink" title="View details about $FirstName $Surname">$FirstName $Surname</a></td>
						</tr>
					<% end_loop %>
					</tbody>
					</table>
				<% end_loop %>
			</div>
			
			<div class="left ObjectTable">
				<table>
				<thead>
					<tr><th colspan="3">Group vessels</th></tr>
				</thead>
				<tbody>
					<tr><td colspan="3"><a href="$getGroupDetailPageLink(add)" title="Add a vessel to this group" class="addObject">add a vessel</a></td></tr>
					<% loop Group %>
						<% loop GroupVessels %>
							<tr><td>$VesselClass</td><td>$VesselNumber</td><td><a href="$getVesselDetailPageLink" title="View details for $VesselName">$VesselName</a></td></tr>
						<% end_loop %>
					<% end_loop %>
				</tbody>
				</table>
			</div>
		</div>
	</article>
	$Form
	$PageComments
</div>