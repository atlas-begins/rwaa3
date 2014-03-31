<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			$Content
			
			<% loop allGroupPeople %>
				<table width="50%">
				<thead><tr><th colspan="2">$GroupName</th></tr>
				<tbody>
				<tr><td colspan="2"><a href="$getGroupDetailPageLink(addPerson)" title="Add a person to this group" class="addObject">add a person to this group</a></td></tr>
				<% loop GroupPeople %>
					<tr><td width="25%">
						<% loop PersonRole %>
							$RoleAbbrev 
						<% end_loop %>
					</td>
					<td width="75%"><a href="$getPersonDetailPageLink" title="View details about $FirstName $Surname">$FirstName $Surname</a></td></tr>
				<% end_loop %>
				</tbody>
				</table>
			<% end_loop %>
		</div>
	</article>
		$Form
		$PageComments
</div>