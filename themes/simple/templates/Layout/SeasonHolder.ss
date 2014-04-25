<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			<div class="left ObjectTable">
				<table>
				<thead><tr><th>Season label</th><th>Season starts</th><th>Season ends</th></tr></thead>
				<tbody>
				<% if CurrentMember %>
					<tr><td colspan="3"><a href="$getSeasonActionPageLink" title="Add a Season" class="addObject">add a Season</a></td></tr>
				<% end_if %>
				<% if getAllSeasons %>
					<% loop getAllSeasons %>
						<tr><td class="$SeasonClass"><a href="$getSeasonDetailPageLink" title="Show detail for season $Season">$Season</a></td><td class="$SeasonClass">$SeasonStart.Long</td><td class="$SeasonClass">$SeasonEnd.Long</td></tr>
					<% end_loop %>
				<% else %>
					<tr><td colspan="3">No records available</td></tr>
				<% end_if %>
				</tbody></table>
				
				
			</div>
			
			<div class="left">
				<table>
				<thead><tr><th colspan="2">For the current <a href="$getCalendarPage" title="Calendar page">$getCurrentSeason.Season season</a>, we have:</th></tr></thead>
				<tbody>
				<% if getSeasonEvents %>
					<% loop getSeasonEvents %>
						<tr>
							<td>$Title</td>
							<td><strong>$makeFullDate.Long</strong><% if AltLocation %><br>$AltLocation<% end_if %>
							<% if LocationID %>
								<% loop Location %><br>$LocationDescription<% end_loop %>
							<% end_if %></td>
						</tr>
					<% end_loop %>
				<% else %>
					<tr><td colspan="2">No events </td></tr>
				<% end_if %>
				</tbody></table>
			</div>
		</div>
	</article>
		$Form
		$PageComments
</div>