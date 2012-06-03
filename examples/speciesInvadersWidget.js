var species_invaders_api = 'http://silentrunning.info/si/api/';
var map = null;
var polygons = new Array(0);
var markers = new Array(0);
var infoWindows = new Array(0);

$(document).ready(function () {
	// load google maps
	var script = document.createElement("script");
	script.type = "text/javascript";
	script.src = "http://maps.googleapis.com/maps/api/js?key=&sensor=true&callback=google_maps_init";
	$(document).append(script);
	
	// handle clicks on the species pop-up
	$('#species').bind('click update', select_special);
});

function google_maps_init() {
	// set up google maps
	var myOptions = {
		center: new google.maps.LatLng(44.0, -73.0),
		zoom: 8,
		mapTypeId: google.maps.MapTypeId.HYBRID
	};
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	
	show_all_species(true);
}

function show_all_species(addToSelect) {
	// get all species
	$.ajax({
		url: species_invaders_api + 'species',
		success: function(data) {
			// get each species and add its locations to the map
			for ( index in data ) {
				show_species(data[index], addToSelect);
			}
		}
	});
}

function show_species(id, addToSelect) {
	$.ajax({
		url: species_invaders_api + 'species/id/' + id,
		success: function(speciesData) {
			console.log('species: ' + speciesData.species);
			// add the species to the select pop-up?
			if ( addToSelect === true ) {
				$('#species').append($(document.createElement("option")).attr("value",speciesData.speciesid).text(speciesData.species));
			}
			
			/*
			for ( index in speciesData.commonNames ) {
				console.log(speciesData.commonNames[index].name);
			}
			*/
			
			// get the native locations
			$.ajax({
				url: species_invaders_api + 'species/native_locations/' + speciesData.speciesid,
				success: function (nativeLocationsData) {
					console.log('native locations: ' + nativeLocationsData);
					// step through the native locations
					for ( index in nativeLocationsData )
					{
						// get the native locations polygons
						$.ajax({
							url: species_invaders_api + 'locations/id/' + nativeLocationsData[index],
							success: function (locationData) {
								map_location(speciesData, locationData, false);
							}
						});
					}
				}
			});
			
			// get the invading locations
			$.ajax({
				url: species_invaders_api + 'species/invading_locations/' + speciesData.speciesid,
				success: function (invadingLocationsData) {
					console.log('invading locations: ' + invadingLocationsData);
					// step through the invading locations
					for ( index in invadingLocationsData )
					{
						// get the invading locations polygons
						$.ajax({
							url: species_invaders_api + 'locations/id/' + invadingLocationsData[index],
							success: function (locationData) {
								map_location(speciesData, locationData, true);
							}
						});
					}
				}
			});
		}
	});
}

function map_location(species, location, isInvasive) {
	// style invasive differently
	if ( isInvasive === true ) {
		strokeColor = '#FF0000';
		fillColor = '#FF0000';
	} else {
		strokeColor = '#00FF00';
		fillColor = '#00FF00';
	}
	
	// build the polygon
	var polygonPoints = new Array(0);
	for ( index in location.polygon ) {
		polygonPoints.push(new google.maps.LatLng(location.polygon[index][1], location.polygon[index][0]));
	}
	var polygon = new google.maps.Polygon({
		paths: polygonPoints,
		strokeColor: strokeColor,
		strokeOpacity: 0.8,
		strokeWeight: 2,
		fillColor: fillColor,
		fillOpacity: 0.35
	});
	polygons.push(polygon);
	
	// add it to the map
	polygon.setMap(map);
	
	// find the center of the polygon & put the species label there
	var bounds = new google.maps.LatLngBounds();
	for (index in polygonPoints) {
		bounds.extend(polygonPoints[index]);
	}
	//console.log(bounds.getCenter);
	var marker = new google.maps.Marker({
      position: bounds.getCenter(),
      map: map,
      title: species.species
	});
	markers.push(marker);
	
	// fill in the info window
	var contentString = '<h3>' + species.species + ' ' + species.family + '</h2>';
	contentString += '<h4>Common Names</h3><p>';
	for ( index in species.commonNames ) {
		contentString += species.commonNames[index].name;
		if ( ( species.commonNames.length > 1 ) && ( index < species.commonNames.length - 1 ) ) {
			contentString += ', ';
		}
	}
	contentString += '</p>';
	var info = new google.maps.InfoWindow({content: contentString});
	infoWindows.push(info);
	
	google.maps.event.addListener(marker, 'click', function() {
		console.log('marker: ', marker);
		console.log('info: ', info);
		info.open(map, marker);
	});
}

function select_special() {
	clear_map();
	species = $('#species option:selected').val();
	if ( species === 'ALL' ) {
		show_all_species(false);
	} else {
		show_species(species, false);
	}
}

function clear_map() {
	// clear all info windows
	for (index in infoWindows) {
		//infoWindows[index].setMap(null);
	}
	infoWindows = new Array(0);
	// clear all the markers
	for (index in markers) {
		markers[index].setMap(null);
	}
	markers = new Array(0);
	// clear all polygons
	for (index in polygons) {
		polygons[index].setMap(null);
	}
	polygons = new Array(0);
}
