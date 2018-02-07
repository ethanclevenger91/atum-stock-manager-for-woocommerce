<?php
/**
 * View for the Dashboard page
 *
 * @since 1.3.9
 */

defined( 'ABSPATH' ) or die;
?>
<div class="atum-dashboard">

	<section class="dash-header">

		<div class="dash-header-buttons">
			<!--<a href="#" target="_blank" type="button" class="btn btn-success pill"><?php _e('Upgrade Now', ATUM_TEXT_DOMAIN) ?></a>-->
			<a href="https://stockmanagementlabs.ticksy.com/" target="_blank" class="btn btn-primary pill"><?php _e('Get Support', ATUM_TEXT_DOMAIN) ?></a>
		</div>

		<div class="dash-header-logo">
			<img src="<?php echo ATUM_URL ?>assets/images/dashboard/header-logo.svg" alt="ATUM">
			<h3><?php _e('Inventory Management for WooCommerce', ATUM_TEXT_DOMAIN) ?></h3>
		</div>

		<div class="dash-header-notice">
			<span><?php _e('HELP US TO IMPROVE!', ATUM_TEXT_DOMAIN) ?></span>
			<?php printf( __( 'If you like <strong>ATUM</strong> please leave us a %s&#9733;&#9733;&#9733;&#9733;&#9733;%s rating. Huge thanks in advance!', ATUM_TEXT_DOMAIN ), '<a href="https://wordpress.org/support/plugin/atum-stock-manager-for-woocommerce/reviews/?filter=5#new-post" target="_blank" class="wc-rating-link" data-rated="' . esc_attr__( 'Thanks :)', ATUM_TEXT_DOMAIN ) . '">', '</a>' ); ?>
		</div>
	</section>

	<section class="dash-cards">

		<div class="dash-card docs">

			<div class="card-content">
				<h5><?php _e('Documentation', ATUM_TEXT_DOMAIN) ?></h5>
				<h2><?php _e('Complete Tutorials', ATUM_TEXT_DOMAIN) ?></h2>

				<p><?php _e("Our team is working daily to document ATUM's fast-growing content. Browse our detailed tutorials, ask questions or share feature requests with our team.", ATUM_TEXT_DOMAIN) ?></p>

				<a href="#" class="btn btn-primary pill"><?php _e('View Tutorials', ATUM_TEXT_DOMAIN) ?></a>
			</div>

			<div class="card-img">
				<img src="<?php echo ATUM_URL ?>assets/images/dashboard/card-docs-img.png">
			</div>

		</div>

		<div class="dash-card add-ons">

			<div class="card-content">
				<h5><?php _e('Add-ons', ATUM_TEXT_DOMAIN) ?></h5>
				<h2><?php _e('Endless Possibilities', ATUM_TEXT_DOMAIN) ?></h2>

				<p><?php _e('Expand your inventory control with our premium add-ons. No storage is left unattended, no item uncounted and no production line inefficient.', ATUM_TEXT_DOMAIN) ?></p>

				<a href="https://www.stockmanagementlabs.com/addons/" class="btn btn-success pill"><?php _e('View Add-ons', ATUM_TEXT_DOMAIN) ?></a>
			</div>

			<div class="card-img">
				<img src="<?php echo ATUM_URL ?>assets/images/dashboard/card-add-ons-img.png">
			</div>

		</div>

		<div class="dash-card subscription">

			<div class="card-content">
				<h5><?php _e('Newsletter', ATUM_TEXT_DOMAIN) ?></h5>
				<h2><?php _e('Earn Regular Rewards', ATUM_TEXT_DOMAIN) ?></h2>

				<p><?php _e('Thank you very much for choosing ATUM as your inventory manager. Please, subscribe to receive news and updates and earn regular rewards.', ATUM_TEXT_DOMAIN) ?></p>
			</div>

			<div class="card-img">
				<img src="<?php echo ATUM_URL ?>assets/images/dashboard/card-subscription-img.png">
			</div>

			<form action="">
				<div class="input-group">
					<input type="email" name="email" id="email" placeholder="<?php esc_attr_e('Enter your email address', ATUM_TEXT_DOMAIN) ?>">
					<button type="submit" class="btn btn-warning pill"><?php _e('Subscribe', ATUM_TEXT_DOMAIN) ?></button>
				</div>
			</form>

		</div>

	</section>

	<section class="atum-widgets" data-nonce="<?php echo wp_create_nonce('atum-dashboard-widgets') ?>">
		<div class="grid-stack">

			<?php if ( ! empty($layout) && is_array($layout) ):

				foreach ($layout as $widget_id => $widget_layout):

					if ( isset( $widgets[$widget_id] ) ):

						/**
						 * @var \Atum\Components\AtumWidget $widget
						 */
						$widget = $widgets[$widget_id];

						$grid_item_defaults = (array) apply_filters( 'atum/dashboard/grid_item_defaults', array(
							'id'         => $widget_id,
							'min-width'  => 3,
							'min-height' => 2,
							'max-width'  => 12
						) );

						$widget_layout = array_merge($grid_item_defaults, $widget_layout); ?>

						<div class="atum-widget <?php echo $widget_id ?> grid-stack-item"<?php array_walk( $widget_layout, function($value, $key){ echo " data-gs-$key='$value'"; } ) ?>>

							<div class="widget-wrapper grid-stack-item-content">
								<div class="widget-header">
									<h2><?php echo $widget->get_title() ?></h2>

									<span class="controls">
										<i class="lnr lnr-cog widget-settings" title="<?php _e('Widget Settings', ATUM_TEXT_DOMAIN) ?>"></i>
										<i class="lnr lnr-cross widget-close" title="<?php _e('Close', ATUM_TEXT_DOMAIN) ?>"></i>
									</span>
								</div>

								<div class="widget-body">
									<?php $widget->render(); ?>
								</div>
							</div>

						</div>

					<?php endif;

				endforeach;

			endif; ?>

		</div>
	</section>

	<section class="add-dash-widget">
		<i class="lnr lnr-plus-circle"></i> <h2><?php _e('Add Widget here', ATUM_TEXT_DOMAIN) ?></h2>
	</section>

</div>