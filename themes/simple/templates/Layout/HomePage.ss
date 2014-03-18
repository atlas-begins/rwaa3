<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<div class="content">
			<div class="left size2of5">
				<h1>$Title</h1>
				<div class="opaque">$Content</div>
			</div>
			<div class="left size1of5">
				&nbsp;
			</div>
			<div class="left size2of5">
			<h1>Statistics</h1>
				<% loop HomePageStats %>
					<table>
					<tr><td>Zones:</a></td><td>$ZoneCount</td></tr>
					<tr><td>Scout groups:</a></td><td>$GroupCount</td></tr>
					<tr><td>Scout vessels (active):</td><td>$VesselCount</td></tr>
					<tr><td>People (active):</td><td>$PersonCount</td></tr>
					<tr><td>Vessel certificates issued this season:</td><td>$CertCount</td></tr>
					</table>
				<% end_loop %>
			</div>
		</div>
	</article>
</div>