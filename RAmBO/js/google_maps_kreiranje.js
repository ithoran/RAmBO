            var gmapsLat;
            var gmapsLng;
            var drawingManager;

            function deleteSelectedShape () {
                gmapsLat = null;
                gmapsLng = null;
                initialize();
            }

            function initialize () {
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 8,
                    center: new google.maps.LatLng(44.10943599214824, 20.723862648010254),
                    mapTypeId: google.maps.MapTypeId.roadmap,
                    disableDefaultUI: true,
                    zoomControl: true,
					maxZoom: 16,
					minZoom: 8
                });

                drawingManager = new google.maps.drawing.DrawingManager({
                    markerOptions: {
                        draggable: true
                    },
                    drawingControlOptions: {
                    drawingModes: [
                    google.maps.drawing.OverlayType.MARKER
                    ]},
                    map: map
                });

                var marker = google.maps.event.addListener(drawingManager, 'overlaycomplete', function (e) {
                    var newShape = e.overlay;
                    
                    newShape.type = e.type;
                    
                    gmapsLat = newShape.position.lat();
                    gmapsLng = newShape.position.lng();
                    
                    drawingManager.setDrawingMode(null);
                    // To hide:
                    drawingManager.setOptions({
                    drawingControl: false
                    });
                    
                    google.maps.event.addListener(newShape, 'dragend', function (e) {
                        gmapsLat = e.latLng.lat();
                        gmapsLng = e.latLng.lng();
                    });
                });
                
                google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);
            }
            google.maps.event.addDomListener(window, 'load', initialize);

