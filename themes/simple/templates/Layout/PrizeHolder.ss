<aside class="sidebar unit size1of4">
	<% include SecondaryNav %>
</aside>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			$Content
			<div class="left ObjectTable">
				<ul class="tabs" data-persist="true">
				    <% loop getRecentPrizeSeasons(20) %>
				    	<li><a href="#viewtab{$ID}">$Season</a></li>
				    <% end_loop %>
				</ul>
				<div class="tabcontents">$prizeSeason
					<% loop getRecentPrizeSeasons(20) %>
				    	<div id="viewtab{$ID}">
				    		<% loop getSortedPrizePages($ID) %>
								<h4><a href="$Link()" title="Prize category: $Title">$SeasonName $Title</a></h4>
								<table width="100%">
								<thead>
									<tr><th>Award</th><th>&nbsp;</th><th>First</th><th>Second</th><th>Third</th></tr>
								</thead>
								<tbody>
								<% if getSeasonTrophies($SeasonID) %>
									<% loop getSeasonTrophies($SeasonID) %>
								    	<tr><td><strong>$TrophyName</strong><br><em>for $AwardedFor</em></td>
								    	<td width="50px" align="center">$TrophyImage.SetRatioSize(30,40)</td>
								    	<td width="20%">
								    		<% if FirstPlace %>
									    		<% loop FirstPlace %>
									    			<% if First %><% else %> = <% end_if %>
									    			<% loop Group %>
									    				$GroupAcronym
									    			<% end_loop %>
									    		<% end_loop %>
								    		<% else %>
								    			<em>unknown or<br>not awarded</em>
								    		<% end_if %>
								    	</td>
								    	<td width="20%">
								    		<% if SecondPlace %>
									    		<% loop SecondPlace %>
									    			<% if First %><% else %> = <% end_if %>
									    			<% loop Group %>
									    				<% if First %><% else %> = <% end_if %>$GroupAcronym
									    			<% end_loop %>
									    		<% end_loop %>
								    		<% else %>
								    			<em>unknown or<br>not awarded</em>
								    		<% end_if %>
								    	</td>
								    	<td width="20%">
								    		<% if ThirdPlace %>
									    		<% loop ThirdPlace %>
									    			<% if First %><% else %> = <% end_if %>
									    			<% loop Group %>
									    				<% if First %><% else %> = <% end_if %>$GroupAcronym
									    			<% end_loop %>
									    		<% end_loop %>
								    		<% else %>
								    			<em>unknown or<br>not awarded</em>
								    		<% end_if %>
								    	</td>
								    	</tr>
								    <% end_loop %>
								<% else %>
								   	<tr><td colspan="5">No trophies or certificates available</td></tr>
								<% end_if %>
							    </tbody>
							    </table>
							<% end_loop %>
						</div>
				    <% end_loop %>
				</div>
			</div>
		</div>
	</article>
		$Form
		$PageComments
</div>