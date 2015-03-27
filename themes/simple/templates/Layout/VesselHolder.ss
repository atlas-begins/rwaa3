<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			<div class="left ObjectTable">
				<ul class="tabs" data-persist="true">
		            <li><a href="#viewtab1">$getVesselCount(cutter) Cutters</a></li>
		            <li><a href="#viewtab2">$getVesselCount(sunburst) Sunbursts</a></li>
		            <li><a href="#viewtab3">$getVesselCount(kayak) Kayaks</a></li>
		            <li><a href="#viewtab4">$getVesselCount of everything else</a></li>
		            <li><a href="#viewtab5">$getVesselCount(inactive) inactive</a></li>
		        </ul>
				<div class="tabcontents">
					<div id="viewtab1">
						<table>
							<thead><tr><th colspan="4">$getVesselCount(cutter) Cutters</th></tr></thead>
							<tbody>
							<% if CurrentMember %>
								<tr><td colspan="4"><a href="$getVesselActionPageLink(addCutter)" title="Add a cutter"><i class="fa fa-plus-circle fa-lg"></i> add a Cutter</a></td></tr>
							<% end_if %>
							<% if getVesselInformation(cutter) %>
								<tr><th>No.</th><th>Name</th><th>Group</th><th>Latest certificate</th></tr>
								<% loop getVesselInformation(cutter) %>
									<tr>
										<td>$VesselNumber</td>
										<td><a href="$getVesselDetailPageLink" title="Show detail for $VesselClass $VesselName">$Top.validIcon($VesselActive) $VesselName</a></td>
										<td><% loop ScoutGroup %><a href="$getGroupDetailPageLink"><i class="fa fa-users"></i> $GroupName</a><% end_loop %></td>
										<td><% loop getVesselNewestCertificate %><a href="$getCertDetailPageLink" title="View detail for certificate $ID">$Top.validIcon($CertValid) $completeCertNumber</a><% end_loop %></td>
									</tr>
								<% end_loop %>
							<% else %>
								<tr><td colspan="4">No records available</td></tr>
							<% end_if %>
							</tbody>
						</table>
					</div>
					<div id="viewtab2">
						<table>
							<thead><tr><th colspan="5">$getVesselCount(sunburst) Sunbursts</th></tr></thead>
							<tbody>
							<% if CurrentMember %>
								<tr><td colspan="5"><a href="$getVesselActionPageLink(addSunburst)" title="Add a sunburst"><i class="fa fa-plus-circle fa-lg"></i> add a Sunburst</a></td></tr>
							<% end_if %>
							<% if getVesselInformation(sunburst) %>
								<tr><th>No.</th><th>Name</th><th>Group</th><th>Latest certificate</th></tr>
								<% loop getVesselInformation(sunburst) %>
									<tr>
										<td>$VesselNumber</td>
										<td><a href="$getVesselDetailPageLink" title="Show detail for $VesselClass $VesselName">$Top.validIcon($VesselActive) $VesselName</a></td>
										<td><% loop ScoutGroup %><a href="$getGroupDetailPageLink"><i class="fa fa-users"></i> $GroupName</a><% end_loop %></td>
										<td><% loop getVesselNewestCertificate %><a href="$getCertDetailPageLink" title="View detail for certificate $ID">$Top.validIcon($CertValid) $completeCertNumber</a><% end_loop %></td>
									</tr>
								<% end_loop %>
							<% else %>
								<tr><td colspan="5">No records available</td></tr>
							<% end_if %>
							</tbody>
						</table>
					</div>
					<div id="viewtab3">
						<table>
							<thead><tr><th colspan="4">$getVesselCount(kayak) Kayaks</th></tr>
							<tbody>
							<% if CurrentMember %>
								<tr><td colspan="4"><a href="$getVesselActionPageLink(addKayak)" title="Add a kayak"><i class="fa fa-plus-circle fa-lg"></i> add a Kayak</a></td></tr>
							<% end_if %>
							<% if getVesselInformation(kayak) %>
								<tr><th>No.</th><th>Name</th><th>Group</th><th>Latest certificate</th></tr>
								<% loop getVesselInformation(kayak) %>
									<tr>
										<td>$VesselNumber</td>
										<td><a href="$getVesselDetailPageLink" title="Show detail for $VesselClass $ID $VesselName">$Top.validIcon($VesselActive) 
										<% if VesselName %>
											$VesselName
										<% else %>
											$VesselClass
										<% end_if %></a>
										</td>
										<td><% loop ScoutGroup %><a href="$getGroupDetailPageLink"><i class="fa fa-users"></i> $GroupName</a><% end_loop %></td>
										<td><% loop getVesselNewestCertificate %><a href="$getCertDetailPageLink" title="View detail for certificate $ID">$Top.validIcon($CertValid) $completeCertNumber</a><% end_loop %></td>
									</tr>
								<% end_loop %>
							<% else %>
								<tr><td colspan="4">No records available</td></tr>
							<% end_if %>
							</tbody>
						</table>
					</div>
					<div id="viewtab4">
						<table>
							<thead><tr><th colspan="5">$getVesselCount of everything else</th></tr></thead>
							<tbody>
							<% if CurrentMember %>
								<tr><td colspan="5"><a href="$getVesselActionPageLink(addVessel)" title="Add a vessel"><i class="fa fa-plus-circle fa-lg"></i> add a Vessel</a></td></tr>
							<% end_if %>
							<% if getVesselInformation %>
								<tr><th>No.</th><th>Class</th><th>Name</th><th>Group</th><th>Latest certificate</th></tr>
								<% loop getVesselInformation %>
									<tr>
										<td>$VesselNumber</td>
										<td>$VesselClass</td>
										<td><a href="$getVesselDetailPageLink" title="Show detail for $VesselClass $VesselName">$Top.validIcon($VesselActive) $VesselName</a></td>
										<td><% loop ScoutGroup %><a href="$getGroupDetailPageLink"><i class="fa fa-users"></i> $GroupName</a><% end_loop %></td>
										<td><% loop getVesselNewestCertificate %><a href="$getCertDetailPageLink" title="View detail for certificate $ID">$Top.validIcon($CertValid) $completeCertNumber</a><% end_loop %></td>
									</tr>
								<% end_loop %>
							<% else %>
								<tr><td colspan="5">No records available</td></tr>
							<% end_if %>
							</tbody>
						</table>
					</div>
					<div id="viewtab5">
						<table>
							<thead><tr><th colspan="5">$getVesselCount(inactive) inactive vessels</th></tr></thead>
							<tbody>
							<% if getVesselInformation(inactive) %>
								<tr><th>No.</th><th>Class</th><th>Name</th><th>Group</th><th>Latest certificate</th></tr>
								<% loop getVesselInformation(inactive) %>
									<tr>
										<td>$VesselNumber</td>
										<td>$VesselClass</td>
										<td><a href="$getVesselDetailPageLink" title="Show detail for $VesselClass $VesselName">$Top.validIcon($VesselActive) $VesselName</a></td>
										<td><% if ScoutGroup %><% loop ScoutGroup %><a href="$getGroupDetailPageLink"><i class="fa fa-users"></i> $GroupName</a><% end_loop %><% end_if %></td>
										<td><% loop getVesselNewestCertificate %><a href="$getCertDetailPageLink" title="View detail for certificate $ID">$Top.validIcon($CertValid) $completeCertNumber</a><% end_loop %></td>
									</tr>
								<% end_loop %>
							<% else %>
								<tr><td colspan="5">No records available</td></tr>
							<% end_if %>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</article>
	$Form
	$PageComments
</div>