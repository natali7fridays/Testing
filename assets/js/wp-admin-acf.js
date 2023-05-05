( function ( $ ) {
	// Generate title for repeater accordion field wrapper from text field inside row.
	$( document ).ready(function() {

		dynamic_title_repeater_accordion('accordion', 'summary');
		dynamic_title_repeater_accordion('tabbed_content', 'summary');
		dynamic_title_repeater_accordion('cards', 'heading');
		dynamic_title_repeater_accordion('offers', 'heading');
		dynamic_title_repeater_accordion('testimonials', 'name');

	});

	function dynamic_title_repeater_accordion(repeater_name, field_name) {
		var information_tabs = $("div[data-name='" + repeater_name + "']");
		if (information_tabs.length) {
			var selector = "tr:not(.acf-clone) td.acf-fields .acf-accordion-content div[data-name='" + field_name + "'] input";

			// add lister
			$(information_tabs).on('input', selector, function() {
				var me = $(this);
				me.closest('td.acf-fields').find('.acf-accordion-title label').text(me.val());
			});

			// trigger the function on load
			information_tabs.find(selector).trigger('input');

		}
	}

	// Flex field title.
	$('.layout').each( function() {
		let $layoutTitle  = $(this).find('.acf-fc-layout-title');
		let $layoutTitleB = $(this).find('.acf-fc-layout-title b');
		let $titleField   = $(this).find('.flex-widget-title input');
		let $layoutHandle = $(this).find('.acf-fc-layout-handle');

		$($titleField).on('keyup', function() {
			$layoutTitle.html( '<b>' + $titleField.val() + '</b>' );
		});

	});

	// Theme color input previews
	let themeColor = $('.theme-color-preview'); 
	let colorInput = $('.acf-input input');
	let colorPrev = '<span class="acf-input-preview"></span>';

	$(themeColor).each(function() {
		$(this).find('.acf-input-wrap').append(colorPrev);

		$(this).find('.acf-input-preview').css('background-color', $(this).find(colorInput).val() );

		$(this).find(colorInput).on('change keyup input', function() {
			$(this).next('.acf-input-preview').css('background-color', $(this).val() );
		});
	});

	// Widget background colors
	$(document).ready(function() {
		let currentColorContainer = '<span class="current-bg-color"></span>';

		$('.acf-field-613a78eda1d47 .bg-color-palette').each(function() {
			let $this = $(this);
			$this.find('.acf-label').append(currentColorContainer);

			function setBgColor() {
				let currentBgColor = $this.find('.selected input').css("background-color");
				$this.find('.current-bg-color').css("background-color", currentBgColor);
			}

			setBgColor();
			$this.find('.acf-radio-list').on('change', setBgColor);
		});
	});


} )( jQuery );