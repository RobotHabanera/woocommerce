/* global: Moderniz */
'use strict';

import $ from 'jquery';
import ClickableAttrSelector from './clickable-attr-selector';
import changeProductFilterResultPageHeaderElementsPosition from './wpf-product-filter';

/**
 * Initialize all WooCommerce changes.
 */
const initWooCommerceChanges = () => {
	changeCartCouponNoticePositionOnMobile();
	initializeSpinnerControlForQuantity();
	initFloatingLabels();
	activeSingleProductThumbnail();

	if ( WoonderShopVars.skin && 'jungle' === WoonderShopVars.skin ) {
		/**
		 * Init clickable attribute selector on single product page
		 */
		$( 'body' ).on( 'wc_variation_form', 'form.variations_form', ( ev ) => {
			new ClickableAttrSelector( $( ev.currentTarget ) );
		} );

		/**
		 * Reposition the product filter result page header/title area elements.
		 */
		$( window ).on( 'wpf_ajax_success', function() {
			changeProductFilterResultPageHeaderElementsPosition();
		} );
	}
};

/**
 * Change the cart coupon code notice location.
 */
function changeCartCouponNoticePositionOnMobile() {
	// Skip, if this is not the cart page.
	if ( ! $( document.body ).hasClass( 'woocommerce-cart' ) ) {
		return;
	}

	// Add the class and close button to the coupon notifications.
	$( document.body ).on( 'applied_coupon', function() {
		if ( !! Modernizr && Modernizr.mq( '(max-width: 991px)' ) ) {
			const $notifications = $( '.woocommerce-cart-form' ).siblings( '.woocommerce-error, .woocommerce-message, .woocommerce-info' );

			$notifications
				.addClass( 'ws-woocommerce-coupon-code-notification' )
				.append( '<a href="#" class="ws-woocommerce-coupon-code-notification__close js-ws-remove-notification"><i class="fa fa-times" aria-hidden="true"></i></a>' );

			// Remove the notice after 4 seconds.
			setTimeout( function() {
				$notifications.fadeOut( 300, function() {
					$notifications.remove();
				} );
			}, 4000 );
		}
	} );

	// Register click event on close notification link.
	$( document.body ).on( 'click', '.js-ws-remove-notification', function( event ) {
		event.preventDefault();

		$( this ).parent().remove();
	} );
}

/**
 * Spinner widget for WooCommerce quantity inputs.
 *
 * https://jqueryui.com/spinner/
 */
function initializeSpinnerControlForQuantity() {
	// Extend spinner.
	if ( $.isFunction( $.fn.spinner ) ) {
		$.widget( "ui.spinner", $.ui.spinner, {
			_buttonHtml: function() {
				return `
					<a class="ui-spinner-button ui-spinner-down ui-corner-br ui-button ui-widget ui-state-default ui-button-text-only" tabindex="-1" role="button">
						<span class="ui-icon"><i class='fas fa-minus'></i></span>
					</a>
					<a class="ui-spinner-button ui-spinner-up ui-corner-tr ui-button ui-widget ui-state-default ui-button-text-only" tabindex="-1" role="button">
						<span class="ui-icon"><i class='fas fa-plus'></i></span>
					</a>`;
			},
		} );
	}

	// Initialze the spinner on load.
	initSpinner();

	// Re-initialze the spinner on WooCommerce cart refresh.
	$( document.body ).on( 'updated_cart_totals', function() {
		initSpinner();
	} );

	// Trigger quantity input when plus/minus buttons are clicked.
	$( document ).on( 'click', '.ui-spinner-button', () => {
		$( '.ui-spinner-input' ).trigger( 'change' );
	} );
}

/**
 * Helper function to initialize the spinner quantity control.
 */
function initSpinner() {
	if ( $.isFunction( $.fn.spinner ) ) {
		$( '.qty' ).spinner();
	}
}

/**
 * Initialize the Floating labels, if they are enqueued.
 */
function initFloatingLabels() {
	$( document ).on( 'ready', function() {
		if ( 'undefined' !== typeof FloatLabels ) {
			new FloatLabels( '.js-ws-floating-labels', { prioritize: 'placeholder' } );
		}
	} );
}

/**
 * Add class to active single product WooCommerce thumbnail.
 */
function activeSingleProductThumbnail() {
	$( () => {
		$( '.flex-active' ).parent().addClass( 'flex-active-container' );
	} );

	$( document ).on( 'click', '.flex-control-thumbs img', function() {
		$( '.flex-control-thumbs li' ).removeClass( 'flex-active-container' );
		$( '.flex-active' ).parent().addClass( 'flex-active-container' );
	} );

	/**
	 * Fix for gallery navigation with keyboard (left/right).
	 * There is no trigger for the gallery keyboard navigation in
	 * WooCommerce: assets/js/flexslider/jquery.flexslider.js
	 */
	if ( $( document.body ).hasClass( 'single-product' ) ) {
		$( document ).on( 'keyup', function( event ) {
			if ( 37 === event.keyCode || 39 === event.keyCode ) {
				$( '.flex-control-thumbs li' ).removeClass( 'flex-active-container' );
				setTimeout( function() {
					$( '.flex-active' ).parent().addClass( 'flex-active-container' );
				}, 10 );
			}
		} );
	}
}

/**
 * Initialize WooCommerce changes.
 */
initWooCommerceChanges();
