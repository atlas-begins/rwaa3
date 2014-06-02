<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			$Content
			<div class="left ObjectTable">
				<% loop Person %>
					<table>
					<thead>
						<tr><th colspan="2">$FirstName $Surname</th></tr>
					</thead>
					<tbody>
						<% if CurrentMember %>
							<tr><td colspan="2"><a href="$getPersonDetailPageLink(edit)" title="Edit details for $FirstName $Surname" class="editObject">edit details</a></td></tr>
						<% end_if %>
						<tr><td>Currently with</td><td>
							<% loop ScoutGroup %><a href="$getGroupDetailPageLink" title="view details for group $GroupName">$GroupName</a><% end_loop %>
						</td></tr>
						<tr><td>Active?</td><td><% if PersonActive %>yes<% else %>no<% end_if %></td></tr>
						<tr><td>Roles</td><td>
							<% loop PersonRole %>
								($RoleAbbrev) $Role<br>
							<% end_loop %>
						</td></tr>
					</tbody>
					</table>
				<% end_loop %>
			</div>
			
			<div class="left ObjectTable">
				<% loop Person %>
					<table>
					<thead>
						<tr><th colspan="2">Charge endorsements</th></tr>
					</thead>
					<tbody>
					<% if PersonCharge %>
						<% loop PersonCharge %>
							<tr><td>Year</td><td>
							($ChargeType) $ChargeDescription<br>
							</td></tr>
						<% end_loop %>
					<% else %>
						<tr><td colspan="2">No records yet</td></tr>
					<% end_if %>
					</tbody>
					</table>
				<% end_loop %>
			</div>
		</div>
	</article>
		$Form
		$PageComments
</div>