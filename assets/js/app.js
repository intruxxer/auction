$(document).foundation();

$(document).on('ready', function()
	{
		$('.app-container > .row > .columns > section > .row > .columns').css('min-height', $(window).height() - $('#main-header').innerHeight());
		
		$('[rel="toggle-profile-navigation"]').on('touchstart, click', function(e) {
	        e.stopPropagation();
	        
	        if ($(this).next().hasClass('is-hidden')) {
		    	$(this).next().removeClass('is-hidden');
		    	   
	        } else {
		        $(this).next().addClass('is-hidden');
	        }
	    });
	    
	    $(document).on('touchstart, click', function(e) {
	        if (!$('[rel="toggle-profile-navigation"]').next().hasClass('is-hidden')) {
	            $('[rel="toggle-profile-navigation"]').next().addClass('is-hidden');
	        }
    	});
	});
	

