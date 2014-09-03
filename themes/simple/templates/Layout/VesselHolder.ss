<aside class="sidebar unit size1of4">
	<% include SecondaryNav %>
</aside>
<div class="content-container unit size4of5 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			<div class="left ObjectTable">
				<table>
				<thead><tr><th colspan="2">$getVesselCount(cutter) Cutters</th></tr></thead>
				<tbody>
				<% if CurrentMember %>
					<tr><td colspan="2"><a href="$getVesselActionPageLink(addCutter)" title="Add a cutter" class="addObject">add a Cutter</a></td></tr>
				<% end_if %>
				<% if getVesselInformation(cutter) %>
					<% loop getVesselInformation(cutter) %>
						<tr><td>$VesselNumber</td><td><a href="$getVesselDetailPageLink" title="Show detail for $VesselClass $VesselName">$VesselName</a></td></tr>
					<% end_loop %>
				<% else %>
					<tr><td colspan="2">No records available</td></tr>
				<% end_if %>
				</tbody></table>
			</div>
			<div class="left ObjectTable">
				<table>
				<thead><tr><th colspan="2">$getVesselCount(sunburst) Sunbursts</th></tr></thead>
				<tbody>
				<% if CurrentMember %>
					<tr><td colspan="2"><a href="$getVesselActionPageLink(addSunburst)" title="Add a sunburst" class="addObject">add a Sunburst</a></td></tr>
				<% end_if %>
				<% if getVesselInformation(sunburst) %>
					<% loop getVesselInformation(sunburst) %>
						<tr>
							<td>$VesselNumber</td>
							<td><a href="$getVesselDetailPageLink" title="Show detail for $VesselClass $VesselName">$VesselName</a></td>
						</tr>
					<% end_loop %>
				<% else %>
					<tr><td colspan="2">No records available</td></tr>
				<% end_if %>
				</tbody></table>
			</div>
			<div class="left ObjectTable">
				<table>
				<thead><tr><th colspan="2">$getVesselCount(kayak) Kayaks</th></tr>
				<tbody>
				<% if CurrentMember %>
					<tr><td colspan="2"><a href="$getVesselActionPageLink(addKayak)" title="Add a kayak" class="addObject">add a Kayak</a></td></tr>
				<% end_if %>
				<% if getVesselInformation(kayak) %>
					<% loop getVesselInformation(kayak) %>
						<tr>
							<td>$VesselNumber</td>
							<td><a href="$getVesselDetailPageLink" title="Show detail for $VesselClass $ID">$VesselName</a></td>
						</tr>
					<% end_loop %>
				<% else %>
					<tr><td colspan="2">No records available</td></tr>
				<% end_if %>
				</tbody></table>
			</div>
			<div class="left ObjectTable">
				<table>
				<thead><tr><th colspan="3">$getVesselCount of everything else</th></tr></thead>
				<tbody>
				<% if CurrentMember %>
					<tr><td colspan="3"><a href="$getVesselActionPageLink(addVessel)" title="Add a vessel" class="addObject">add a Vessel</a></td></tr>
				<% end_if %>
				<% if getVesselInformation %>
					<% loop getVesselInformation %>
						<tr><td>$VesselNumber</td><td>$VesselClass</td><td><a href="$getVesselDetailPageLink" title="Show detail for $VesselClass $VesselName">$VesselName</a></td></tr>
					<% end_loop %>
				<% else %>
					<tr><td colspan="3">No records available</td></tr>
				<% end_if %>
				</tbody></table>
			</div>
		</div>
	</article>
		$Form
		$PageComments
</div>