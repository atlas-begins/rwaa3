<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			<div class="left size3of8">
				<% loop allGroupPeople %>
					<table width="100%">
					<thead><tr><th colspan="2"><a href="$getGroupDetailPageLink" title="view details for group $GroupName"><i class="fa fa-users"></i> $GroupName</a></th></tr>
					<tbody>
					<% if CurrentMember %>
						<tr><td colspan="2"><a href="$getGroupDetailPageLink(addPerson)" title="Add a person to this group"><i class="fa fa-plus-circle fa-lg"></i> add a person to this group</a></td></tr>
					<% end_if %>
					<% if activeGroupPeople %>
						<% loop activeGroupPeople %>
							<tr><td width="25%">
								<% loop PersonRole %>
									$RoleAbbrev 
								<% end_loop %>
							</td>
							<td width="75%">$Top.validIcon($PersonActive) <a href="$getPersonDetailPageLink" title="View details about $FirstName $Surname">$FirstName $Surname</a></td></tr>
						<% end_loop %>
					<% else %>
						<tr><td colspan="2">No records available</td></tr>
					<% end_if %>
					</tbody>
					</table>
				<% end_loop %>
			</div>
			
			<div class="left size3of8 lastUnit">
				<table width="100%">
				<thead><tr><th colspan="2">Inactive or Not with a Group</th></tr>
				<tbody>
				<% if CurrentMember %>
					<tr><td colspan="2"><a href="$getGroupDetailPageLink(addPerson)" title="Add a person"><i class="fa fa-plus-circle fa-lg"></i> add a person</a></td></tr>
				<% end_if %>
				<% loop getLoosePeople %>
					<tr><td width="25%">
						<% loop PersonRole %>
							$RoleAbbrev 
						<% end_loop %>
					</td>
					<td width="75%">$Top.validIcon($PersonActive) <a href="$getPersonDetailPageLink" title="View details about $FirstName $Surname">$FirstName $Surname</a></td></tr>
				<% end_loop %>
				</tbody>
				</table>
			</div>
		</div>
	</article>
		$Form
		$PageComments
</div>