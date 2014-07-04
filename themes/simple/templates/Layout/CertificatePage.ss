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
			            <li><a href="#viewtab1">Certificate details</a></li>
			            <li><a href="#viewtab2">Notes</a></li>
			        </ul>
			        <div class="tabcontents">
			            <div id="viewtab1">
			            	<% loop Certificate %>
								<table>
								<thead>
									<tr><th colspan="2">$completeCertNumber</th></tr>
								</thead>
								<tbody>
									<% if CurrentMember %>
										<tr><td colspan="2"><a href="$getCertDetailPageLink(edit)" title="Edit details for this certificate" class="editObject">edit details</a></td></tr>
									<% end_if %>
									<% loop ScoutVessel %>
										<tr><td>Issued for vessel</td>
										<td><a href="$getVesselDetailPageLink" title="Show detail for $VesselClass $VesselName">$VesselName</a>
										</td></tr>
									<% end_loop %>
									<tr><td>Certificate valid?</td>
									<td><% if CertValid %><img src="{$ThemeDir}/images/valid.png" alt="valid" class="icon" /> yes<% else %><img src="{$ThemeDir}/images/invalid.png" alt="invalid" class="icon" /> no<% end_if %></td></tr>
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
			            	<div class="clear"></div>
			            </div>
			            <div id="viewtab2">
			                <table>
			            	<% loop Certificate %>
								<thead>
									<tr><th colspan="2">Notes</th></tr>
								</thead>
								<tbody>
									<% if CurrentMember %>
										<tr><td colspan="2">$CertNoteForm</td></tr>
									<% end_if %>
									<% loop sortedCertNote %>
										<tr><td nowrap><% loop Author %>$FirstName $Surname<% end_loop %><br>$Created.Nice</td>
										<td>$NoteContents</td></tr>
									<% end_loop %>
								</tbody>
							<% end_loop %>
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