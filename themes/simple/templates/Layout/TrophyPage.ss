<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			$Content
		    <div class="left ObjectTable">
		    	<ul class="tabs" data-persist="true">
		            <li><a href="#viewtab1">Image</a></li>
		            <li><a href="#viewtab2">Winners</a></li>
		            <li><a href="#viewtab3">History</a></li>
		            <li><a href="#viewtab4">Notes</a></li>
		        </ul>
		        <div class="tabcontents">
					
		    		<div id="viewtab1">
		        		<% loop Result %>
		        			$TrophyImage.SetRatioSize(600,600)
		        		<% end_loop %>
		    			<div class="clear"></div>
		    		</div>
		    		<div id="viewtab2">
		        		<% loop Result %>
		        			<table>
					    	<thead>
						    	<tr><th>Season</th><th>First</th><th>Second</th><th>Third</th>
						    	</tr>
					    	</thead>
					    	<tbody>
					    		<% loop getWinnerList %>
			        				<tr><td>$Season.Season</td>
			        				<td><% if FirstPlace %>
							    		<% loop FirstPlace %>
							    			<% if First %><% else %> = <% end_if %>
							    			<% loop Group %>
							    				$GroupAcronym
							    			<% end_loop %>
							    		<% end_loop %>
						    		<% else %>
						    			<em>unknown or<br>not awarded</em>
						    		<% end_if %></td>
						    		<td><% if SecondPlace %>
							    		<% loop SecondPlace %>
							    			<% if First %><% else %> = <% end_if %>
							    			<% loop Group %>
							    				$GroupAcronym
							    			<% end_loop %>
							    		<% end_loop %>
						    		<% else %>
						    			<em>unknown or<br>not awarded</em>
						    		<% end_if %></td>
						    		<td><% if ThirdPlace %>
							    		<% loop ThirdPlace %>
							    			<% if First %><% else %> = <% end_if %>
							    			<% loop Group %>
							    				$GroupAcronym
							    			<% end_loop %>
							    		<% end_loop %>
						    		<% else %>
						    			<em>unknown or<br>not awarded</em>
						    		<% end_if %></td>
						    		</tr>
			        			<% end_loop %>
					    	</tbody>
					    	</table>
		        		<% end_loop %>
		    			<div class="clear"></div>
		    		</div>
		    		<div id="viewtab3">
		        		<% loop Result %>
		        			<% if History %>
		        				$History
		        			<% else %>
		        				<p><em>unknown or unavailable</em></p>
		        			<% end_if %>
		        		<% end_loop %>
		    			<div class="clear"></div>
		    		</div>
		    		<div id="viewtab4">
		        		<table>
							<thead>
								<tr><th colspan="2">Notes</th></tr>
							</thead>
							<tbody>
								<% if CurrentMember %>
									<tr><td colspan="2">$TrophyNoteForm</td></tr>
								<% end_if %>
								<% loop Result %>
									<% loop sortedTrophyNote %>
										<tr><td nowrap><% loop Author %>$FirstName $Surname<% end_loop %><br>$Created.Nice</td>
										<td>
										<% if Vessel %>
											<% loop Vessel %>
												<a href="$getVesselDetailPageLink" title="View details for $VesselClass $VesselName">$VesselClass $VesselNumber $VesselName</a><br>
											<% end_loop %>
										<% end_if %>
										<% if Person %>
											<% loop Person %>
												<a href="$getPersonDetailPageLink" title="View details about $FirstName $Surname">$FirstName $Surname</a><br>
											<% end_loop %>
										<% end_if %>
										$NoteContents</td></tr>
									<% end_loop %>
								<% end_loop %>
							</tbody>
						</table>
		    			<div class="clear"></div>
		    		</div>
		    	</div>
		</div>
	</article>
	$Form
	$PageComments
</div>