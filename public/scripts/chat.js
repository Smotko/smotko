function hideLongChat(){
    var MAX_HEIGHT = 240;
    var SET_HEIGHT = 218;
    
    $('.comment_content').each(function(){
        if($(this).height() > MAX_HEIGHT){
           $(this).data('originalHeight', $(this).height());
           
           $(this).height(SET_HEIGHT);
           $(this).siblings('.comment_dots').show()           
        }
    });
    
    $('.chat').hover(function(){
        if($('.comment_content', this).height() < SET_HEIGHT)
            return;
        
        $('.comment_dots', this).animate( {opacity: 0}, {duration: 200, easing: 'swing', queue: false});
        $('.comment_content', this).animate( {height: $('.comment_content', this).data('originalHeight')}, {duration: 200, easing: 'swing', queue: false});
        $('.comment_dots', this).hide();
    }, function(){
        if($('.comment_content', this).height() > MAX_HEIGHT)
        {
            if($('.comment_content', this).data('persist'))
                return
            $('.comment_dots', this).show();
            $('.comment_content', this).animate( {height: SET_HEIGHT}, {duration: 200, easing: 'swing', queue: false});
            $('.comment_dots', this).animate( {opacity: 1}, {duration: 200, easing: 'swing', queue: false});
        }
    });
    
    $('.chat').click(function(){
        if($('.comment_content', this).data('persist')){
            $('.comment_content', this).data('persist', false);
            $(this).removeClass('pinned');
        }
        else{
            $('.comment_content', this).data('persist', true)
            $(this).addClass('pinned');
        }  
    });
    
}
$(document).ready(function(){
    hideLongChat();
});