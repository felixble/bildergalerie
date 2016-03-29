/**
 * Created by felix on 29.03.16.
 */

$(document).ready(function() {
    if( ! $('#myCanvas').tagcanvas({
            textColour : '#000000',
            reverse: true,
            fadeIn: 1000,
            outlineThickness : 1,
            maxSpeed : 0.03,
            depth : 0.75,
            initial:  [0.08,-0.03],
            minSpeed: 0.005,
            maxSpeed: 0.03,
            shuffleTags: true,
            imageMode: 'text'
        }, 'tags')) {
        // TagCanvas failed to load
        alert("nope");
        $('#myCanvasContainer').hide();
    }
    // your other jQuery stuff here...
});