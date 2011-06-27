(function($){

    $.movableShadow = function(element, color, shadow){
        
        $(document).mousemove(function(e){
            
           var middle = function(el){
                var m = new Object();
                m.top = el.offset().top + el.height()/2;
                m.left = el.offset().left +  el.width()/2;	 
                return m 
            };
            var normalize = function(diff){
                var LIMIT = 3;
                var d = -diff/200;
                if (d > LIMIT) d = LIMIT;
                if (d < -LIMIT) d = -LIMIT;
                return d;			
            };

            var p = middle(element);
            var diff = new Object();
            diff.top = e.pageY - p.top;
            diff.left = e.pageX - p.left;	

            element.css(shadow, normalize(diff.left) + "px " + normalize(diff.top) +"px 2px "  + color);
        }); 
    };
    
})(jQuery);

