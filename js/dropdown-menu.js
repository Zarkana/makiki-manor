$(document).ready(function(){
    if(screen.width < 960){
        $(".primary-link").css({
            'pointer-events': 'none',
        });        
    }

    $(".dropdown.accent.left").hoverIntent(function(){
        $(this).find("a").addClass('header-hover');
        $(this).find("a").addClass('header-hover');
        $("#about.dropdown-list").animate({
            height: 'show',
        }, 400);
    }, function(){
        $("#about.dropdown-list").animate({
            height: 'hide',
        }, 550, function(){
        	$("#about.dropdown-list").clearQueue();
        });
        $(this).find("a").removeClass('header-hover');
    });
/*        $( "#effect" ).animate({
          backgroundColor: "#aa0000",
          color: "#fff",
          width: 500
        }, 1000 );  */  

    $(".dropdown.accent.middle").hoverIntent(function(){
        $(this).find("a").addClass('header-hover');
        $("#residents.dropdown-list").animate({
            height: 'show',
        }, 400);
    }, function(){
        $("#residents.dropdown-list").animate({
            height: 'hide',
        }, 550, function(){
        	$("#residents.dropdown-list").clearQueue();
        });
        $(this).find("a").removeClass('header-hover');
    }); 

    $(".dropdown.accent.right").hoverIntent(function(){
        $(this).find("a").addClass('header-hover');
        $("#contact.dropdown-list").animate({
            height: 'show',
        }, 350);
    }, function(){
        $("#contact.dropdown-list").animate({
            height: 'hide',
        }, 500, function(){
        	$("#contact.dropdown-list").clearQueue();
        });
        $(this).find("a").removeClass('header-hover');
    }); 

});