<aside class="sidebar unit size1of4">
	<% include SecondaryNav %>
</aside>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			$Content
			<div class="left ObjectTable">
				<div>
					<ul class="tabs" data-persist="true">
			            <li><a href="#viewtab1">Vessel details</a></li>
			            <li><a href="#viewtab2">Certificates <% loop Vessel %>($getVesselCertificates.Count)<% end_loop %></a></li>
			            <li><a href="#viewtab3">Notes <% loop Vessel %>($sortedVesselNote.Count)<% end_loop %></a></li>
			            <li><a href="#viewtab4">Images</a></li>
			        </ul>
			        <div class="tabcontents">
			            <div id="viewtab1">
			            	<table width="100%">
			            	<% loop Vessel %>
								<thead>
									<tr><th colspan="2">Vessel details for $VesselClass $VesselNumber "$VesselName"</th></tr>
								</thead>
								<tbody>
									<% if CurrentMember %>
										<tr><td colspan="2"><a href="$getVesselDetailPageLink(edit)" title="Edit details for this vessel" class="editObject">edit details</a></td></tr>
									<% end_if %>
									<tr><td>Currently with</td><td>
										<% loop ScoutGroup %><a href="$getGroupDetailPageLink" title="view details for group $GroupName">$GroupName ($GroupAcronym)</a><% end_loop %>
									</td></tr>
									<tr><td>Active?</td><td>$Top.validIcon($VesselActive)</td></tr>
									<tr><td>Class</td><td>$VesselClass</td></tr>
									<tr><td>Construction</td><td>$VesselConstruction</td></tr>
									<tr><td>Rig</td><td>$VesselRig</td></tr>
									<tr><td>Year</td><td><% if VesselYear %>$VesselYear<% else %>unknown<% end_if %></td></tr>
									<tr><td>Sailing capacities (min/min)</td><td>$VesselSailCapacityMin / $VesselSailCapacityMax</td></tr>
									<tr><td>Rowing capacities (min/max)</td><td>$VesselOarCapacityMin / $VesselOarCapacityMax</td></tr>
									<tr><td>Motor capacities (min/max)</td><td>$VesselMotorCapacityMin / $VesselMotorCapacityMax</td></tr>
								</tbody>
							<% end_loop %>
							</table>
			            	<div class="clear"></div>
			            </div>
			            <div id="viewtab2">
			                <table>
			                <% loop Vessel %>
								<thead>
									<tr><th colspan="5">Survey certificates<% if VesselName %> for "$VesselName"<% end_if %></th></tr>
								</thead>
								<tbody>
									<% if CurrentMember %>
										<tr><td colspan="5"><a href="$getCertActionPageLink(add)" title="Add a certificate" class="addObject">add a certificate</a></td></tr>
									<% end_if %>
									<% loop getVesselCertificates %>
										<tr>
											<td><% loop SailingSeason %>$Season<% end_loop %></td>
											<td><% loop ScoutGroup %><a href="$getGroupDetailPageLink" title="view details for group $GroupName">$GroupAcronym</a><% end_loop %></td>
											<% if VesselCertNumber %>
												<td><a href="$getCertDetailPageLink" title="view detail about this certificate">$completeCertNumber</a></td>
												<td><% loop VesselSurveyor %>Srv: $FirstName $Surname<% end_loop %></td>
												<td>$Top.validIcon($CertValid)</td>
											<% else %>
												<td colspan="3">not issued</td>
											<% end_if %>
											</tr>
									<% end_loop %>
								</tbody>
							<% end_loop %>
							</table>
							<div class="clear"></div>
			            </div>
			            <div id="viewtab3">
			            	<table>
			            	<% loop Vessel %>
								<thead>
									<tr><th colspan="2">Notes<% if VesselName %> for "$VesselName"<% end_if %></th></tr>
								</thead>
								<tbody>
									<% if CurrentMember %>
										<tr><td colspan="2">$VesselNoteForm</td></tr>
									<% end_if %>
									<% loop sortedVesselNote %>
										<tr><td nowrap><% loop Author %>$FirstName $Surname<% end_loop %><br>$Created.Nice</td>
										<td>$NoteContents</td></tr>
									<% end_loop %>
								</tbody>
							<% end_loop %>
							</table>
			            	<div class="clear"></div>
			            </div>
			            <div id="viewtab4">
			                <% loop Vessel %>
			                	<table width="100%">
								<thead>
									<tr><th colspan="2">Images<% if VesselName %> of "$VesselName"<% end_if %></th></tr>
								</thead>
								<tbody>
								<% if CurrentMember %>
									<tr><td colspan="2"><a href="#" title="Add image for this vessel" class="addObject" id="imgFormToggle">add image</a>
									<div id="imgForm" style="display: none;">$VesselImageForm</div>
									</td></tr>
								<% end_if %>
								</tbody>
								</table>
							<% end_loop %>
			            </div>
			        </div>
		        </div>
			</div>
		</div>
	</article>
		$Form
		$PageComments
</div>