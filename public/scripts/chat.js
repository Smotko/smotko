function hideLongChat(){
    var MAX_HEIGHT = 120;
    var SET_HEIGHT = 92;
    
    $('.comment_content').each(function(){
        if($(this).height() > MAX_HEIGHT){
           $(this).height(SET_HEIGHT);
           $(this).siblings('.comment_dots').show()           
        }
    });
    
    $('.chat').hover(function(){
    if($('.comment_content', this).height() < SET_HEIGHT)
        return;
    $('.comment_content', this).height('auto');
    $('.comment_dots', this).hide();

    }, function(){
        if($('.comment_content', this).height() > MAX_HEIGHT)
        {
            $('.comment_content', this).height(SET_HEIGHT);
            $('.comment_dots', this).show();
        }
    });
}
$(document).ready(function(){
    hideLongChat();
});