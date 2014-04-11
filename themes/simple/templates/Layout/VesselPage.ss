<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			$Content
			<div class="left ObjectTable">
				<% loop Vessel %>
					<table>
					<thead>
						<tr><th colspan="2"><% if VesselName %><% else %>$VesselClass <% end_if %>$VesselNumber $VesselName</th></tr>
					</thead>
					<tbody>
						<% if CurrentMember %>
							<tr><td colspan="2"><a href="$getVesselDetailPageLink(edit)" title="Edit details for this vessel" class="editObject">edit details</a></td></tr>
						<% end_if %>
						<tr><td>Currently with</td><td>
							<% loop ScoutGroup %><a href="$getGroupDetailPageLink" title="view details for group $GroupName">$GroupName ($GroupAcronym)</a><% end_loop %>
						</td></tr>
						<tr><td>Active?</td><td><% if VesselActive %>yes<% else %>no<% end_if %></td></tr>
						<tr><td>Class</td><td>$VesselClass</td></tr>
						<tr><td>Construction</td><td>$VesselConstruction</td></tr>
						<tr><td>Year</td><td><% if VesselYear %>$VesselYear<% else %>unknown<% end_if %></td></tr>
						<tr><td>Sailing capacities</td><td>Min $VesselSailCapacityMin<br>Max $VesselSailCapacityMax</td></tr>
						<tr><td>Rowing capacities</td><td>Min $VesselOarCapacityMin<br>Max $VesselOarCapacityMax</td></tr>
						<tr><td>Motor capacities</td><td>Min $VesselMotorCapacityMin<br>Max $VesselMotorCapacityMax</td></tr>
					</tbody>
					</table>
				<% end_loop %>
			</div>
			
			<div class="left ObjectTable">
				<% loop Vessel %>
					<table>
					<thead>
						<tr><th colspan="4">Survey certificates<% if VesselName %> for "$VesselName"<% end_if %></th></tr>
					</thead>
					<tbody>
						<% if CurrentMember %>
							<tr><td colspan="4"><a href="$getCertActionPageLink(add)" title="Add a certificate" class="addObject">add a certificate</a></td></tr>
						<% end_if %>
						<% loop getVesselCertificates %>
							<tr>
								<td><% loop SailingSeason %>$Season<% end_loop %></td>
								<td><% loop ScoutGroup %><a href="$getGroupDetailPageLink" title="view details for group $GroupName">$GroupAcronym</a><% end_loop %></td>
								<% if VesselCertNumber %>
									<td><a href="$getCertDetailPageLink" title="view detail about this certificate">$completeCertNumber</a></td>
									<td><% loop VesselSurveyor %>Surveyor: $FirstName $Surname<% end_loop %></td>
								<% else %>
									<td colspan="3">not issued</td>
								<% end_if %>
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