<div class="calendarentry clearfix">
	<a name="$ID"></a>
	
	<div class="calendarDesc">
		<h5>$Title</h5>
		<p><strong><% if TBC %>TBC<% else_if NoDay %> <% else_if StartDate %>$makeFullDate.Long<% end_if %><% if Time %> - $makeFullDate.Time<% end_if %></strong>
		<% if Description %>
			<br>$Description
		<% end_if %>
		<% if HostGroupID %>
			<br>hosted by <% loop HostGroup %>$GroupName<% end_loop %>
		<% end_if %>
		</p>
	</div>
	<% if Image %>
		<p class="calendarImage">
			<% loop Image.setWidth(150) %>
				<img src="$URL" width="$Width" height="$Height" />
			<% end_loop %>
		</p>
	<% end_if %>
	
</div>