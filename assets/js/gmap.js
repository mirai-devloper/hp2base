(function($) {
  function render_map( $el ) {
    var $markers = $el.find('.marker');
    var zooms = $markers.attr('data-zoom');
    var drag = isMobile() ? false : true;

    var args = {
      zoom    : Number(zooms),
      center    : new google.maps.LatLng(0, 0),
      mapTypeId : google.maps.MapTypeId.ROADMAP,
      scrollwheel: false,
      draggable: drag
    };
    var map = new google.maps.Map( $el[0], args);
    map.markers = [];
    $markers.each(function(){
        add_marker( $(this), map );
    });
    // center map
    center_map( map, zooms );
  }

  function add_marker( $marker, map ) {
    var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
    var marker = new google.maps.Marker({
      position  : latlng,
      map     : map
    });
    // add to array
    map.markers.push( marker );
    // if marker contains HTML, add it to an infoWindow
    if( $marker.html() )
    {
      // create info window
      var infowindow = new google.maps.InfoWindow({
        content   : $marker.html()
      });
      // show info window when marker is clicked
      google.maps.event.addListener(marker, 'click', function() {
        infowindow.open( map, marker );
      });
    }
  }

  function center_map( map, zooms ) {
    var bounds = new google.maps.LatLngBounds();
    $.each( map.markers, function( i, marker ){
      var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
      bounds.extend( latlng );
    });
    if( map.markers.length == 1 ) {
        map.setCenter( bounds.getCenter() );
        map.setZoom( Number(zooms) );
    } else {
      map.fitBounds( bounds );
    }
	}

	var map = null;
  $(document).ready(function(){
    $('.acf-map').each(function(){
      map = render_map( $(this) );
    });
    // console.log(zoom_map($('.acf-map').find('.marker')));
  });
})(jQuery);
