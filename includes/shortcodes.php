<?php

function membersuite_list( $atts ) {
	// normalize attribute keys, lowercase
	$atts = array_change_key_case( (array) $atts, CASE_LOWER );
	$a    = shortcode_atts(
		array(
			'membership_type' => '*',
			'columns'         => 3,
			'id'              => 'membersuite-list',
		),
		$atts
	);
	global $wpdb;

	// TODO: move to JS, passing the query array

	$numOfCols         = $a['columns'];
	$bootstrapColWidth = 12 / $numOfCols;
	$bootstrapClass    = "col-md-{$bootstrapColWidth}";

	$query   = $wpdb->prepare( "SELECT name FROM `{$wpdb->prefix}membersuite-memberlist` WHERE membership_type LIKE '%s' ORDER BY name", "%{$a['membership_type']}%" );
	$members = $wpdb->get_results( $query, ARRAY_A );
	$count   = sizeof( $members );
	$output  = '<div class="container">';
	$output .= '<div class="row">';

	// $output .= "<h2>count: {$count}</h2><br />";

	foreach ( $members as $member ) {
		$output .= "<div class=\"{$bootstrapClass}\">{$member['name']}</div>";
	}

	$output .= '</div>';
	$output .= '</div>';

	return $output;
}

function membersuite_map( $atts ) {
	// normalize attribute keys, lowercase
	$atts = array_change_key_case( (array) $atts, CASE_LOWER );
	$a    = shortcode_atts(
		array(
			'membership_type' => null,
			'height'          => '416px',
			'width'           => '616px',
			'id'              => 'membersuite-list',
		),
		$atts
	);
	global $wpdb;

	$options    = get_option( 'membersuite_memberlist_option_name', array() );
	$mapbox_key = $options['mapbox_api_key'];

	$query   = $wpdb->prepare( "SELECT name, latitude, longitude FROM `{$wpdb->prefix}membersuite-memberlist` WHERE membership_type LIKE '%s' ORDER BY name", "%{$a['membership_type']}%" );
	$members = $wpdb->get_results( $query, ARRAY_A );
	$output  = "<style>#{$a['id']}{ width: {$a['width']}; height: {$a['height']};}</style>";
	$output .= "<div id=\"{$a['id']}\"></div>";

	$output .= '<script>';
	$output .= "
      var markerArray = [];
      var members = L.featureGroup();

      var mbAttr = 'Map data &copy; <a href=\"https://www.openstreetmap.org/\">OpenStreetMap</a> contributors, <a href=\"https://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, Imagery © <a href=\"https://www.mapbox.com/\">Mapbox</a>',
        mbUrl = \"https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={$mapbox_key}\";

      // see https://stackoverflow.com/questions/37166172/mapbox-tiles-and-leafletjs
      var grayscale   = L.tileLayer(mbUrl, {id: 'mapbox.light', attribution: mbAttr}),
  		streets  = L.tileLayer(mbUrl, {id: 'mapbox.streets', attribution: mbAttr}),
      wheatpaste = L.tileLayer(mbUrl, {id: 'mapbox.wheatpaste', attribution: mbAttr}),
      comic  = L.tileLayer(mbUrl, {id: 'mapbox.comic', attribution: mbAttr}),
      pirates  = L.tileLayer(mbUrl, {id: 'mapbox.pirates', attribution: mbAttr}),
      emerald  = L.tileLayer(mbUrl, {id: 'mapbox.emerald', attribution: mbAttr}),
      emerald  = L.tileLayer(mbUrl, {id: 'mapbox.emerald', attribution: mbAttr}),
      pencil  = L.tileLayer(mbUrl, {id: 'mapbox.pencil', attribution: mbAttr});

        var membershipMap = L.map('{$a['id']}',{
          center: [38.89511, -77.03637],
          zoom: 13,
          layers: [grayscale, members]
        });

        var baseLayers = {
          \"Grayscale\": grayscale,
          \"Streets\": streets,
          \"Wheatpaste\": wheatpaste,
        };

        var overlays = {
          \"Members\": members,
        }

        L.control.layers(baseLayers, overlays).addTo(membershipMap);
  ";

	foreach ( $members as $member ) {
		// $output .= "\nL.marker([{$member['latitude']}, {$member['longitude']}]).addTo(members).bindPopup('<h3>{$member['name']}</h3>');";
		$output .= "\nL.marker([{$member['latitude']}, {$member['longitude']}]).addTo(members);";
	}

	$output .= '
    membershipMap.fitBounds(members.getBounds());
    </script>';

	return $output;
}

function membersuite_register_shortcodes() {
	add_shortcode( 'membersuite_list', 'membersuite_list' );
	add_shortcode( 'membersuite_map', 'membersuite_map' );
}

add_action( 'init', 'membersuite_register_shortcodes' );
