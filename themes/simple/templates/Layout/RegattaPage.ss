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
					<li><a href="#viewtab2">Events</a></li>
				    <li><a href="#viewtab3">Course Map</a></li>
				    <li><a href="#viewtab4">Prizes</a></li>
				    <li><a href="#viewtab5">Results</a></li>
				</ul>
				<div class="tabcontents">
					<% if Content %>
						<div id="viewtab1">
							$Content
						</div>
					<% end_if %>
					<div id="viewtab2">
						<% if RegattaEvents %>
							Events associated with this Regatta include:<ul>
							<% loop RegattaEvents %>
								<li>$EventDescription</li>
							<% end_loop %>
							</ul>
						<% else %>
							No events have been selected for this Regatta
						<% end_if %>
					</div>
			    	<div id="viewtab3">
				    	course map goes here
					</div>
					<div id="viewtab4">
						<% if RegattaPrizes %>
							Prizes associated with this Regatta include:<ul>
							<% loop RegattaPrizes %>
								<li>$TrophyName</li>
							<% end_loop %>
							</ul>
						<% else %>
							No prizes have been selected for this Regatta
						<% end_if %>
					</div>
					<div id="viewtab5">
						nothing here yet
					</div>
				</div>
			</div>
		</div>
	</article>
		$Form
		$PageComments
</div>