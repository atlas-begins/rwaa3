<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			$Content
			<div class="left ObjectTable">
				<% loop Vessel %>
					<table class="left">
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
						<tr><td>Rig</td><td>$VesselRig</td></tr>
						<tr><td>Year</td><td><% if VesselYear %>$VesselYear<% else %>unknown<% end_if %></td></tr>
						<tr><td>Sailing capacities (min/min)</td><td>$VesselSailCapacityMin / $VesselSailCapacityMax</td></tr>
						<tr><td>Rowing capacities (min/max)</td><td>$VesselOarCapacityMin / $VesselOarCapacityMax</td></tr>
						<tr><td>Motor capacities (min/max)</td><td>$VesselMotorCapacityMin / $VesselMotorCapacityMax</td></tr>
						<% if CurrentMember %>
							<tr><td colspan="2"><a href="#" title="Add note for this vessel" class="addObject" id="noteFormToggle">add note</a>
							<div id="noteForm" style="display: none;">$VesselNoteForm</div>
							</td></tr>
							<tr><td colspan="2"><a href="#" title="Add photo for this vessel" class="addObject" id="imgFormToggle">add photo</a>
							<div id="imgForm" style="display: none;">$VesselImageForm</div>
							</td></tr>
						<% end_if %>
					</tbody>
					</table>
				
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
									<td><% loop VesselSurveyor %>Srv: $FirstName $Surname<% end_loop %></td>
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