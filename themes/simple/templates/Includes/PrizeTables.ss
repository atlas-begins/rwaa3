<% loop getSortedPrizePages %>
	<h4>$ID $Top.Season <a href="$Link()" title="$Title">$Title</a></h4>
	<table width="100%">
	<thead>
		<tr><th>Award</th><th>&nbsp;</th><th>First</th><th>Second</th><th>Third</th></tr>
	</thead>
	<tbody>
	<% loop getSeasonTrophies(Top.ID) %>
    	<tr><td><strong>$Top.ID $ID $TrophyName</strong><br><em>$AwardedFor</em></td>
    	<td width="50px" align="center">$TrophyImage.SetRatioSize(30,40)</td>
    	<% loop getTrophySeasonAward(Top.ID) %>
    		<td width="20%"></td>
    	<% end_loop %>
    	</tr>
    <% end_loop %>
    </tbody>
    </table>
<% end_loop %>