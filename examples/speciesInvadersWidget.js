var species_invaders_api = 'http://silentrunning.info/si/api/';
var map = null;

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
	
	show_all_species();
}

function show_all_species() {
	// get all species
	$.ajax({
		url: species_invaders_api + 'species',
		success: function(data) {
			// get each species and add its locations to the map
			for ( index in data ) {
				show_species(data[index], true);
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
				url: species_invaders_api + 'species/native_location/' + speciesData.speciesid,
				success: function (nativeLocationsData) {
					console.log('native locations: ' + nativeLocationsData);
					// step through the native locations
					for ( index in nativeLocationsData )
					{
						// get the native locations polygons
						$.aja({
							url: species_invaders_api + 'locations/id/' + nativeLocationsData[index],
							success: function (locationData) {
								console.log('location: ' + locationData)
							}
						});
					}
				}
			});
			
			// get the invading locations
			$.ajax({
				url: species_invaders_api + 'species/invading_location/' + speciesData.speciesid,
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
	polygon = new google.maps.Polygon({
		paths: polygonPoints,
		strokeColor: strokeColor,
		strokeOpacity: 0.8,
		strokeWeight: 2,
		fillColor: fillColor,
		fillOpacity: 0.35
	});
	
	// add it to the map
	polygon.setMap(map);
	
	// find the center of the polygon & put the species label there
	var bounds = new google.maps.LatLngBounds();
	for (index in polygonPoints) {
		bounds.extend(polygonPoints[index]);
	}
	console.log(bounds.getCenter);
	var marker = new google.maps.Marker({
      position: bounds.getCenter(),
      map: map,
      title: species.species
  });
}

function select_special() {
	show_species($('#species option:selected').val(), false);
}