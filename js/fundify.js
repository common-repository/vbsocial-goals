/**

 * Functionality specific to Fundify

 *

 * Provides helper functions to enhance the theme experience.

 */



var Fundify = {}



Fundify.App = (function($) {

	function fixedHeader() {

		fixHeader();



		$(window).scroll(function () {

			var y = $(window).scrollTop();    



			if ( y >= 400 ) {

				$( '#header' ).addClass( 'mini' );

			} else {

				$( '#header' ).removeClass( 'mini' );

			}

		});



		$(window).resize(function() {

			fixHeader();

		});



		function fixHeader() {

			var x = $(window).width();



			if ( ! $( 'body' ).hasClass( 'fixed-header' ) ) {

				$( 'body' ).css( 'padding-top', 0 );

			} else {

				$( 'body' ).css( 'padding-top', $( '#header' ).outerHeight() );

			}

		}

	}



	return {

		init : function() {

			fixedHeader();



			this.menuToggle();



			$( '.login a, .register a' ).click(function(e) {

				e.preventDefault();

				

				Fundify.App.fancyBox( $(this), {

					items: {

						'src'  : '#' + $(this).parent().attr( 'id' ) + '-wrap'

					}

				});

			});



			$( '.fancybox' ).click( function(e) {

				e.preventDefault();



				Fundify.App.fancyBox( $(this ), {

					items : {

						'src'  : '#' + $(this).attr( 'href' )

					}

				} );

			} );

		},



		/**

		 * Check if we are on a mobile device (or any size smaller than 980).

		 * Called once initially, and each time the page is resized.

		 */

		isMobile : function( width ) {

			var isMobile = false;



			var width = 1180;

			

			if ( $(window).width() <= width )

				isMobile = true;



			return isMobile;

		},



		fancyBox : function( _this, args ) {

			$.magnificPopup.open( $.extend( args, {

				'type' : 'inline'

			}) );

		},



		menuToggle : function() {

			$( '.menu-toggle' ).click(function(e) {

				e.preventDefault();



				$( '#menu' ).slideToggle();

			});

		}

	}

}(jQuery));



Fundify.Campaign = (function($) {

	function campaignGrid() {

		if ( ! $().masonry )

			return;



		var container = $( '#projects section' );



		if ( container.masonry() )

			container.masonry( 'reload' );

		

	}



	function campaignTabs() {

		var tabs     = $( '.campaign-tabs' ),

		    overview = $( '.campaign-view-descrption' ),

		    tablinks = $( '.sort-tabs.campaign a' );

		

		tabs.children( 'div' ).hide();

		overview.hide();



		tabs.find( ':first-child' ).show();



		tablinks.click(function(e) {

			if ( $(this).hasClass( 'tabber' ) ) {

				var link = $(this).attr( 'href' );

					

				tabs.children( 'div' ).hide();

				overview.show();

				tabs.find( link ).show();

				

				$( 'body' ).animate({

					scrollTop: $(link).offset().top - 200

				});

			}

		});

	}



	function campaignPledgeLevels() {

		$( '.single-reward-levels li' ).click( function(e) {

			e.preventDefault();



			if ( $( this ).hasClass( 'inactive' ) )

				return false;



			var price = $( this ).data( 'price' );



			Fundify.App.fancyBox( $(this), {

				items : {

					src  : '#contribute-modal-wrap'

				},

				callbacks: {

					beforeOpen : function() {

						$( '#contribute-modal-wrap .edd_price_options' )

							.find( 'li[data-price="' + price + '"]' )

							.trigger( 'click' );

					}

				}

			});

		} );

	}



	function campaignWidget() {

		$( 'body.campaign-widget a' ).attr( 'target', '_blank' );

	}



	return {

		init : function() {

			campaignGrid();

			campaignTabs();

			campaignPledgeLevels();

			campaignWidget();

		},



		resizeGrid : function() {

			campaignGrid();

		}

	}

} )(jQuery);



Fundify.Checkout = (function($) {

	return function() {

		$( '.contribute, .contribute a' ).click(function(e) {

			e.preventDefault();



			Fundify.App.fancyBox( $(this), {

				items : {

					'src' : '#contribute-modal-wrap'

				}

			});

		});

	}

}(jQuery));



jQuery(document).ready(function($) {

	Fundify.App.init();

	Fundify.Campaign.init();

	Fundify.Checkout();



	$( window ).on( 'resize', function() {

		Fundify.Campaign.resizeGrid();

	});

	

	/**

	 * Repositions the window on jump-to-anchor to account for

	 * navbar height.

	 */

	var fundifyAdjustAnchor = function() {

		if ( window.location.hash )

			window.scrollBy( 0, -150 );

	};



	$( window ).on( 'hashchange', fundifyAdjustAnchor );

});



// Timer Functions //

function CountDown(initDate, id){

    this.endDate = new Date(initDate);

    this.countainer = document.getElementById(id);

    this.numOfDays = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    this.borrowed = 0, this.years = 0, this.months = 0, this.days = 0;

    this.hours = 0, this.minutes = 0, this.seconds = 0;

    this.updateNumOfDays();

    this.updateCounter();

}

  

CountDown.prototype.updateNumOfDays=function(){

    var dateNow = new Date();

    var currYear = dateNow.getFullYear();

    if ( (currYear % 4 == 0 && currYear % 100 != 0 ) || currYear % 400 == 0 ) {

        this.numOfDays[1] = 29;

    }

    var self = this;

    setTimeout(function(){self.updateNumOfDays();}, (new Date((currYear+1), 1, 2) - dateNow));

}

  

CountDown.prototype.datePartDiff=function(then, now, MAX){

    var diff = now - then - this.borrowed;

    this.borrowed = 0;

    if ( diff > -1 ) return diff;

    this.borrowed = 1;

    return (MAX + diff);

}

  

CountDown.prototype.calculate=function(){

    var futureDate = this.endDate;

    var currDate = new Date();

    this.seconds = this.datePartDiff(currDate.getSeconds(), futureDate.getSeconds(), 60);

    this.minutes = this.datePartDiff(currDate.getMinutes(), futureDate.getMinutes(), 60);

    this.hours = this.datePartDiff(currDate.getHours(), futureDate.getHours(), 24);

    this.days = this.datePartDiff(currDate.getDate(), futureDate.getDate(), this.numOfDays[futureDate.getMonth()]);

    this.months = this.datePartDiff(currDate.getMonth(), futureDate.getMonth(), 12);

    this.years = this.datePartDiff(currDate.getFullYear(), futureDate.getFullYear(),0);

}

  

CountDown.prototype.addLeadingZero=function(value){

    return value < 10 ? ("0" + value) : value;

}

  

CountDown.prototype.formatTime=function(){

    this.seconds = this.addLeadingZero(this.seconds);

    this.minutes = this.addLeadingZero(this.minutes);

    this.hours = this.addLeadingZero(this.hours);

}

  

CountDown.prototype.updateCounter=function(){

    this.calculate();

    this.formatTime();

    this.countainer.innerHTML =

       " <strong>" + (parseInt(this.days)+3) + "</strong> <small>" + (this.days == 1? "day" : "days") + "</small>" +

       " <strong>" + this.hours + "</strong> <small>" + (this.hours == 1? "hour" : "hours") + "</small>" +

       " <strong>" + this.minutes + "</strong> <small>" + (this.minutes == 1? "minute" : "minutes") + "</small>" +

       " <strong>" + this.seconds + "</strong> <small>" + (this.seconds == 1? "second" : "seconds") + "</small>";

    if ( this.endDate > (new Date()) ) {

        var self = this;

        setTimeout(function(){self.updateCounter();}, 1000);

    }

}