<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			<div class="left size3of8">
				<table>
				<thead><tr><th>Branch</th><th>Group</th><th>Zone</th></tr>
				<tbody>
				<% if CurrentMember %>
					<tr><td colspan="3"><a href="$getGroupActionPageLink" class="addObject" title="Add a Group">add a Group</a></td></tr>
				<% end_if %>
				<% if getGroupInformation %>
					<% loop getGroupInformation %>
						<tr>
							<td class="branch_{$GroupBranch}">$GroupBranch</td>
							<td><a href="$getGroupDetailPageLink" title="Edit details for $GroupName">$GroupName</a></td>
							<td nowrap><% loop GroupZone %><a href="$getZoneLink" title="View details for $ZoneName">$ZoneName</a><% end_loop %></td>
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

<script>
	var map,marker,markers,latlng,contentString,infoWindow,bounds,boundsPoint,mapOptions,timeoutInt;
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
		<% loop getGroupMarkerArray %>
			setTimeout(function() {
				// creates new map point
				latlng = new google.maps.LatLng('{$Lat}', '{$Lng}');
				
				// creates new marker
				marker = new google.maps.Marker({
					position: latlng, 
					map: map, 
					animation: google.maps.Animation.DROP,
					title: '{$GroupName}'
				});
				switch('{$GroupBranch}') {
					case 'Air':
						marker.setIcon('../themes/simple/images/map_icons/paleblue_Marker.png');
					break;
					case 'Land':
						marker.setIcon('../themes/simple/images/map_icons/green_Marker.png');
					break;
					default:
						marker.setIcon('../themes/simple/images/map_icons/blue_Marker.png');
				}
				markers.push(marker);
				
				// need infowindows
				
				// updates map bounds
				bounds.extend(latlng);
				map.fitBounds(bounds);
			}, timeoutInt * 150);
			timeoutInt++;
		<% end_loop %>
		
	}

	google.maps.event.addDomListener(window, 'load', initialize);
</script>