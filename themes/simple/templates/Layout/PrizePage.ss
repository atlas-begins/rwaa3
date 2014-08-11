<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			<div class="left ObjectTable">
				<ul class="tabs" data-persist="true">
					<% if Content %>
						<li><a href="#viewtab1">Description</a></li>
					<% end_if %>
				    <li><a href="#viewtab2">Trophies and Certificates</a></li>
				</ul>
				<div class="tabcontents">
					<% if Content %>
						<div id="viewtab1">
							$Content
						</div>
					<% end_if %>
			    	<div id="viewtab2">
				    	<table>
				    	<thead>
					    	<tr><th>Award</th><th>&nbsp;</th><th>Established</th><th>History</th>
					    	</tr>
				    	</thead>
				    	<tbody>
				    	<% if Trophies %>
				    		<% loop Trophies %>
				    			<tr>
				    			<td><strong>$TrophyName</strong><br><em>for $AwardedFor</em></td>
				    			<td>$TrophyImage.SetRatioSize(30,40)</td>
				    			<td><% if Year %>$Year<% end_if %></td>
				    			<td>$History</td>
				    			</tr>
				    		<% end_loop %>
				    	<% else %>
				    		<tr><td colspan="3">No trophies or certificates available</td></tr>
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