/**
 * Created by felix on 29.03.16.
 */

$(document).ready(function() {
    if( ! $('#myCanvas').tagcanvas({
            textColour : '#31708f',
            outlineColour: '#d9edf7',
            reverse: true,
            fadeIn: 1000,
            outlineThickness : 1,
            depth : 0.75,
            zoomMax: 1.6,
            zoomMin: 0.8,
            initial:  [0.08,-0.03],
            minSpeed: 0.005,
            maxSpeed: 0.03,
            shuffleTags: true,
            imageMode: 'text',
            weight: true,
            weightFrom: "data-weight",
            weightSizeMax: 30,
            weightSizeMin: 10
        }, 'tags')) {
        // TagCanvas failed to load
        $('#myCanvasContainer').hide();
        $('#tags').show();
    }
    // your other jQuery stuff here...
});