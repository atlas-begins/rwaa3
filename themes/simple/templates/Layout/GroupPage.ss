<script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  </script>
<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			$Content
			
			<div id="tabs">
			  <ul>
			    <li><a href="#tabs-1">Group details</a></li>
			    <li><a href="#tabs-2">Location map</a></li>
			  </ul>
			  <div id="tabs-1">
			    <div class="left ObjectTable">
					<% loop Group %>
						<table>
						<thead>
							<tr><th colspan="2">($GroupAcronym) $GroupName</th></tr>
						</thead>
						<tbody>
							<% if CurrentMember %>
								<tr><td colspan="2"><a href="$getGroupDetailPageLink(edit)" title="Edit details for this group" class="editObject">edit details</a></td></tr>
							<% end_if %>
							<tr><td>Branch</td><td class="branch_{$GroupBranch}">$GroupBranch</td></tr>
							<tr><td>Zone</td><td>
								<% loop GroupZone %><a href="$getZoneDetailPageLink" title="View detail about $ZoneName Zone">$ZoneName</a><% end_loop %>
							</td></tr>
							<tr><td>Short label</td><td>$GroupAcronym</td></tr>
							<tr><td>Meeting nights</td><td>Scouts: $GroupScoutMeet<br>Venturers: $GroupVenturerMeet</td></tr>
							<tr><td>Located</td><td>$GroupLocality
								<% if GroupAddress %><br>$GroupAddress<% end_if %>
								<% if GroupPhone %><br>$GroupPhone<% end_if %>
							</td></tr>
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
						<% if CurrentMember %>
							<tr><td colspan="2"><a href="$getGroupDetailPageLink(addPerson)" title="Add a person to this group" class="addObject">add a person</a></td></tr>
						<% end_if %>
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
			
			<div class="ObjectTable">
				<% loop Group %>
					<table>
					<thead>
						<tr><th colspan="3">Group vessels</th></tr>
					</thead>
					<tbody>
						<% if CurrentMember %>
							<tr><td colspan="3"><a href="$getGroupAddVesselLink" title="Add a vessel to this group" class="addObject">add a vessel</a></td></tr>
						<% end_if %>
						<% loop GroupVessels %>
							<tr><td>$VesselClass</td><td>$VesselNumber</td><td><a href="$getVesselDetailPageLink" title="View details for $VesselName">$VesselName</a></td></tr>
						<% end_loop %>
					</tbody>
					</table>
				<% end_loop %>
			</div>
			    
			  </div>
			  <div id="tabs-2">
			    <p>Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
			  </div>
			</div>
			
			
			
			
		</div>
	</article>
	$Form
	$PageComments
</div>