<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			<div class="left ObjectTable">
				<table>
				<thead><tr><th>Season label</th><th>Season start</th><th>Season end</th></tr></thead>
				<tbody>
				<tr><td colspan="3"><a href="" title="" class="addObject">Add a season</a></td></tr>
				<% if getAllSeasons %>
					<% loop getAllSeasons %>
						<tr class="$SeasonClass"><td><a href="$getSeasonDetailPageLink" title="Show detail for season $Season">$Season</a></td><td>$SeasonStart.Long</td><td>$SeasonEnd.Long</td></tr>
					<% end_loop %>
				<% else %>
					<tr><td colspan="2">No records available</td></tr>
				<% end_if %>
				</tbody></table>
			</div>
			
			<div class="left">
				For the current $getCurrentSeason.Season season, we have:
			</div>
		</div>
	</article>
		$Form
		$PageComments
</div>