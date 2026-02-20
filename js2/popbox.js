$(function() {
    	var moveLeft = 0;
	    var moveDown = 0;
    	$('a.popper').hover(function(e) {
   
        	var target = '#' + ($(this).attr('data-popbox'));
         
	        $(target).show();
    	    moveLeft = $(this).outerWidth()-10; // subtracted 10 for closer pop to cursor
        	moveDown = ($(target).outerHeight() / 2);//2
	    }, function() {
    	    var target = '#' + ($(this).attr('data-popbox'));
        	$(target).hide();
    	});
 
	    $('a.popper').mousemove(function(e) {
    	    var target = '#' + ($(this).attr('data-popbox'));
         
        	leftD = e.pageX + parseInt(moveLeft);
	        maxRight = leftD + $(target).outerWidth();
    	    windowLeft = $(window).width() - 10;//40
        	windowRight = 0;
	        maxLeft = e.pageX - (parseInt(moveLeft) + $(target).outerWidth() + 5);//20
         
    	    if(maxRight > windowLeft && maxLeft > windowRight)
        	{
            	leftD = maxLeft;
        	}
     
	        topD = e.pageY - parseInt(moveDown);
    	    maxBottom = parseInt(e.pageY + parseInt(moveDown) + 5);//20
        	windowBottom = parseInt(parseInt($(document).scrollTop()) + parseInt($(window).height()));
	        maxTop = topD;
	        windowTop = parseInt($(document).scrollTop());
    	    if(maxBottom > windowBottom)
        	{
            	topD = windowBottom - $(target).outerHeight() - 5;//20
	        } else if(maxTop < windowTop){
    	        topD = windowTop + 5;//20
        	}
     
    	    $(target).css('top', topD).css('left', leftD);
     
     
    	});
	});