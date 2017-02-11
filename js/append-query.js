function appendQuery(uri, key, value) {
  var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
  var separator = uri.indexOf('?') !== -1 ? "&" : "?";
  if (uri.match(re)) {
    return uri.replace(re, '$1' + key + "=" + value + '$2');
  }
  else {
    return uri + separator + key + "=" + value;
  }
}

function extractDomain(url) {
    var domain;
    //find & remove protocol (http, ftp, etc.) and get domain
    if (url.indexOf("://") > -1) {
        domain = url.split('/')[2];
    }
    else {
        domain = url.split('/')[0];
    }

    //find & remove port number
    domain = domain.split(':')[0];

    return domain;
}


function stripQuery(url){
	var new_url = url.split('?')[0];
	return new_url;
}

/*
Will modify all the links on the site in order to maintain a "logged in state"
 */
function modifyLinks(role){
	$('a').not(".ignore-target").each(function() {	
		var first_query;
		var second_query;
		var new_link;
		if(role == "admin"){			
			first_query = appendQuery($(this).attr("href"), "cms" , "view");
			new_link = first_query;
			$(this).attr("href", new_link);
		}
	});
}

