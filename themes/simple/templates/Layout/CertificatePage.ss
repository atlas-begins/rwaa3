<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			$Content
			<div class="left ObjectTable">
				<% loop Certificate %>
					<table>
					<thead>
						<tr><th colspan="2">$completeCertNumber</th></tr>
					</thead>
					<tbody>
						<tr><td colspan="2"><a href="$getCertDetailPageLink(edit)" title="Edit details for this certificate" class="editObject">edit details</a></td></tr>
						<% loop ScoutVessel %>
							<tr><td>Issued for vessel</td>
							<td><a href="$getVesselDetailPageLink" title="Show detail for $VesselClass $VesselName">$VesselName</a>
							</td></tr>
						<% end_loop %>
						<% loop ScoutGroup %>
							<tr><td>Belonging to group</td>
							<td><a href="$getGroupDetailPageLink" title="Show detail for $GroupName">$GroupName</a>
							</td></tr>
						<% end_loop %>
						<% loop SailingSeason %>
							<tr><td>For the season</td>
							<td>$Season</td></tr>
						<% end_loop %>
						<% loop VesselSurveyor %>
							<tr><td>Surveyed by</td>
							<td>$FirstName $Surname</td></tr>
						<% end_loop %>
						<tr><td>Issue date</td>
						<td>$IssueDate.Long</td></tr>
						<% loop IssuedBy %>
							<tr><td>Issued by</td>
							<td>$FirstName $Surname</td></tr>
						<% end_loop %>
						<% loop SurveyForm %>
							<tr><td>View the form</td>
							<td><% if ID %>$ID<% else %>scan not available<% end_if %></td></tr>
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