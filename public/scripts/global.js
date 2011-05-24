$(document).ready(function(){
    //Flash msg hide function:
    $('.hide_msg').click(function(){
        $(this).parent().parent().hide();
    });
    $('.header_bg');
    var bg = 0;
    moveHeader = function(){
    	var newbg;
    	if (Math.random() < 0.5){
    		newbg = bg - Math.floor(Math.random()*100) - 50;
    	}
    	else{
    		newbg = bg + Math.floor(Math.random()*100) + 50;
    	}
    	$('.header_bg').css({backgroundPosition: bg + 'px 0px'}).animate({backgroundPosition: newbg+'px +0px'}, 'slow', 'swing');
    	bg = newbg;
    	setTimeout(moveHeader, Math.random()*10000+2000)
    };
    setTimeout(moveHeader, Math.random()*10000+2000);
    
    
});