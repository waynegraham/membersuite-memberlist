<?php

function membersuite_list($atts)
{
    // normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    $a = shortcode_atts(
        array(
        // 'membership_type' => $atts['membership_type'],
        'columns' => 3,
        'id' => 'membersuite-list'
      ),
        $atts
    );
    global $wpdb;

    $numOfCols = $a['columns'];
    $bootstrapColWidth = 12 / $numOfCols;
    $bootstrapClass = "col-md-{$bootstrapColWidth}";

    $query = $wpdb->prepare("SELECT name FROM `{$wpdb->prefix}membersuite-memberlist` WHERE membership_type LIKE '%s' ORDER BY name", "%{$a['membership_type']}%");
    $members = $wpdb->get_results($query, ARRAY_A);
    $count = sizeof($members);
    $output = '<div class="container">';
    $output .= '<div class="row">';

    // $output .= "<h2>count: {$count}</h2><br />";

    foreach ($members as $member) {
        $output .= "<div class=\"{$bootstrapClass}\">{$member['name']}</div>";
    }

    $output .= '</div>';
    $output .= '</div>';

    return $output;
}

function membersuite_map($atts)
{
    // normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    $a = shortcode_atts(
        array(
      'membership_type' => $atts['membership_type'],
      'height' => '360px',
      'id' => 'membersuite-list'
    ),
        $atts
  );
    global $wpdb;

    $query = $wpdb->prepare("SELECT name, latitude, longitude FROM `{$wpdb->prefix}membersuite-memberlist` WHERE membership_type LIKE '%s' ORDER BY name", "%{$a['membership_type']}%");
    $members = $wpdb->get_results($query, ARRAY_A);
    $output = "<style>#membersuite-membermap{ height: {$a['height']};}</style>";
    $output .= '<div id="membersuite-membermap"></div>';

    $output .= '<script>';
    $output .= "var membershipMap = L.map('membersuite-membermap').setView([38.89511, -77.03637], 13);
    	var accessToken = 'pk.eyJ1Ijoid3NnNHciLCJhIjoiTVd4cXdScyJ9.ypK9cLCVFReavCn9b_hhWQ';

    	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    		attribution: 'Map data &copy; <a href=\"https://www.openstreetmap.org/\">OpenStreetMap</a> contributors, <a href=\"https://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, Imagery © <a href=\"https://www.mapbox.com/\">Mapbox</a>',
    		maxZoom: 2,
    		id: 'mapbox.streets',
    		accessToken: accessToken
    	}).addTo(membershipMap);";

    foreach ($members as $member) {
        $output .= "\nL.marker([{$member['longitude']}, {$member['latitude']}]).addTo(membershipMap).bindPopup('<h3>{$member['name']}</h3>');";
    }

    $output .= '</script>';

    return $output;
}

function register_shortcodes()
{
    add_shortcode('membersuite_list', 'membersuite_list');
    add_shortcode('membersuite_map', 'membersuite_map');
}

add_action('init', 'register_shortcodes');
