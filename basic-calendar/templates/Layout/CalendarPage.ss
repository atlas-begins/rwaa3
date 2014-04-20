<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content opaque">
			<% if ShowPast %>
				<% if getEvents(past) %>
					<p class="pastfuture"><a href="$Link">&raquo; View Upcoming Events</a></p>
					<h3>Past Events</h3>
						<% loop getEvents(past).GroupedBy(Year) %>
							<% loop Children %>
								<% include CalendarEntry %>						
							<% end_loop %>
					<% end_loop %> 
				<% else %>
					<p><strong>There are no past events.</strong></p>
				<% end_if %>
			<% else %>
				<% if getEvents(past) %><p class="pastfuture"><a href="$Link?past">&raquo; View Past Events</a></p><% end_if %>
				<h3>Upcoming Events</h3>
				<% if getEvents(future) %>
					<% loop getEvents(future).GroupedBy(Year) %>	
						<% loop Children %>
							<% include CalendarEntry %>						
						<% end_loop %>
					<% end_loop %>
				<% else %>
					<p><strong>There are no upcoming events.</strong></p>
				<% end_if %>
			<% end_if %>
			<span class="clear">&nbsp;</span>
		</div>
	</article>
		$Form
		$PageComments
</div>









