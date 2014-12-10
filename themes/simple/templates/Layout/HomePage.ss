<div class="content-container unit size2of4 lastUnit">
	<article>
		<div class="content">
			<div class="left size1of2">
				<h1>$Title</h1>
				<div class="opaque">$Content</div>
			</div>
			<div class="left size1of2 lastUnit">
				<h1>News and Events</h1>
				<div class="opaque">
					<% loop NextEvent %>
						<div class="eventEntry">
							<h5>Next event</h5>
							<a href="$CalendarPage().Link">$Title:</a> $makeFullDate.Long
						</div>
					<% end_loop %>
				</div>
				<h1>LNI Statistics</h1>
				<div class="opaque">
					
				</div>
			</div>
		</div>
	</article>
</div>