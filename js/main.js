//Resizes header when scrolling down
function init() {
	window.addEventListener('scroll', function(e) {
		allocateEditButtons();
		var distanceY = window.pageYOffset || document.documentElement.scrollTop;    
    var shrinkOn = 190;
    if(window.innerWidth < 800){
      shrinkOn = 80;
    }
    
    var header = document.querySelector("#header-inner");
		if (distanceY > shrinkOn) {
			$("#header-inner").addClass('smaller');
		} else {
			if ($("#header-inner").hasClass('smaller')){
				$("#header-inner").removeClass('smaller');
			}
		}
	}, function(){
        allocateEditButtons();
    });
}
window.onload = init();
$(document).ready(function(){

  //Sorts table columns  
	$('table').each(function(){
		var table = $(this);
		$('.sort-button').wrapInner('<span title="sort this column"/>').each(function(){
      var th = $(this),
      thIndex = th.index(),
      inverse = false;
    
      th.click(function(){
        
        table.find('td').filter(function(){            
          return $(this).index() === thIndex;              
        }).sortElements(function(a, b){
          
          return $.text([a]) > $.text([b]) ?
            inverse ? -1 : 1
            : inverse ? 1 : -1;
            
        }, function(){
          //parentNode is the element we want to move
          return this.parentNode;
        });
        inverse = !inverse;
      });
    });
  });

  //Handles the display of control panel tab main user non-active notifications
	if($(".non-active").text() != "0"){
		$(".non-active").css("display", "block");
	}

  //Handles the color of table rows based upon users active status
	$('.active').each(function(){
		if($(this).text() == "false"){
			var parent = $(this).parent("tr");
			parent.css("background-color","#F9EFEF");
			parent.hover(function(){
				$(this).css("background-color","#F9E9E9");
			}, function(){
				$(this).css("background-color","#F9EFEF");
			});
			$(this).css("font-weight","bold");	
		}
	});

  //Scroll user to tabs section
  $(".tabs").click(function(){
    //Keeps from locking user into animation
    $('html, body').on("scroll mousedown wheel DOMMouseScroll mousewheel keyup touchmove", function(){
      $(this).stop();
    });
    	$('html, body').animate({
      	scrollTop: $(".tabs").offset().top + 32- ($(".tabs").outerHeight() + $(".control-panel:visible").outerHeight() + $(".banner").outerHeight() + 6)
  	}, 1500);
  });

  $(".about-section").click(function(){
    var target = $('html, body').animate();
  });

	$('#published-select select').change(function(){
	  //do stuff here, eg.
	  if ($(this).val() == 'false') { //check the selected option etc.
      $("#email-select select").attr("disabled", true);
      $("#email-select").hide(200);
	  }else if($(this).val() == 'true'){
      $("#email-select select").attr("disabled", false);
      $("#email-select").show(200);
	  }
	});

	//TODO: Pretty messy
	//Changes form to login
	$("#attempt-login, #reattempt-login").off('click').on('click', function(){
		var hide_string;
		//Will create weird jittery effect if try to fadeout an already hidden element
		if($(".error").length && $(".error:visible").length){
			if($("#create-account-form").length && $("#create-account-form:visible").length){
				hide_string = "#create-account-form, .error";
			} else {
				hide_string = "#request-reset-form, .error";
			}
		}else{
			if($("#create-account-form").length && $("#create-account-form:visible").length){
				hide_string = "#create-account-form";
			} else {
				hide_string = "#request-reset-form";
			}
		}	

		$(hide_string).fadeOut(400, function(){
			$("#login-residents-form, #login-admin-form").fadeIn(500, function(){
			});
		});
	});

	//Changes form to reset password form
	$("#forgot-password").off('click').on('click', function(){
		var hide_string;
		if($(".error").length && $(".error:visible").length){
			hide_string = "#login-residents-form, #login-admin-form, .error";
		}else{
			hide_string = "#login-residents-form, #login-admin-form";
		}
		$(hide_string).fadeOut(400, function(){
				$("#request-reset-form").fadeIn(500, function(){
			});
		});
	});

	//Changes form to create account
	$("#create-account").off('click').on('click', function(){
		var hide_string;
		if($(".error").length && $(".error:visible").length){
			hide_string = "#login-residents-form, #login-admin-form, .error";
		}else{
			hide_string = "#login-residents-form, #login-admin-form";
		}
		$(hide_string).fadeOut(400, function(){
				$("#create-account-form").fadeIn(500, function(){
			});
		});
	});	

	$(".panel .close").off('click').on('click', function(){
		var id = $(this).closest(".panel").attr('id');

		closePanel(id);
	});

	//Creates the opaque selection effect
	$(".edit-button, .announcement-edit-button").hover( function() {
		var id = $(this).attr('data-location');
    	$(id).fadeTo( 150, 0.55);
  	}, function(){
		var id = $(this).attr('data-location');
    	$( id ).fadeTo( 150, 1);		    
  	});

	//Hardcoded
	/*Open corresponding form on edit button click*/
  	$(".mail").off('click').on('click', function(){
  		openPanel("add-filled-pdf");
  	});

	/*Open corresponding form on edit button click*/
  	$(".edit-button, .option").off('click').on('click', function(){
  		openPanel($(this).attr('data-form'));
  	});

  	/*Allocate edit buttons*/
	$(window).resize(function() {
		allocateEditButtons();
	});

	$(window).load(function() {
	   allocateEditButtons();
	});

	allocateEditButtons();
});

// function displayLargeImage(id){

// 	var wait_time = 0;
// 	var fade_time = 200;

// 	$(".panel-background").fadeIn(250, function(){
// 		setTimeout(function() {
// 			$("#" + id).fadeIn(fade_time);
// 		}, wait_time);	
// 	});  	
// }

function showControlPanel(){
  	$("body").prepend($(".control-panel"));
  	$("header").css("top","40px");
  	$("#wrapper").css("padding-top","190px");
}

function openPanel(id){
	var open_panels = $(".panel:visible").length;
	closePanels();

	/*if no other panels*/
	var wait_time = 0;
	var fade_time = 200;
	if(open_panels > 0){// if other panels
		wait_time = 425;
		fade_time = 400;
	}

	$(".panel-background").fadeIn(250, function(){
		setTimeout(function() {
			$("#" + id).fadeIn(fade_time);
		}, wait_time);	
	});
}

function closePanels(){
	var open_panels = $(".panel:visible").length;	
	if(open_panels <= 0){//If no other panels
		$(".panel-background").fadeOut(300);
		$(".panel").fadeOut(200);
	}else{//If other panels
		$(".panel").fadeOut(300);
	}
}

function closePanel(id){
	$("#" + id).fadeOut(200, function(){
		if(!$(".panel").is(":visible")){
			$(".panel-background").fadeOut(150);
		}
	});
}

function allocateEditButtons(){
	$(".edit-button").each(function(){

		var id = $(this).attr('data-location');		
		var pos = $(id).position();
		var width = $(id).outerWidth();
		var innerOuter;		

		$(this).insertAfter(id);

		if($(this).hasClass('inner')){
			innerOuter = 32;
		}else if($(this).hasClass('outer')){
			innerOuter = 0;
		}
		if(this + " ")
		$(this).css({

		});
	    $(this).css({
	        position: "absolute",
	        top: pos.top + "px",
	        left: (pos.left + width - innerOuter) + "px"
	    }).show();
	});	
}

/*For deleting users and posts*/
function deluser(id, title)
{
  if (confirm("Are you sure you want to delete '" + title + "'"))
  {
    var new_url = appendQuery(window.location.href.split('?')[0], "cms", "view");
    var newer_url = appendQuery(new_url, "deluser", id);
    window.location.href = newer_url;
  }
}
function delpost(id, title)
{
    if (confirm("Are you sure you want to delete '" + title + "'"))
    {
      var new_url = appendQuery(window.location.href.split('?')[0], "cms", "view");
      var newer_url = appendQuery(new_url, "delpost", id);
      window.location.href = newer_url;
    }
}

function delphoto(id, title)
{
    if (confirm("Are you sure you want to delete '" + title + "'"))
    {
      var new_url = appendQuery(window.location.href.split('?')[0], "cms", "view");
      var newer_url = appendQuery(new_url, "delphoto", id);
      window.location.href = newer_url;
    }
}

function delfile(id, title)
{
    if (confirm("Are you sure you want to delete '" + title + "'"))
    {
      var new_url = appendQuery(window.location.href.split('?')[0], "cms", "view");
      var newer_url = appendQuery(new_url, "delfile", id);
      window.location.href = newer_url;
    }
}


jQuery.fn.sortElements = (function(){
    
    var sort = [].sort;
    
    return function(comparator, getSortable) {
        
        getSortable = getSortable || function(){return this;};
        
        var placements = this.map(function(){
            
            var sortElement = getSortable.call(this),
                parentNode = sortElement.parentNode,
                
                // Since the element itself will change position, we have
                // to have some way of storing it's original position in
                // the DOM. The easiest way is to have a 'flag' node:
                nextSibling = parentNode.insertBefore(
                    document.createTextNode(''),
                    sortElement.nextSibling
                );
            
            return function() {
                
                if (parentNode === this) {
                    throw new Error(
                        "You can't sort elements if any one is a descendant of another."
                    );
                }
                
                // Insert before flag:
                parentNode.insertBefore(this, nextSibling);
                // Remove flag:
                parentNode.removeChild(nextSibling);
                
            };
            
        });
       
        return sort.call(this, comparator).each(function(i){
            placements[i].call(getSortable.call(this));
        });
        
    };
    
})();