require( './libs/fontsmoothie.min.js' );
require( './libs/skip-link-focus-fix.js' );
require( 'js-cookie' );
require( 'slick-carousel' );

function getCookie( cname ) {
	const name = cname + '=';
	const decodedCookie = decodeURIComponent( document.cookie );
	const ca = decodedCookie.split( ';' );
	for ( let i = 0; i < ca.length; i++ ) {
		let c = ca[ i ];
		while ( c.charAt( 0 ) == ' ' ) {
			c = c.substring( 1 );
		}
		if ( c.indexOf( name ) == 0 ) {
			return c.substring( name.length, c.length );
		}
	}
	return '';
}

/* eslint-disable-next-line */
jQuery(document).ready(function ($) {
	$( document.documentElement ).removeClass( 'no-js' );
	$( document.documentElement ).addClass( 'js' );
	$( document.documentElement ).addClass( 'loaded' );

	const $mainMenuItems = $( '.main-nav ul li' );

	/**
	 * Position submenus that flow offscreen to the left of their parent.
	 */
	$mainMenuItems.on( 'mouseover focus', function ( e ) {
		e.stopPropagation();
		const $menuItem = $( e.currentTarget );
		const $subMenu = $menuItem.children( 'ul' ).first();

		if ( $subMenu.length ) {
			const isOffScreen =
				$subMenu.offset().left + $subMenu.width() > $( window ).width();

			if ( isOffScreen ) {
				$subMenu.css( {
					left: '-100%',
				} );
			}
		}
	} );

	$( window ).on( 'resize', function () {
		$mainMenuItems.removeAttr( 'style' );
	} );

	// Mobile menu
	$( '.main-nav__toggle' ).on( 'click', function () {
		$( 'body' ).toggleClass( 'main-nav__open' );
	} );

	const anchorsWithChildren = document.querySelectorAll('.main-nav .menu-item-has-children > a, .main-nav .page_item_has_children > a');
	const anchorsWithChildrenSubmenu = document.querySelectorAll('.main-nav .menu-item-has-children > ul, .main-nav .page_item_has_children > ul');

	// Add dropdown buttons for mobile menu submenu
	function mobileMenuDropdownIcons() {

		for (const a of anchorsWithChildren) {
			let expandBtn = document.createElement('button');
			expandBtn.classList.add('expand');

			let expandBtnLabel = document.createElement('SPAN');
			expandBtnLabel.innerText = 'Open Submenu';
			expandBtnLabel.classList.add('sr-only');
			expandBtn.appendChild(expandBtnLabel);
			a.after(expandBtn);
		}
	}

	mobileMenuDropdownIcons();

	$('.main-nav .expand').on('click', function() {
		$(this).parent().toggleClass('expanded');
		$(this).next('.sub-menu').toggle("medium");
	});

	// Tabbed Content
	$(function() {
		$('.layout--tabbed-content').each( function() {
			let $tab = $('.menu-item', this);
			let $sel = $('.tabbed-content__tab-select', this);
			
			$tab.first().addClass('active');

			$sel.on('change', function(e) {
				let $this = $(this);
				let tabbedContent = $this.parents('.tabbed-content');
				let details = tabbedContent.find( ('.' + this.value) );
				let tab = $('.' + $this.find(':selected').attr('data-content'));

				if ( details.is(':hidden') ) {
					tabbedContent.find('.tab-details').hide();
					details.fadeIn('300');
				} else {
					tabbedContent.find('.tab-details').fadeOut('300');
				}

				tabbedContent.find('.menu-item').removeClass('active');
				tabbedContent.find(tab).toggleClass('active');
			});

			$tab.on('focus', function() {
				let $this = $(this);
				let allDetails = $this.parents('.tabbed-content').find('.tab-details');
				var details = $this.parents('.tabbed-content').find('.' + this.dataset.target);

				if (details.is(':hidden')) {
					allDetails.hide();
					details.fadeIn('300');
				} else {
					allDetails.not(details).fadeOut('300');
				}

				$tab.removeClass('active');
				$this.addClass('active');
			});
		});
	});

	//initiate testimonial slider
	// $( document ).ready( function () {
	// 	const n = $( '.testimonials__slide' ).length;
	// 	if ( n > '1' ) {
	// 		$( '.testimonial-slides' ).slick( {
	// 			dots: true,
	// 		} );
	// 	}
	// } );
} );

( function ( $ ) {
	//alert banner
	$( document ).ready( function () {
		let in_customizer = false;

		if ( typeof wp !== 'undefined' ) {
			in_customizer = typeof wp.customize !== 'undefined' ? true : false;
		}

		if ( in_customizer || getCookie( 'sitewide-banner' ) == '' ) {
			//show banner.
			const x = document.getElementById( 'site-alert-banner' );
			if ( x !== null ) {
				x.style.display = 'flex';
			}
		} else {
			//banner will stay hidden
		}
	} );

	$( document ).ready( function () {
		//close on press of X button
		$( '.close-banner' ).click( function () {
			//fadeout banner on close button
			$( '#site-alert-banner' ).fadeOut();
			//add cookie for banner and expire after 2 days
			document.cookie = 'sitewide-banner=closed; max-age=172800';
		} );
	} );

	$('body.blog .toggle-container a').on('click', function(e){
        e.preventDefault();
        $('body.blog .toggle-container a').removeClass('active');
        $(this).addClass('active');
        if($(this).hasClass('grid-view')){
           $('body.blog .posts-container').removeClass('list-view');
           $('body.blog .posts-container').addClass('grid-view');
        } else {
            $('body.blog .posts-container').removeClass('grid-view');
            $('body.blog .posts-container').addClass('list-view');
        }
    });

} )( jQuery );


// Header search
(function($) {
    // navbar search mobile
    $(document).ready(function() {
        const navSearch = document.querySelector('.search-bar');
        const searchBtn = document.querySelectorAll('.header-search');
        const header = document.querySelector('.site-header');
        const body = document.querySelector('body');
        const closeSearch = '<button class="close-search"><span class="sr-only">Close Searchbar</span></button>';

        $(closeSearch).appendTo(navSearch);

        $(searchBtn).click( function() { 
            $(body).addClass('header-searchbar-visible');
            $(header).addClass('searchbar-visible');

            $('.close-search').click( function() {
                $(body).removeClass('header-searchbar-visible');
                $(header).removeClass('searchbar-visible');
            });
        });
    });

	// move header search next to mobile menu toggle button
	function moveMobileSearchIcon() {
		// Check if the media query is true
		if (window.innerWidth < 1025) {
			let searchIcon = $('.main-nav .header-search');
			searchIcon.insertBefore('.main-nav__toggle');
		}
	}

	window.addEventListener('resize', moveMobileSearchIcon);
	moveMobileSearchIcon();

}) (jQuery);

// Locations Widget Scripts
jQuery(document).ready(function ($) {

	$(".locations-listing--toggle").click(function(){
		$(this).toggleClass("grid list");
		$(".locations-listing").toggleClass("grid list");
	});

	$(".hours-toggler").click(function(){
		var id = $(this).data('location-id');
		$(this).toggleClass("list-open");
		$("#hours-list-" + id).slideToggle();
	});
});

// header height calc
jQuery(document).ready(function ($) {
	function headerHeightCalc() {
		number = NaN;

		let siteHeader = $('.site-header').outerHeight();
		let topBar = $('.top-bar').outerHeight();
		let wpBar = $('#wpadminbar').outerHeight();

		topBar = isNaN(topBar) ? 0 : topBar;
		wpBar = isNaN(wpBar) ? 0 : wpBar;

		let headerHeight = siteHeader + topBar + wpBar;

		$(':root').css('--header-height', Math.ceil(headerHeight) + 'px');
	}

	headerHeightCalc();
});

// Footer widget areas - count number of widget areas and add class.
jQuery(document).ready(function ($) {
	let footerWidgetArea = $('.site-footer__widgets > li');
	$('.site-footer__widgets').addClass('widget-areas-' + footerWidgetArea.length);
});

// View Select
jQuery(document).ready(function ($) {
	function viewSelectGroups() {
		let groupIdentifier = 'grouped-'
		let $members = $('section[id^='+groupIdentifier+']');
		let groupStatus = 3;
		let $group = $([]);
	  
		$members.each(function(index, element) {
			let $currentMember = $(element);
			let $nextSections = $currentMember.nextAll('section');
			let $nextSection = $nextSections.length != 0 ? $nextSections.first() : $([]);

			//groupstatuses
			//1 = first item in group
			//2 = in group
			//3 = last item in group (or starting loop)

			//set current iteration groupstatuses based on previous group status
			if ($nextSection.length != 0 && $nextSection.attr('id') && $nextSection.attr('id').startsWith(groupIdentifier)) {
				if (groupStatus == 3) {
					groupStatus = 1;
				}else if (groupStatus == 1) {
					groupStatus = 2;
				}
			}else if (groupStatus != 3) {
				groupStatus = 3;
			}else {
				return false;
			}

			//clear the group if starting a new group, then add this to the group
			if (groupStatus == 1) {
				$group = $([]);
			} else {
				$currentMember.addClass('hidden');
			}
			$currentMember.attr('layout', $currentMember.attr('id'));
			$group = $group.add($currentMember);

			//if ending a group, wrap the group with appropriate html
			if (groupStatus == 3) {
				var $groupWrapper = $('<div class="view-select-container"></div>');
				var $btnWrapper = $('<div class="layout-btn-group"></div>');
				var groupHeading = '';
				var groupSubHeading = '';

				$group.each(function(index, element) {
					let $currentMember = $(element);
					let currentMemberLabels = $currentMember.attr('id').split('-');
					let currentMemberLabel = currentMemberLabels.length > 1 ? currentMemberLabels[1].replaceAll('_', ' ') : 'select';
					groupHeading = currentMemberLabels.length > 2 ? '<h2 class="flex-layout__heading gutter vertical-spacing center">'+currentMemberLabels[2].replaceAll('_', ' ')+'</h2>' : groupHeading;
					groupSubHeading = currentMemberLabels.length > 3 ? '<h3 class="button-action-text gutter center">'+currentMemberLabels[3].replaceAll('_', ' ')+'</h3>' : groupSubHeading;
					let active = '';

					if (index == 0) {
						active ='active';
					}
					
					let innerContent = '<button class="btn '+active+'" layout="'+$currentMember.attr('id')+'">'+currentMemberLabel+'</button>';
					$btnWrapper.append(innerContent);
				});

				//wrap and bundle it all together
				$group.wrapAll($groupWrapper).parent().prepend($btnWrapper).prepend(groupSubHeading).prepend(groupHeading);
			}
		});
	}  
	viewSelectGroups();
	
	let viewSelectContainer = $('.view-select-container');
	viewSelectContainer.each(function() {
		let $this = $(this);
		let layoutBtn = $this.find('.layout-btn-group button');

		layoutBtn.on('click', function() {
			let $this = $(this);
			let btnVal = $this.attr('layout');
			let layoutSection = $this.parents('.view-select-container').find('> section');
			let targetSection = $this.parents('.view-select-container').find('> section[layout=' + btnVal + ']');
	
			$this.parents('.layout-btn-group').find('.btn').removeClass('active');
			$this.toggleClass('active');
	
			layoutSection.not('.hidden').toggleClass('hidden');
			targetSection.toggleClass('hidden');
		});

	});
});


// Debugger Injections
jQuery(function() {
	if (jQuery('body').hasClass('debug-mode')) {
		jQuery('main img:is(:not([alt]), [alt=""]), header img:is(:not([alt]), [alt=""]), footer img:is(:not([alt]), [alt=""])').each(function () {
			jQuery(this).wrap('<div class="debug-flag image missing-alt"> </div>');
		});
		jQuery('main a:is(:not([alt]), [alt=""]), header a:is(:not([alt]), [alt=""]), footer a:is(:not([alt]), [alt=""])').each(function () {
			jQuery(this).wrap('<div class="debug-flag link missing-alt"> </div>');
		});
		jQuery('main a:is(:not([href]), [href=""], [href="#"]), header a:is(:not([href]), [href=""], [href="#"]), footer a:is(:not([href]), [href=""], [href="#"])').each(function () {
			jQuery(this).wrap('<div class="debug-flag link missing-href"> </div>');
		});
	}
});
