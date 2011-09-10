$(document).ready(function(){
    //Flash msg hide function:
    $('.hide_msg').click(function(){
        $(this).parent().parent().hide();
    });
    
//    var bg = Math.random()*10000;
//    $('.header_bg').css({backgroundPosition: bg + 'px 0px'});
//    moveHeader = function(){
//    	var newbg;
//    	if (Math.random() < 0.5){
//    		newbg = bg - Math.floor(Math.random()*100) - 50;
//    	}
//    	else{
//    		newbg = bg + Math.floor(Math.random()*100) + 50;
//    	}
//    	$('.header_bg').css({backgroundPosition: bg + 'px 0px'}).animate({backgroundPositionX: newbg+'px'}, 'slow', 'swing');
//    	bg = newbg;
//    	setTimeout(moveHeader, Math.random()*10000+2000)
//    };
//    setTimeout(moveHeader, Math.random()*10000+2000);

    $('.navigation').append('<li class="paddless"><g:plusone size="small" count="false"></g:plusone></li>')
    
    $('.chat:nth-child(even)').addClass('emphasize');

    $.movableShadow($(".site_title"), 'black', 'text-shadow');
    $.movableShadow($("#menu li a").not('.active'), 'black', 'text-shadow');


    
});
