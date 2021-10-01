/* =======================================
   DRAG-SCROLL FOR LIST TABLES
   ======================================= */

/**
 * Third party plugins
 */
import dragscroll from '../../../vendor/dragscroll';             // A patched fork of dragscroll
import Hammer from 'hammerjs/hammer.min';                        // From node_modules

import Globals from './_globals';
import TableCellPopovers from '../_table-cell-popovers';
import Tooltip from '../_tooltip';
import Utils from '../../utils/_utils';
import WPHooks from '../../interfaces/wp.hooks';

export default class DragScroll {

	wpHooks: WPHooks = window['wp']['hooks']; // WP hooks.
	
	constructor(
		private globals: Globals,
		private tooltip: Tooltip,
		private popover?: TableCellPopovers
	) {
		
		// Add horizontal drag-scroll to table filters.
		this.initHorizontalDragScroll();

		this.addHooks();
	
	}

	/**
	 * Add hooks
	 */
	addHooks() {

		// Load Hammer for table dragging functionality.
		this.wpHooks.addAction( 'atum_scrollBar_loaded', 'atum', () => this.loadHammer() );

		// Re-add the horizontal drag-scroll when the List Table is updated.
		this.wpHooks.addAction( 'atum_listTable_tableUpdated', 'atum', () => this.initHorizontalDragScroll() );

	}

	/**
	 * Load Hammer
	 */
	loadHammer() {
		
		// Drag and drop scrolling on desktops.
		const hammertime: any = new Hammer( this.globals.$scrollPane.get( 0 ), {} );
		
		hammertime

			.on( 'panstart', () => {
				// As the popoover is not being repositioned when scrolling horizontally, we have to destroy it.
				if ( this.popover ) {
					this.popover.destroyPopover();
				}
			} )
			
			// Horizontal drag scroll (JScrollPane).
			.on( 'panright panleft', ( evt: any ) => {

				const velocityModifier: number = 10,
				      displacement: number     = this.globals.jScrollApi.getContentPositionX() - ( evt.distance * ( evt.velocityX / velocityModifier ) );

				this.globals.jScrollApi.scrollToX( displacement, false );

			} )
			
			// Vertical drag scroll (browser scroll bar).
			.on( 'panup pandown', ( evt: any ) => {

				const velocityModifier: number = 10,
				      displacement: number     = $( window ).scrollTop() - ( evt.distance * ( evt.velocityY / velocityModifier ) );

				$( window ).scrollTop( displacement );

			} );
		
	}
	
	/**
	 * Init horizontal scroll
	 */
	initHorizontalDragScroll() {

		const $navScrollContainers: JQuery = $( '.nav-with-scroll-effect' );

		$navScrollContainers.each( ( index: number, elem: Element ) => {
			this.addHorizontalDragScroll( $( elem ) );
		} );


		$( window ).on( 'resize', () => {

			$navScrollContainers.each( ( index: number, elem: Element ) => {
				this.addHorizontalDragScroll( $( elem ) );
			} );

		} );

		$( '.tablenav.top' ).find( 'input.btn' ).css( 'visibility', 'visible' );

		$navScrollContainers.css( 'visibility', 'visible' ).on( 'scroll', ( evt: JQueryEventObject ) => {

			this.addHorizontalDragScroll( $( evt.currentTarget ), true );
			this.tooltip.destroyTooltips();

			Utils.delay( () => this.tooltip.addTooltips(), 1000 );

		} );

		dragscroll.reset();

	}
	
	/**
	 * Add horizontal scroll effect to menu views
	 *
	 * @param {JQuery}  $nav
	 * @param {boolean} checkEnhanced
	 */
	addHorizontalDragScroll( $nav: JQuery, checkEnhanced: boolean = false ) {

		if ( ! $nav.length ) {
			return;
		}

		let $overflowOpacityRight: JQuery = $nav.find( '.overflow-opacity-effect-right' ),
		    $overflowOpacityLeft: JQuery  = $nav.find( '.overflow-opacity-effect-left' ),
		    leftMax: number               = $nav ? $nav.get( 0 ).scrollWidth : 0,
		    left: number                  = $nav ? $nav.get( 0 ).scrollLeft : 0,
		    diff: number                  = leftMax - left;

		if ( checkEnhanced ) {
			( <any> $( '.enhanced' ) ).select2( 'close' );
		}

		if ( diff === $nav.outerWidth() ) {
			$overflowOpacityRight.hide();
		}
		else {
			$overflowOpacityRight.show();
		}

		if ( left === 0 ) {
			$overflowOpacityLeft.hide();
		}
		else {
			$overflowOpacityLeft.show();
		}

		$nav.css( 'cursor', $overflowOpacityLeft.is( ':visible' ) || $overflowOpacityRight.is( ':visible' ) ? 'grab' : 'auto' );
		
	}
	
}
