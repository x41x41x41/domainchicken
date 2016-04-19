/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var srchtermArray = new Array();
var favouriteArray = new Array();
var domaintld = {
        com: '.com',
        couk: '.co.uk',
        net: '.net',
        org: '.org',
    };
jQuery(function ($) {
    
    $('body').on( "click", '.fav', function( event ) {
        event.preventDefault();
        console.log('fav click')
        if($(this).closest('.singleRequest').hasClass('favourite')) {
            $(this).closest('.singleRequest').removeClass('favourite');
            removeFavorite($(this).closest('.singleRequest').attr('data-srchterm'));
        } else {
            $(this).closest('.singleRequest').addClass('favourite');
            addFavorite($(this).closest('.singleRequest').attr('data-srchterm'));
        }
        //localStorage[$(this).closest('.singleRequest').attr('data-srchterm')] = JSON.stringify(srchtermArray[$(this).closest('.singleRequest').attr('data-srchterm')]);
    });
    
    $('.fav').on( "click", function( event ) {
        event.preventDefault();
        console.log('fav click')
        if($(this).closest('.singleRequest').hasClass('favourite')) {
            $(this).closest('.singleRequest').removeClass('favourite');
            removeFavorite($(this).closest('.singleRequest').attr('data-srchterm'));
        } else {
            $(this).closest('.singleRequest').addClass('favourite');
            addFavorite($(this).closest('.singleRequest').attr('data-srchterm'));
        }
        //localStorage[$(this).closest('.singleRequest').attr('data-srchterm')] = JSON.stringify(srchtermArray[$(this).closest('.singleRequest').attr('data-srchterm')]);
    });
    
    $('#srchterm').bind('keypress', function(e) {
        if(e.keyCode==13){
            var srchterm = $('#srchterm').val().replace(/\s/g, '');
            srchtermArray[srchterm] = { 
                srchterm: srchterm,
                domains: new Object(), 
                networks: new Object(),
                others: new Object(),
                counts: new Object(),
                status: 0,
                favourite: 0
            };
            
            srchtermArray[srchterm].counts.total = 9;
            srchtermArray[srchterm].counts.done = 0;
            
            srchtermArray[srchterm].domains.com = 0;
            srchtermArray[srchterm].domains.couk = 0;
            srchtermArray[srchterm].domains.net = 0;
            srchtermArray[srchterm].domains.org = 0;
            
            srchtermArray[srchterm].networks.twitter = 0;
            srchtermArray[srchterm].networks.facebook = 0;
            srchtermArray[srchterm].networks.gplus = 0;
            srchtermArray[srchterm].networks.youtube = 0;
            srchtermArray[srchterm].networks.instagram = 0;
            
            srchtermArray[srchterm].others.chouse = 0;
            
            processUpdate(srchterm);
            processSingle(srchtermArray[srchterm]);
        }
    });
});


function processSingle(singleRequest) {
    //workoutwhattodisplay
    var mainstatus = '';
    var favourite = '';
    var domains = '';
    var networks = '';
    var others = '';
    
    for (var key in singleRequest.domains) {
        domains += '<li class="result'+key+'"><i class="fa fa-globe"></i> '+domaintld[key]+'</li>';
    }
    
    for (var key in singleRequest.networks) {
        if(key == 'twitter') {
            networks += '<li class="result'+key+'"><i class="fa fa-twitter"></i> Twitter</li>';
        }else if(key == 'facebook') {
            networks += '<li class="result'+key+'"><i class="fa fa-facebook"></i> Facebook</li>';
        } else if(key == 'gplus') {
            networks += '<li class="result'+key+'"><i class="fa fa-google-plus"></i> Google Plus</li>';
        } else if(key == 'youtube') {
            networks += '<li class="result'+key+'"><i class="fa fa-youtube"></i> Youtube</li>';
        } else if(key == 'instagram') {
            networks += '<li class="result'+key+'"><i class="fa fa-instagram"></i> Instagram</li>';
        } else {
            networks += '<li class="result'+key+'"><i class="fa fa-spinner waiting fa-spin"></i><i class="fa finished fa-circle"></i> '+key+'</li>';
        }
    }
    
     for (var key in singleRequest.others) {
        
        if(key == 'chouse') {
            others += '<li class="result'+key+'"><i class="fa fa-building"></i> Companies House (UK)</li>';
        } else {
            others += '<li class="result'+key+'"><i class="fa fa-spinner waiting fa-spin"></i><i class="fa finished fa-circle"></i> '+key+'</li>';
        }
    }
        
        
    
    
    if(singleRequest.favourite == 1) {
        favourite = ' favourite';
    }
    
    //display

     var result = '<div class="row singleRequest '+singleRequest.srchterm+mainstatus+favourite+'" data-srchterm="'+singleRequest.srchterm+'">';
     result += '<div class="panel-heading"><h4> '+singleRequest.srchterm+'</h4></div>';
     result += '<div class="col s12 m4 l4"><ul class="results">'+domains+'</ul></div>';
     result += '<div class="col s12 m4 l4"><ul class="results">'+networks+'</ul></div>';
     result += '<div class="col s12 m4 l4"><ul class="results">'+others+'</ul></div>';
     result += '</div>';
          
    $('.resultsrow').prepend(result);
    
    //process if we haven't concluded anything
    if(singleRequest.status == 0) {
        for (var key in singleRequest.domains) {
            getDomainResult(singleRequest.srchterm, domaintld[key]);
        }
        for (var key in singleRequest.networks) {
            getSocialResult(singleRequest.srchterm, key);
        }
        for (var key in singleRequest.others) {
            getOtherResult(singleRequest.srchterm, key);
        }
    }
}
    
/* domain stuff */
function getDomainResult(srchterm, tld) {
    $.ajax({
        url: 'api/api.php',
        type: 'GET',
        data: { method: 'domain', domain: srchterm+tld },
        dataType: 'jsonp',
        success: function (data, response) {
          if(data.success == 1) {
            outputResult(srchterm, tld.replace(/\./g, ""), data.resultbinary, data.seeurl);
            srchtermArray[srchterm].counts.done++;
            srchtermArray[srchterm].domains[tld.replace(/\./g, "")] = data.resultbinary;
            processUpdate(srchterm);
          } else {
            alert('Ajax Error');
          }
        }
    });
}

/* social media stuff */
function getSocialResult(srchterm, network) {
    $.ajax({
        url: 'api/api.php',
        type: 'GET',
        data: { method: 'social', domain: srchterm, network: network },
        dataType: 'jsonp',
        success: function (data, response) {
          if(data.success == 1) {
            outputResult(srchterm, network, data.resultbinary, data.seeurl);
            srchtermArray[srchterm].counts.done++;
            srchtermArray[srchterm].networks[network] = data.resultbinary;
            processUpdate(srchterm);
          } else {
            alert('Ajax Error');
          }
        },
        error: function() {
          console.log('error');
          alert('Ajax Error');
        }
    });
}

/* other stuff */
function getOtherResult(srchterm, network) {
    $.ajax({
        url: 'api/api.php',
        type: 'GET',
        data: { method: 'other', domain: srchterm, type: network },
        dataType: 'jsonp',
        success: function (data, response) {
          if(data.success == 1) {
            outputResult(srchterm, network, data.resultbinary, data.seeurl);
            srchtermArray[srchterm].counts.done++;
            srchtermArray[srchterm].others[network] = data.resultbinary;
            processUpdate(srchterm);
          } else {
            console.log('error');
            alert('Ajax Error');
          }
        },
        error: function() {
          console.log('error');
          alert('Ajax Error');
        }
    });
}

function outputResult(srchterm, ext, binary, singleurl) {
    if(binary == 1) {
        $('.'+srchterm+' .result'+ext).addClass('available').append(' <i class="fa fa-thumbs-up"></i>');
    } else {
        $('.'+srchterm+' .result'+ext).addClass('notavailable').wrapInner('<a href="'+singleurl +'" target="_blank"/>').append(' <i class="fa fa-thumbs-down"></i>');
        srchtermArray[srchterm].status = -1;
    }
}

/* process update */
function processUpdate(srchterm) {
    if(srchtermArray[srchterm].counts.done == srchtermArray[srchterm].counts.total) {
        if(srchtermArray[srchterm].status == -1) {
            $('.'+srchterm).addClass('nodice');
        } else {
            srchtermArray[srchterm].status = 1;
            $('.'+srchterm).addClass('yesdice');
        }
    }
    //localStorage[srchterm] = JSON.stringify(srchtermArray[srchterm]);
}

function addFavorite(srchtermname) {
    console.log('Adding Favorite: '+srchtermname);
    removeFavorite(srchtermname);
    
    //add to start of dom
    $('.favorites').append(srchtermname)
    
    //get local storage
    var tempArray = JSON.parse(localStorage['mozzbiz_favdomains']);
    
    //if array append to begining, else create JSON
    tempArray.unshift(srchtermname);
    
    //store back in array
    localStorage["mozzbiz_favdomains"] = JSON.stringify(tempArray);

}

function removeFavorite(srchtermname) {
    console.log('Remove Favorite: '+srchtermname);
    
    //remove in dom
    $('.favorites').remove('.'+srchtermname);
    
    //get local storage
    var tempArray = JSON.parse(localStorage['mozzbiz_favdomains']);
    
    //if array append to begining, else create JSON
    var index = tempArray.indexOf(srchtermname);
    if (index > -1) {
        tempArray.splice(index, 1);
    }
    
    //store back in array
    localStorage["mozzbiz_favdomains"] = JSON.stringify(tempArray);
    
}
