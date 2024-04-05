(function($){
	
	"use strict";
	
/* ---------------------------------------------------------------------- */
/*	Mega Menu
/* ---------------------------------------------------------------------- */ 

jQuery(document).ready(function(){
	var ul = jQuery('li.mega').find('> ul');	
	jQuery(ul).addClass('mega');

});

/*------------------------------------------------------------------------*/
/*		Navigation Current Menu
/*------------------------------------------------------------------------*/


jQuery(document).ready(function(){ 
		jQuery('#nav li.current-menu-item, #nav li.current_page_item, #side-nav li.current_page_item, #nav li.current-menu-ancestor, #nav li ul li ul li.current-menu-item').addClass('current');
		jQuery( '#nav li ul li:has(ul)' ).addClass('submenux');
});



/* ---------------------------------------------------------------------- */
/*	Navigation Active Menu (One-Page)
/* ---------------------------------------------------------------------- */ 

// some global caches
var $window = $(window),
	nav_height = jQuery('#nav-wrap').outerHeight();

jQuery('#nav').find('a').each(function() {
	// some caches
	var $this	= jQuery(this),	// jQuery(this) = #nav a
		href	= $this.attr('href');
	if( href && href.indexOf('#') !== -1 && href != '#' ) {
		// some caches
		var id 		= href.substring(href.indexOf('#')),
			section = $(id);
		if ( section.length > 0 ) { 
			 $window.on( 'resize scroll', function() {
				// some caches
				var section_top = section.offset().top - nav_height,
					section_height = section.outerHeight();
				if( $window.scrollTop() >= section_top && $window.scrollTop() < (section_top + section_height) ) {
					$this.parent().siblings().removeClass('active').end().addClass('active');
				}
			} );
		}
	} // end if
});




/* ---------------------------------------------------------------------- */
/*	Scroll to top + menu smooth scroll
/* ---------------------------------------------------------------------- */

  jQuery(document).ready(function(){ 
 
        jQuery(window).scroll(function(){
            if (jQuery(this).scrollTop() > 100) {
                jQuery('.scrollup').fadeIn();
            } else {
                jQuery('.scrollup').fadeOut();
            }
        }); 
 
        jQuery('.scrollup').click(function(){
            jQuery("html, body").animate({ scrollTop: 0 }, 700);
            return false;
        });
 
  jQuery(function() {
  jQuery('#nav a[href*=#]:not([href=#]), .max-hero a.button').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = jQuery(this.hash);
      target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        jQuery('html,body').animate({
          scrollTop: target.offset().top
        }, 700);
        return false;
      }
    }
  });
});
});



/* ---------------------------------------------------------------------- */
/* Menu Responsive Switcher
/* ---------------------------------------------------------------------- */ 

jQuery(document).ready(function($){

	/* prepend menu icon */
	jQuery('#nav-wrap').prepend('<div id="menu-icon"><i class="fa-navicon"></i> <span>Menu - </span><span class="mn-clk">Navigation</span></div>');
	
	/* toggle nav */
	jQuery("#menu-icon").on("click", function(){
		jQuery("#nav").fadeToggle();
		jQuery(this).toggleClass("active");
	});

});

/* ---------------------------------------------------------------------- */
/*	Windows Phone 8 and Device-Width + Menu fix
/* ---------------------------------------------------------------------- */

jQuery(document).ready(function($){
if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement("style");
    msViewportStyle.appendChild(
        document.createTextNode(
            "@-ms-viewport{width:auto!important}"
        )
    );
    document.getElementsByTagName("head")[0].
        appendChild(msViewportStyle);
	jQuery('ul#nav').addClass('ie10mfx');
}
});

/* ---------------------------------------------------------------------- */
/*	doubleTapToGo
/* ---------------------------------------------------------------------- */

jQuery(document).ready(function($){
    var deviceAgent = navigator.userAgent.toLowerCase();
    var agentID = deviceAgent.match(/(iphone|ipod|ipad)/);
    if (agentID) {

        var width = jQuery(window).width();
	if (width > 768) {
		if(jQuery( '#nav li:has(ul)' ).length)
		{
			jQuery( '#nav li:has(ul)' ).doubleTapToGo();
		}
	}
 
    }
else {
	jQuery( '#nav li:has(ul)' ).doubleTapToGo();
}
});



/* ---------------------------------------------------------------------- */
/*	Accordion
/* ---------------------------------------------------------------------- */
	
	(function() {

		var $container = jQuery('.acc-container'),
			$trigger   = jQuery('.acc-trigger');

		$container.hide();
		$trigger.first().addClass('active').next().show();

		var fullWidth = $container.outerWidth(true);
		$trigger.css('width', fullWidth);
		$container.css('width', fullWidth);
		
		$trigger.on('click', function(e) {
			if( jQuery(this).next().is(':hidden') ) {
				$trigger.removeClass('active').next().slideUp(300);
				jQuery(this).toggleClass('active').next().slideDown(300);
			}
			e.preventDefault();
		});

		// Resize
		jQuery(window).on('resize', function() {
			fullWidth = $container.outerWidth(true)
			$trigger.css('width', $trigger.parent().width() );
			$container.css('width', $container.parent().width() );
		});

	})();


/* ---------------------------------------------------------------------- */
/*	Contact Form
/* ---------------------------------------------------------------------- */

jQuery(document).ready(function(){

	jQuery( "#contact-form" ).validate( {
		rules: {
			cName: {
				required: true,
				minlength: 3
			},
			cEmail: {
				required: true,
				email: true
			},
			cMessage: {
				required: true
			}
		},
		messages: {
			cName: {
				required: "Your name is mandatory",
				minlength: jQuery.validator.format( "Your name must have at least {0} characters." )
			},
			cEmail: {
				required: "Need an email address",
				email: "The email address must be valid"
			},
			cMessage: {
				required: "Message is mandatory",
			}
		},
		onsubmit: true,
		errorClass: "bad-field",
		validClass: "good-field",
		errorElement: "span",
		errorPlacement: function(error, element) {
		if(element.parent('.field-group').length) {
				error.insertAfter(element.siblings('h5'));
			} else {
				error.insertBefore(element);
			}
		}
	});							
});

/* ---------------------------------------------------------------------- */
/* Header search form
/* ---------------------------------------------------------------------- */
jQuery(document).ready(function(){
	
	jQuery('.search-form-icon').click(function(){
		
			jQuery( '.search-form-box' ).addClass('show-sbox');
			jQuery('#search-box').focus();
		});
		
		
	jQuery(document).click(function(ev){

		var myID = ev.target.id;
		
		if((myID !='searchbox-icon' ) && myID !='search-box'){
			jQuery( '.search-form-box' ).removeClass('show-sbox');
		}
		
	});		
		
	});

/* ---------------------------------------------------------------------- */
/*		OurClient jCarousel Initialize
/* ---------------------------------------------------------------------- */

jQuery(document).ready(function() {
	if(jQuery('#our-clients').length){
		jQuery('#our-clients').jcarousel({
        auto: 2,
        wrap: 'last',
    });
	}
	
if(jQuery('#latest-projects').length){
		jQuery('#latest-projects').jcarousel({
		scroll: 1
		});
	}
});	
	
jQuery(document).ready(function() {
	if(jQuery('#testimonials-slider').length){
		jQuery('#testimonials-slider').jcarousel();
	}
	
});

/* ---------------------------------------------------------------------- */
/*		Pie Initialize
/* ---------------------------------------------------------------------- */

jQuery(document).ready(function(){

	if(jQuery('.pie').length)
	{
		jQuery('.pie').easyPieChart({
			barColor:'#ff9900',
			trackColor: '#f2f2f2',
			scaleColor: false,
			lineWidth:20,
			animate: 1000,
			onStep: function(value) {
				this.$el.find('span').text(~~value+1);
			}
		});
	}

});	


/* ---------------------------------------------------------------------- */
/*		Progress Bar
/* ---------------------------------------------------------------------- */

initProgress('.progress');

function initProgress(el){
	jQuery(el).each(function(){
		var pData = jQuery(this).data('progress');
		progress(pData,jQuery(this));
	});
}


			
function progress(percent, $element) {
	var progressBarWidth = 0;
	
	(function myLoop (i,max) {
		progressBarWidth = i * $element.width() / 100;
		setTimeout(function () {   
		$element.find('div').find('small').html(i+'%');
		$element.find('div').width(progressBarWidth);
		if (++i<=max) myLoop(i,max);     
		}, 10)
	})(0,percent);  
}	



/* ---------------------------------------------------------------------- */
/*		FlexSlider
/* ---------------------------------------------------------------------- */

jQuery(window).load(function() {
    jQuery('.flexslider').flexslider();
  });


/* ---------------------------------------------------------------------- */
/*		PrettyPhoto
/* ---------------------------------------------------------------------- */


jQuery(document).ready(function($){
    
	    /* --------- */
		/* Add PrettyPhoto */
		/* ------------------------ */
		
		var lightboxArgs = {			
						animation_speed: 'fast',
						overlay_gallery: true,
			autoplay_slideshow: false,
						slideshow: 5000, /* light_rounded / dark_rounded / light_square / dark_square / facebook */
									theme: 'pp_default', 
									opacity: 0.8,
						show_title: false,
			social_tools: "",			deeplinking: false,
			allow_resize: true, 			/* Resize the photos bigger than viewport. true/false */
			counter_separator_label: '/', 	/* The separator for the gallery counter 1 "of" 2 */
			default_width: 940,
			default_height: 529
		};

		$("a[rel^='prettyPhoto'], a[class^='prettyPhoto']").prettyPhoto();
		
});



/* ---------------------------------------------------------------------- */
/*		Isotope
/* ---------------------------------------------------------------------- */

jQuery(window).load(function(){

	var $container = jQuery('.portfolio');
	$container.isotope({
		filter: '*',
		//sortBy : 'random',
		animationOptions: {
			duration: 750,
			easing: 'linear',
			queue: false,
		}
	});

	jQuery('nav.primary .portfolioFilters a').click(function(){
		var selector = jQuery(this).attr('data-filter');
		$container.isotope({
			filter: selector,
			animationOptions: {
				duration: 750,
				easing: 'linear',
				queue: false,
			}
		});
	  return false;
	});

	var $optionSets = jQuery('nav.primary .portfolioFilters'),
	       $optionLinks = $optionSets.find('a');

	       $optionLinks.click(function(){
	          var $this = jQuery(this);
		  // don't proceed if already selected

		  if ( $this.hasClass('selected') ) {
		      return false;
		  }
	   var $optionSet = $this.parents('nav.primary .portfolioFilters');
	   $optionSet.find('.selected').removeClass('selected');
	   $this.addClass('selected'); 
	});

});

/* ---------------------------------------------------------------------- */
/*		Masonry
/* ---------------------------------------------------------------------- */

jQuery(window).load(function() {

	// Initialize Masonry
	if(jQuery('#pin-content').length){
		jQuery('#pin-content').masonry({
			itemSelector: '.pin-box',
		}).imagesLoaded(function() {
			jQuery('#pin-content').data('masonry');
		});
	}

});



/* ---------------------------------------------------------------------- */
/*  Super Slides
/* ---------------------------------------------------------------------- */

jQuery('.max-hero').superslides({
		  animation: 'fade'
		});
  
/* ---------------------------------------------------------------------- */
/*  fitVids
/* ---------------------------------------------------------------------- */

jQuery(document).ready(function(){
		   jQuery("#wrap").fitVids();
		});

	
/* ---------------------------------------------------------------------- */
/*  Parallax New
/* ---------------------------------------------------------------------- */

( function ( $ ) {
'use strict';
 jQuery(document).ready(function(){
 jQuery(window).bind('load', function () {
		parallaxInit();						  
	});
	function parallaxInit() {
		testMobile = isMobile.any();
		if (testMobile == null)
		{
			jQuery('.sparallax .slide1').parallax("50%", 0.2);
			jQuery('.sparallax .slide2').parallax("50%", 0.2);
			jQuery('.sparallax .slide3').parallax("50%", 0.2);
			jQuery('.sparallax .slide4').parallax("50%", 0.2);
			jQuery('.sparallax .slide5').parallax("50%", 0.2);
			jQuery('.sparallax .slide6').parallax("50%", 0.2);

		}
	}	
	parallaxInit();	 
});
//Mobile Detect
var testMobile;
var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};	
}( jQuery ));

/* ---------------------------------------------------------------------- */
/* Max Counter
/* ---------------------------------------------------------------------- */

(function($){
	
	"use strict";
	
    jQuery(document).ready(function(){
        
	
	
		jQuery('.max-counter').each(function(i, el){
									
			var counter = jQuery(el).data('counter');
			
			if ( jQuery(el).visible(true) && !jQuery(el).hasClass('counted') ) {
							
				setTimeout ( function () {
				
					jQuery(el).addClass('counted');
											
					jQuery(el).find('.max-count').countTo({
						from: 0,
						to: counter,
						speed: 2000,
						refreshInterval: 100
					});
				
				}, 1000 );
					
			}
			
		});	
				
		var win 	= jQuery(window),
			allMods = jQuery(".max-counter");
		
		

		win.scroll( function(event) {
		
			allMods.each(function(i, el) {
				
				var el = jQuery(el),
					effecttype = el.data('effecttype');
				
				
				if( effecttype === 'counter') {
				
					var counter = el.data('counter');
					
					if ( el.visible(true) && !jQuery(el).hasClass('counted') ) {
				  		
						el.addClass('counted');
						
						el.find('.max-count').countTo({
							from: 0,
							to: counter,
							speed: 2000,
							refreshInterval: 100
						});
					  
					}
				
				}
				
			});
			  
		});
		
    });
	
	
	$.fn.countTo = function (options) {
		options = options || {};
		
		return jQuery(this).each(function () {
			// set options for current element
			var settings = $.extend({}, $.fn.countTo.defaults, {
				from:            jQuery(this).data('from'),
				to:              jQuery(this).data('to'),
				speed:           jQuery(this).data('speed'),
				refreshInterval: jQuery(this).data('refresh-interval'),
				decimals:        jQuery(this).data('decimals')
			}, options);
			
			// how many times to update the value, and how much to increment the value on each update
			var loops = Math.ceil(settings.speed / settings.refreshInterval),
				increment = (settings.to - settings.from) / loops;
			
			// references & variables that will change with each update
			var self = this,
				$self = jQuery(this),
				loopCount = 0,
				value = settings.from,
				data = $self.data('countTo') || {};
			
			$self.data('countTo', data);
			
			// if an existing interval can be found, clear it first
			if (data.interval) {
				clearInterval(data.interval);
			}
			data.interval = setInterval(updateTimer, settings.refreshInterval);
			
			// initialize the element with the starting value
			render(value);
			
			function updateTimer() {
				value += increment;
				loopCount++;
				
				render(value);
				
				if (typeof(settings.onUpdate) == 'function') {
					settings.onUpdate.call(self, value);
				}
				
				if (loopCount >= loops) {
					// remove the interval
					$self.removeData('countTo');
					clearInterval(data.interval);
					value = settings.to;
					
					if (typeof(settings.onComplete) == 'function') {
						settings.onComplete.call(self, value);
					}
				}
			}
			
			function render(value) {
				var formattedValue = settings.formatter.call(self, value, settings);
				$self.html(formattedValue);
			}
		});
	};
	
	$.fn.countTo.defaults = {
		from: 0,               // the number the element should start at
		to: 0,                 // the number the element should end at
		speed: 1000,           // how long it should take to count between the target numbers
		refreshInterval: 100,  // how often the element should be updated
		decimals: 0,           // the number of decimal places to show
		formatter: formatter,  // handler for formatting the value before rendering
		onUpdate: null,        // callback method for every time the element is updated
		onComplete: null       // callback method for when the element finishes updating
	};
	
	function formatter(value, settings) {
		return value.toFixed(settings.decimals);
	}
	
	
})(jQuery);	
		

/* ---------------------------------------------------------------------- */
/*  Parallax Sections
/* ---------------------------------------------------------------------- */

jQuery(document).ready(function(){

	var width = jQuery(window).width();
	if (width > 768) {


	// Cache the Window object
	$window = jQuery(window);
                
   jQuery('section[data-type="background"]').each(function(){
     var $bgobj = jQuery(this); // assigning the object
                    
      jQuery(window).scroll(function() {
                    
		// Scroll the background at var speed
		// the yPos is a negative value because we're scrolling it UP!								
		var yPos = -($window.scrollTop() / $bgobj.data('speed')); 
		
		// Put together our final background position
		var coords = '50% '+ yPos + 'px';

		// Move the background
		$bgobj.css({ backgroundPosition: coords });
		
}); // window scroll Ends

 });	
};
}); 
/* 
 * Create HTML5 elements for IE's sake
 */

 
/*
**	Init update Woo Cart
*/
function updateShoppingCart(){
	"use strict";

		jQuery('body').bind('added_to_cart', add_to_cart);
		
		function add_to_cart(event, parts, hash) {
			var miniCart = jQuery('.woo-cart-header');
			
			if ( parts['div.widget-woo-cart-content'] ) {
				var $cartContent = jQuery(parts['div.widget-woo-cart-content']),
				$itemsList = $cartContent .find('.cart-list'),
				$total = $cartContent.find('.total').contents(':not(strong)').text();
				miniCart.find('.woo-cart-dropdown').html('').append($itemsList);
				miniCart.find('.total span').html('').append($total);
			}
		}
}
 
 
document.createElement("article");
document.createElement("section");

})(jQuery);