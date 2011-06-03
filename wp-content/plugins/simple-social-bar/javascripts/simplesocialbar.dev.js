(function($){
    /**
     * SimpleSocialBar JavaScript Class
     * 
     * Assigns the window scroll event to adjust visibility and positioning of the
     * SimpleSocialBar widget.
     */
    var SimpleSocialBar = function(){
        // Object to house any jQuery extended elements used by this plugin
        var elems = {},
        
        // The namespace to work in for IDs and Classes
        ns = "simplesocialbar",
        
        // The offset of the horizontal anchor element
        offset = -1,
        
        // The base offset to base calculations off of = offset.top - buffer
        baseOffset = -1,
        
        // The threshold around the offset to start fading in the widget
        threshold = 20,
        
        // The buffer to use to determine when the fading in starts, how many pixels above the offset.top
        buffer = 40;
        
        // Assign events to elements for interaction
        function assignEvents(){
            // Assign scroll watcher to determine visibility of SimpleSocialBar widget
            elems.window.bind('scroll.' + ns, function(){
                rePosition();
            });
        }
        
        // Initiate the Class, gather elements, assign events, etc.
        function initialize(){
            elems.horizontal = $('.' + ns + '-horizontal');
            elems.vertical = $('.' + ns + '-vertical');
            elems.window = $(window);
            
            offset = elems.horizontal.offset();
            
            baseOffset = offset.top - buffer;
            
            // Only enable the vertical ShareBar if this is a single post page and not a listing
            if(elems.horizontal.length == 1){
                var verticalLeftOffset = (0 - elems.window.width()/2) + offset.left - elems.vertical.width() - 40;
                if(elems.vertical.hasClass(ns + '-right')){
                    verticalLeftOffset = (offset.left + elems.horizontal.width()) - elems.window.width()/2 + 40;
                }
                
                // Position the vertical ShareBar horizontally
                elems.vertical.css({
                    left: '50%',
                    marginLeft: verticalLeftOffset
                });
                
                // Position the vertical ShareBar vertically
                rePosition();
                
                // Determine initial visibility based off scroll offset
                if(elems.window.scrollTop() > baseOffset + threshold){
                    elems.vertical.fadeIn(500);
                } else {
                    elems.vertical.css({
                        opacity: 0
                    });
                }
                
                assignEvents();
            }
        }
        
        // Change the opacity based off the position of the page's scroll and the offset values
        function rePosition(){
            var newOpacity = 0;
            var windowScrollY = elems.window.scrollTop();
            var currentOpacity = parseFloat(elems.vertical.css('opacity'));
            
            // Redefine opacity if it has scrolled down far enough
            if(windowScrollY > baseOffset - threshold){
                // Define as 100% opacity if scrolled past the threshold
                if(windowScrollY > baseOffset + threshold){
                    newOpacity = 1;
                    
                    // If the opacity is already 100%, just return false, no need to reapply CSS property
                    if(currentOpacity === 1){
                        return false;
                    }
                } else {
                    // Define opacity on a gradient scale if it is between the threshold values
                    if(windowScrollY < baseOffset){
                        newOpacity = (1 - ((baseOffset - windowScrollY) / threshold)) / 2;
                    } else {
                        newOpacity = (0.5 + ((windowScrollY - baseOffset) / threshold)) / 2;
                    }
                }
            } else {
                // If the opacity is already at 0%, just return false, no need to reapply CSS property
                if(currentOpacity === 0){
                    return false;
                }
            }
            
            var cssProperties = {
                opacity: newOpacity
            };
            
            if(newOpacity === 0){
                cssProperties.display = "none";
            } else {
                cssProperties.display = "block";
            }
            
            elems.vertical.css(cssProperties);
        }
        
        initialize();
    };
    
    $(document).ready(function(){
        new SimpleSocialBar();
    });
})(jQuery);
