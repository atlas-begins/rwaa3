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
		    <div class="left ObjectTable">
		    	<ul class="tabs" data-persist="true">
		            <li><a href="#viewtab1">Group details</a></li>
		            <li><a href="#viewtab2">People <% loop Group %>($GroupPeople.Count)<% end_loop %></a></li>
		            <li><a href="#viewtab3">Vessels <% loop Group %>($GroupVessels.Count)<% end_loop %></a></li>
		            <li><a href="#viewtab4">Activities</a></li>
		            <li><a href="#viewtab5">Notes <% loop Group %>($sortedGroupNote.Count)<% end_loop %></a></li>
		        </ul>
		        <div class="tabcontents">
					<div id="viewtab1">
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
		    			<div class="clear"></div>
		    		</div>
		    		<div id="viewtab2">
		        		<% loop Group %>
							<table>
							<thead>
								<tr><th colspan="3">People</th></tr>
							</thead>
							<tbody>
								<% if CurrentMember %>
									<tr><td colspan="3"><a href="$getGroupDetailPageLink(addPerson)" title="Add a person to this group" class="addObject">add a person</a></td></tr>
								<% end_if %>
								<% loop GroupPeople %>
									<tr>
									<td>
									<% loop PersonRole %>
										$RoleAbbrev 
									<% end_loop %>
									</td>
									<td><a href="$getPersonDetailPageLink" title="View details about $FirstName $Surname">$FirstName $Surname</a></td>
									<td>$Top.validIcon($PersonActive)</td>
									</tr>
								<% end_loop %>
							</tbody>
							</table>
						<% end_loop %>
		    			<div class="clear"></div>
		    		</div>
		    		<div id="viewtab3">
		        		<% loop Group %>
							<table>
							<thead>
								<tr><th colspan="4">Vessels</th></tr>
							</thead>
							<tbody>
								<% if CurrentMember %>
									<tr><td colspan="4"><a href="$getGroupAddVesselLink" title="Add a vessel to this group" class="addObject">add a vessel</a></td></tr>
								<% end_if %>
								<% loop GroupVessels %>
									<tr>
									<td>$VesselClass</td>
									<td>$VesselNumber</td>
									<td><a href="$getVesselDetailPageLink" title="View details for $VesselName">$VesselName</a></td>
									<td>$Top.validIcon($VesselActive)</td>
									</tr>
								<% end_loop %>
							</tbody>
							</table>
						<% end_loop %>
		    			<div class="clear"></div>
		    		</div>
		    		<div id="viewtab4">
		        		<% loop Group %>
							<table>
							<thead>
								<tr><th colspan="3">Activities</th></tr>
							</thead>
							<tbody>
								<% if CurrentMember %>
									<tr><td colspan="3"><a href="$getGroupAddVesselLink" title="Add an activity to this group" class="addObject">add an activity</a></td></tr>
								<% end_if %>
							</tbody>
							</table>
						<% end_loop %>
		    			<div class="clear"></div>
		    		</div>
		    		<div id="viewtab5">
		        		<table>
							<thead>
								<tr><th colspan="2">Notes</th></tr>
							</thead>
							<tbody>
								<% if CurrentMember %>
									<tr><td colspan="2">$GroupNoteForm</td></tr>
								<% end_if %>
								<% loop Group %>
									<% loop sortedGroupNote %>
										<tr><td nowrap><% loop Author %>$FirstName $Surname<% end_loop %><br>$Created.Nice</td>
										<td>
										<% if Vessel %>
											<% loop Vessel %>
												<a href="$getVesselDetailPageLink" title="View details for $VesselClass $VesselName">$VesselClass $VesselNumber $VesselName</a><br>
											<% end_loop %>
										<% end_if %>
										<% if Person %>
											<% loop Person %>
												<a href="$getPersonDetailPageLink" title="View details about $FirstName $Surname">$FirstName $Surname</a><br>
											<% end_loop %>
										<% end_if %>
										$NoteContents</td></tr>
									<% end_loop %>
								<% end_loop %>
							</tbody>
						</table>
		    			<div class="clear"></div>
		    		</div>
		    	</div>
		</div>
	</article>
	$Form
	$PageComments
</div>