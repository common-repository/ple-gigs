<?php
//-----------------------------------------------------------------------------
/*
Plugin Name: PostLists-Extension Gigs Calandar
Version: 1.0.1
Description: PostLists Extension for Gigs Calendar provides gigs calendar placeholders.
Author: Pascal Berger
*/
//-----------------------------------------------------------------------------
?>
<?php

//-----------------------------------------------------------------------------

// replace placeholders
function ple_gigs_placeholdervalue( $value, $name, $args, $posts, $post ) {
  if( !in_array($name,ple_gigs_placeholders(array(),$post,$args)) )
    return $value;

  // get globals
  global $wpdb;
  if( !$wpdb )
    return false;

  // query shedule
  $query  = "SELECT DISTINCT \n";
  $query .= "  G.date AS EventDate, \n";
  $query .= "  G.notes AS EventNotes, \n";
  $query .= "  G.eventName AS EventName, \n";
  $query .= "  V.name AS VenueName, \n";
  $query .= "  V.address AS VenueAddress, \n";
  $query .= "  V.city AS VenueCity, \n";
  $query .= "  V.state AS VenueState, \n";
  $query .= "  V.country AS VenueCountry, \n";
  $query .= "  V.postalCode AS VenuePostalCode, \n";
  $query .= "  V.contact AS VenueContact, \n";
  $query .= "  V.phone AS VenuePhone, \n";
  $query .= "  V.email AS VenueEmail, \n";
  $query .= "  V.link AS VenueLink, \n";
  $query .= "  V.notes AS VenueNotes, \n";
  $query .= "  V.customMap AS VenueCustomMap \n";
  $query .= "FROM \n";
  $query .= "  ".TABLE_GIGS." G \n";
  $query .= "  LEFT JOIN ".TABLE_VENUES." V ON G.venueID = V.id \n";
  $query .= "WHERE \n";
  $query .= "  G.postID=".$post->ID;

  $events = $wpdb->get_results( $query );
  if( !$events || count($events)<=0 )
    return null;

  // get placeholder value
  $value = array();
  foreach( $events as $event ) {
    switch( $name ) {
      case 'ple_gigs_eventdate':
        $value[] = mysql2date( get_option('date_format'), $event->EventDate );
      break;
      case 'ple_gigs_eventnotes':
        $value[] = $event->EventNotes;
      break;
      case 'ple_gigs_eventname':
        $value[] = $event->EventName;
      break;
      case 'ple_gigs_venuename':
        $value[] = $event->VenueName;
      break;
      case 'ple_gigs_venueaddress':
        $value[] = $event->VenueAddress;
      break;
      case 'ple_gigs_venuecity':
        $value[] = $event->VenueCity;
      break;
      case 'ple_gigs_venuestate':
        $value[] = $event->VenueState;
      break;
      case 'ple_gigs_venuecountry':
        $value[] = $event->VenueCountry;
      break;
      case 'ple_gigs_venuepostalcode':
        $value[] = $event->VenuePostalCode;
      break;
      case 'ple_gigs_venuecontact':
        $value[] = $event->VenueContact;
      break;
      case 'ple_gigs_venuephone':
        $value[] = $event->VenuePhone;
      break;
      case 'ple_gigs_venueemail':
        $value[] = $event->VenueEmail;
      break;
      case 'ple_gigs_venuelink':
        $value[] = $event->VenueLink;
      break;
      case 'ple_gigs_venuenotes':
        $value[] = $event->VenueNotes;
      break;
      case 'ple_gigs_venuecustommap':
        $value[] = $event->VenueCustomMap;
      break;
      default:
        $value[] = null;
      break;
    }
  }

  // get string of all values
  if( !empty($args['ple_gigs_separator']) )
    $value = implode( $args['ple_gigs_separator'], $value );
  else
    $value = $value[0];

  return $value;
}

// register placeholders
function ple_gigs_placeholders( $placeholders, $post, $args ) {

  // only post placeholders
  if( !$post )
    return $placeholders;

  // add placeholders
  $placeholders[] = 'ple_gigs_eventdate';
  $placeholders[] = 'ple_gigs_eventnotes';
  $placeholders[] = 'ple_gigs_eventname';
  $placeholders[] = 'ple_gigs_venuename';
  $placeholders[] = 'ple_gigs_venueaddress';
  $placeholders[] = 'ple_gigs_venuecity';
  $placeholders[] = 'ple_gigs_venuestate';
  $placeholders[] = 'ple_gigs_venuecountry';
  $placeholders[] = 'ple_gigs_venuepostalcode';
  $placeholders[] = 'ple_gigs_venuecontact';
  $placeholders[] = 'ple_gigs_venuephone';
  $placeholders[] = 'ple_gigs_venueemail';
  $placeholders[] = 'ple_gigs_venuelink';
  $placeholders[] = 'ple_gigs_venuenotes';
  $placeholders[] = 'ple_gigs_venuecustommap';

  return $placeholders;
}

// get placeholder description
function ple_gigs_placeholderdescription( $description, $placeholdername, $inpost ) {

  // only inpost placeholders
  if( !$inpost )
    return $description;

  // return description
  switch( $placeholdername ) {
    case 'ple_gigs_eventdate':
      return 'The date of the event';
    case 'ple_gigs_eventnotes':
      return 'Event descriptions';
    case 'ple_gigs_eventname':
      return 'Event name';
    case 'ple_gigs_venuename':
      return 'The name of the venue in which the event takes place';
    case 'ple_gigs_venueaddress':
      return 'The address of the venue in which the event takes place';
    case 'ple_gigs_venuecity':
      return 'The city in which the event takes place';
    case 'ple_gigs_venuestate':
      return 'The state in which the event takes place';
    case 'ple_gigs_venuecountry':
      return 'The country in which the event takes place';
    case 'ple_gigs_venuepostalcode':
      return 'The postal code of the city in which the event takes place';
    case 'ple_gigs_venuecontact':
      return 'The contact of the venue in which the event takes place';
    case 'ple_gigs_venuephone':
      return 'The phone number of the venue in which the event takes place';
    case 'ple_gigs_venueemail':
      return 'The email address of the venue in which the event takes place';
    case 'ple_gigs_venuelink':
      return 'The website of the venue in which the event takes place';
    case 'ple_gigs_venuenotes':
      return 'The remarks of the venue in which the event takes place';
    case 'ple_gigs_venuecustommap':
      return 'The coordinates of the venue in which the event takes place';
  }

  // keep
  return $description;
}

function ple_gigs_fields( $fields ) {

  // add admin field
  $fields['ple_gigs_separator'] = array(
    'description'=>'Separator for multiple Gigs Calendar gigs at one post',
    'type'=>'',
    'expert'=>true
  );

  // return fields
  return $fields;
}

//-----------------------------------------------------------------------------

// postlists filters
add_filter( 'ple_placeholders',           'ple_gigs_placeholders',           1, 3 );
add_filter( 'ple_placeholdervalue',       'ple_gigs_placeholdervalue',       1, 5 );
add_filter( 'ple_placeholderdescription', 'ple_gigs_placeholderdescription', 1, 3 );
add_filter( 'ple_fields',                 'ple_gigs_fields',                 0, 1 );

//-----------------------------------------------------------------------------

?>