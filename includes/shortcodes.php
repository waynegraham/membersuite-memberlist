<?php

function membersuite_list($atts)
{
    $a = shortcode_atts(
        array(
        'membership_type' => $atts['membership_type'],
        'class' => 'col-md-4',
        'id' => 'membersuite-list'
      ),
        $atts
    );
    global $wpdb;

    $numOfCols = 4;
    $rowCount = 0;
    $bootstrapColWidth = 12 / $numOfCols;

    // TODO: use prepared statement
    $members = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}membersuite-memberlist` WHERE membership_type LIKE '%{$a['membership_type']}%' ORDER BY name", ARRAY_A);

    $output = "<h1>Member List</h1>";
    $output .='<div class="row">';

    foreach ($members as $member) {
        $output .= "<div class=\"col-md-4\">{$member['name']}</div>";
    }

    $output .= '</div>';

    return $output;
}

function membersuite_map($atts)
{
    global $wpdb;
    $a = shortcode_atts(
        array(
        'membership_type' => $atts['membership_type'],
      'id' => 'membersuite-list'
    ),
        $atts
  );
    // $members = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}membersuite-memberlist` WHERE membership_type = {$a['membership_type']})", ARRAY_A);
}

function register_shortcodes()
{
    add_shortcode('membersuite_list', 'membersuite_list');
    add_shortcode('membersuite_map', 'membersuite_map');
}

add_action('init', 'register_shortcodes');
