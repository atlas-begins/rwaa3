<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			$Content
			<div class="left ObjectTable">
				<div>
					<ul class="tabs" data-persist="true">
			            <li><a href="#viewtab1"><% loop Person %>{$FirstName}'s details<% end_loop %></a></li>
			            <li><a href="#viewtab2">Charge certificate</a></li>
			            <li><a href="#viewtab3">Notes <% loop Person %>($sortedPersonNote.Count)<% end_loop %></a></li>
			        </ul>
					<div class="tabcontents">
			            <div id="viewtab1">
			            	<% loop Person %>
								<table>
								<thead>
									<tr><th colspan="2">$FirstName $Surname</th></tr>
								</thead>
								<tbody>
									<tr><td colspan="2"><a href="$getReportPageLink()" title="View PDF report for this person" target="_blank"><i class="fa fa-file-pdf-o fa-lg"></i> view PDF report</a></td></tr>
									<% if CurrentMember %>
										<tr><td colspan="2"><a href="$getPersonDetailPageLink(edit)" title="Edit details for $FirstName $Surname"><i class="fa fa-pencil-square-o fa-lg"></i> edit details</a></td></tr>
									<% end_if %>
									<tr><td>Currently with</td><td>
										<% if ScoutGroup %>
											<% loop ScoutGroup %>
												<a href="$getGroupDetailPageLink" title="view details for group $GroupName"><i class="fa fa-users"></i> $GroupName</a>
											<% end_loop %>
										<% else %>
											Not affiliated with a Group
										<% end_if %>
									</td></tr>
									<tr><td>Active?</td><td>$Top.validIcon($PersonActive)</td></tr>
									<tr><td>Roles</td><td>
										<% loop PersonRole %>
											($RoleAbbrev) $Role<br>
										<% end_loop %>
									</td></tr>
								</tbody>
								</table>
							<% end_loop %>
							<div class="clear"></div>
			            </div>
			            <div id="viewtab2">
							<% loop Person %>
								<table>
								<thead>
									<tr><th colspan="2">Charge certificate and endorsements</th></tr>
								</thead>
								<tbody>
								<% if PersonCharge %>
									<% loop PersonCharge %>
										<tr><td>Year</td><td>
										($ChargeType) $ChargeDescription<br>
										</td></tr>
									<% end_loop %>
								<% else %>
									<tr><td colspan="2"><a href="$getPersonDetailPageLink(createCharge)" title="Create a charge certificate for $FirstName $Surname"><i class="fa fa-plus-circle fa-lg"></i> create a charge certificate</a></td></tr>
								<% end_if %>
								</tbody>
								</table>
							<% end_loop %>
							<div class="clear"></div>
			            </div>
			            <div id="viewtab3">
			            	<table>
								<thead>
									<tr><th colspan="2">Notes</th></tr>
								</thead>
								<tbody>
									<% if CurrentMember %>
										<tr><td colspan="2">$PersonNoteForm</td></tr>
									<% end_if %>
									<% loop Person %>
										<% loop sortedPersonNote %>
											<tr><td nowrap><% loop Author %>$FirstName $Surname<% end_loop %><br>$Created.Nice</td>
											<td>$NoteContents</td></tr>
										<% end_loop %>
									<% end_loop %>
								</tbody>
							</table>
			            	<div class="clear"></div>
			            </div>
					</div>
				</div>
			</div>
		</div>
	</article>
		$Form
		$PageComments
</div>