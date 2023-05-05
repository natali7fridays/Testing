( function( $, api ) {

	api.controlConstructor['adapt_dev-toggle'] = api.Control.extend( {

		ready: function() {
			var control = this;

			this.container.on( 'change', 'input:checkbox', function() {
				control.container
					.find('.adapt_dev-customize-toggle')
					.toggleClass('is-checked');

				let value = this.value ? '' : 1;
				this.value = value;

				let checked = (value > 0);
				if (checked) {
					this.setAttribute('checked', 'checked');

					control.container
						.find('.adapt_dev-customize-toggle__on')
						.remove();

					control.container
						.find('.adapt_dev-customize-toggle')
						.append('<svg class="adapt_dev-customize-toggle__off" width="2" height="6" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 2 6"><path d="M0 0h2v6H0z"></path></svg>');
				} else {
					this.removeAttribute('checked');

					control.container
						.find('.adapt_dev-customize-toggle__off')
						.remove();
					control.container
						.find('.adapt_dev-customize-toggle')
						.append('<svg class="adapt_dev-customize-toggle__on" width="6" height="6" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 6 6"><path d="M3 1.5c.8 0 1.5.7 1.5 1.5S3.8 4.5 3 4.5 1.5 3.8 1.5 3 2.2 1.5 3 1.5M3 0C1.3 0 0 1.3 0 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"></path></svg>');
				}
			});

		}
   
	});

} )( jQuery, wp.customize );