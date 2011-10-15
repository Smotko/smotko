$(document).ready(function(){
    
	//Hide PNP form:
	if($('.pnp_content').length > 0){
		$('#pnp-form').hide();
		$('#submit_pnp').parent().append('<div id="cancel">Prekliči</div>');
		$('#cancel').click(function(){
			$('#pnp-form').slideUp('medium', function(){
				$('#add-pnp').show();
				
			});
		});
		$('#add-pnp').click(function(event){
			event.preventDefault();
			$('#add-pnp').hide();
			$('#pnp-form').slideDown();
		});
	}
	else{
		$('#add-pnp').hide();
	}
	var POLL_INTERVAL = 100;
    var UPDATE_CHAT_INTERVAL = 60000;
    
    //Ajaxy debate paging:
    var curr_url = window.location + "";
    function debatePaging(old, noShit){
        $('.debate_content').animate({"opacity": "0.25"});
        
        var link = old.replace("/index/index/", "/api/debate/");
        $.get(link, {}, function(data){
            if(!noShit){
                if (typeof(window.history.pushState) == 'function') {
                    window.history.pushState(null, link, old);
                } else {
                    window.location.hash = '#' + old;
                }
            }
            curr_url = window.location + "";
            $('.debate_content').html(data);
            $('.debate_content').animate({"opacity": "1"});
            hideLongChat();
            $('.chat:nth-child(even)').addClass('emphasize');
            //$('.debate_content').fadeIn();
        });
    }
    $('.newer a,.older a').live('click', function(e){
            e.preventDefault();
            debatePaging($(this).attr('href'), false);
    });
    var first_load = true;
    function parseHash(){
        
        var hash = window.location.hash;
        if(hash != ""){
            
            debatePaging(hash.substring(1, hash.length), true);
        }
        else{
            if(first_load){
                first_load = false;
                return;
            }
            var get = curr_url.substring(curr_url.indexOf('/', 7), curr_url.length);
            if(get == "/")
                get = "/index/index/stran/1";
            
                debatePaging(get, true);
        }
        
    }
    parseHash();
    
    function poll(){
        //console.log(curr_url + " " + window.location);
        if(curr_url != window.location){
            curr_url = window.location + "";
            parseHash();
            
            
        }
        //alert(window.location);
    }
    setInterval(poll, POLL_INTERVAL);
    var lastDebate;
    var firstDebate;
    function newDebate(){
        $.getJSON('/api/debatehighest', function(data){
           if(lastDebate == undefined){
               lastDebate = data.num;
               firstDebate = data.num;
               return;
           }
           if(lastDebate != data.num){
               if(/\(\d\)/.test(document.title)){

                   document.title = (document.title).split(" ", 2)[1];
               }
               
               document.title = "(" + (data.num - firstDebate) + ") " + document.title;
               lastDebate = data.num;
               $("#new_debate").show();
               return;
           }
        });
    }
    $("#new_debate").click(function(){
        $(this).hide();
        document.title = (document.title).split(" ", 2)[1];
        firstDebate = lastDebate;
        parseHash();
        
        
    });
    newDebate();
    setInterval(newDebate, UPDATE_CHAT_INTERVAL);
});