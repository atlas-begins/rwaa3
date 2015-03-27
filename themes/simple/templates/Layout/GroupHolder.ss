<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			<div class="left size3of8">
				<table>
				<thead><tr><th>Branch</th><th>Group/Zone</th></tr>
				<tbody>
				<% if CurrentMember %>
					<tr><td colspan="2"><a href="$getGroupActionPageLink" title="Add a Group"><i class="fa fa-plus-circle fa-lg"></i> add a Group</a></td></tr>
				<% end_if %>
				<% if getGroupInformation %>
					<% loop getGroupInformation %>
						<tr>
							<td class="branch_{$GroupBranch}">$GroupBranch</td>
							<td><a href="$getGroupDetailPageLink" title="Edit details for $GroupName"><i class="fa fa-users"></i> ($GroupAcronym) $GroupName</a>
							<br><% loop GroupZone %><a href="$getZoneLink" title="View details for $ZoneName"><i class="fa fa-puzzle-piece fa-lg"></i> $ZoneName</a><% end_loop %></td>
						</tr>
					<% end_loop %>
				<% else %>
					<tr><td colspan="3">Sorry, no records available</td></tr>
				<% end_if %>
				</tbody>
				</table>
			</div>
			<div class="left size3of8 lastUnit">
				<div id="map_canvas"></div>
			</div>
		</div>
	</article>
</div>

<script type="text/javascript">
	var map,marker,markers,latlng,contentString,infoWindow,bounds,boundsPoint,mapOptions,timeoutInt;
	var markerSrc = {$getGroupMarkerArray};
	function initialize() {
		markers = [];
		// defines map options
		mapOptions = {
    		zoom: 7,
    		center: new google.maps.LatLng(-39.814718, 175.870100),
    		mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		// instantiates map
		map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
		bounds = new google.maps.LatLngBounds();
		timeoutInt = 0;
		var i = 0;
		<% loop getGroupMarkers %>
			setTimeout(function() {
				// creates new map point
				latlng = new google.maps.LatLng(markerSrc[i][4], markerSrc[i][5]);
				var infowindow = new google.maps.InfoWindow({
					content:'<p><strong>'+markerSrc[i][0]+'</strong><br>This is a <strong>'+markerSrc[i][1]+'</strong> group based in '+markerSrc[i][2]+'</p>',
					maxWidth:200
				});
				// creates new marker
				var marker = new google.maps.Marker({
					position: latlng, 
					map: map, 
					animation: google.maps.Animation.DROP,
					title: markerSrc[i][0],
					icon: markerSrc[i][3]
				});
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map,marker);
				});
				
				// updates map bounds
				bounds.extend(latlng);
				map.fitBounds(bounds);
				++i;
			}, timeoutInt * 150);
			timeoutInt++;
		<% end_loop %>
	}

	google.maps.event.addDomListener(window, 'load', initialize);
</script>