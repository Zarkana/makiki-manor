$(document).ready(function(){
    $("#announcement-tab").addClass('shadow-right');           
    $("#calendar-tab").removeClass('shadow-left');     

    $("#calendar-tab").addClass('above');
    $("#announcement-tab").removeClass('above');    
    
    $("#announcement-tab").click(function(){
        $("#announcements").show(450, function(){
            allocateEditButtons();
        });                
        $("#calendar").hide(450, function(){
            allocateEditButtons();
        });                   
            
        $(this).addClass('shadow-right');   
        $("#calendar-tab").removeClass('shadow-left');     

        $("#calendar-tab").addClass('above');
        $(this).removeClass('above');
    });
    $("#calendar-tab").click(function(){
        $("#calendar").show(450, function(){
            allocateEditButtons();
        });                
        $("#announcements").hide(450, function(){
            allocateEditButtons();
        });                


        $(this).addClass('shadow-left');        
        $("#announcement-tab").removeClass('shadow-right');

        $(this).removeClass('above');
        $("#announcement-tab").addClass('above');        
    });    

/*
    $(".dropdown.accent.middle").hoverIntent(function(){
        $("#residents.dropdown-list").animate({
            height: 'show',
        }, 450);
    }, function(){
        $("#residents.dropdown-list").animate({
            height: 'hide',
        }, 700, function(){
        	$("#residents.dropdown-list").clearQueue();
        });
    }); 
*/
});