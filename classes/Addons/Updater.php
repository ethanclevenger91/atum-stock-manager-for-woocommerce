<?php
/**
 * @package         Atum
 * @subpackage      Addons
 * @author          Salva Machí and Jose Piera - https://sispixels.com
 * @copyright       (c)2017 Stock Management Labs
 *
 * @since           1.2.0
 *
 * ATUM add-ons' updater and installer
 */

namespace Atum\Addons;

defined( 'ABSPATH' ) or die;


class Updater {

	/**
	 * The ATUM's API URL
	 * @var string
	 */
	private $api_url = '';

	/**
	 * The data passed in the API request
	 * @var array
	 */
	private $api_data = array();

	/**
	 * The addon's directory name
	 * @var string
	 */
	private $name = '';

	/**
	 * The addon's slug
	 * @var string
	 */
	private $slug = '';

	/**
	 * The current version of the installed addon
	 * @var string
	 */
	private $version = '';

	/**
	 * Whether to force an API request instead of getting the cached info
	 * @var bool
	 */
	private $wp_override = FALSE;

	/**
	 * The key used for caching the data retrieved by the API
	 * @var string
	 */
	private $cache_key = '';


	/**
	 * Constructor
	 *
	 * @since 1.2.0
	 *
	 * @param string $addon_file    Path to the plugin file
	 * @param array  $api_data      Optional. Data to send with API calls
	 */
	public function __construct( $addon_file, $api_data = array() ) {

		global $edd_plugin_data;

		$this->api_url     = Addons::ADDONS_STORE_URL;
		$this->api_data    = $api_data;
		$this->name        = plugin_basename( $addon_file );
		$this->slug        = basename( $addon_file, '.php' );
		$this->version     = $api_data['version'];
		$this->wp_override = isset( $api_data['wp_override'] ) ? (bool) $api_data['wp_override'] : FALSE;
		$this->beta        = ! empty( $this->api_data['beta'] ) ? TRUE : FALSE;
		$this->cache_key   = md5( serialize( $this->slug . $this->api_data['license'] . $this->beta ) );

		$edd_plugin_data[ $this->slug ] = $this->api_data;

		// Set up hooks
		$this->init();

	}

	/**
	 * Set up WordPress filters and actions to hook into WP's update process
	 *
	 * @since 1.2.0
	 */
	public function init() {

		add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_update' ) );
		add_filter( 'plugins_api', array( $this, 'plugins_api_filter' ), 10, 3 );
		remove_action( 'after_plugin_row_' . $this->name, 'wp_plugin_update_row', 10 );
		add_action( 'after_plugin_row_' . $this->name, array( $this, 'show_update_notification' ), 10, 2 );
		add_action( 'admin_init', array( $this, 'show_changelog' ) );

	}

	/**
	 * Check for Updates at the defined API endpoint and modify the update array.
	 *
	 * This function dives into the update API just when WordPress creates its update array,
	 * then adds a custom API call and injects the custom plugin data retrieved from the API.
	 * It is reassembled from parts of the native WordPress plugin update code.
	 * See wp-includes/update.php line 121 for the original wp_update_plugins() function.
	 *
	 * @since 1.2.0
	 *
	 * @param array  $_transient_data Update array build by WordPress
	 * @return array Modified update array with custom plugin data
	 */
	public function check_update( $_transient_data ) {

		global $pagenow;

		if ( ! is_object( $_transient_data ) ) {
			$_transient_data = new stdClass;
		}

		if ( 'plugins.php' == $pagenow && is_multisite() ) {
			return $_transient_data;
		}

		if ( ! empty( $_transient_data->response ) && ! empty( $_transient_data->response[ $this->name ] ) && FALSE === $this->wp_override ) {
			return $_transient_data;
		}

		$version_info = $this->get_cached_version_info();

		if ( FALSE === $version_info ) {
			$version_info = $this->api_request( array( 'slug' => $this->slug, 'beta' => $this->beta ) );

			$this->set_version_info_cache( $version_info );

		}

		if ( FALSE !== $version_info && is_object( $version_info ) && isset( $version_info->new_version ) ) {

			if ( version_compare( $this->version, $version_info->new_version, '<' ) ) {
				$_transient_data->response[ $this->name ] = $version_info;
			}

			$_transient_data->last_checked           = current_time( 'timestamp' );
			$_transient_data->checked[ $this->name ] = $this->version;

		}

		return $_transient_data;

	}

	/**
	 * Shows update nofication row -- needed for multisite subsites, because WP won't tell you otherwise!
	 *
	 * @since 1.2.0
	 *
	 * @param string  $file
	 * @param array   $plugin
	 */
	public function show_update_notification( $file, $plugin ) {

		if ( is_network_admin() ) {
			return;
		}

		if( ! current_user_can( 'update_plugins' ) ) {
			return;
		}

		if( ! is_multisite() ) {
			return;
		}

		if ( $this->name != $file ) {
			return;
		}

		// Remove our filter on the site transient
		remove_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_update' ), 10 );

		$update_cache = get_site_transient( 'update_plugins' );

		$update_cache = is_object( $update_cache ) ? $update_cache : new stdClass();

		if ( empty( $update_cache->response ) || empty( $update_cache->response[ $this->name ] ) ) {

			$version_info = $this->get_cached_version_info();

			if ( FALSE === $version_info ) {
				$version_info = $this->api_request( array( 'slug' => $this->slug, 'beta' => $this->beta ) );

				$this->set_version_info_cache( $version_info );
			}

			if ( ! is_object( $version_info ) ) {
				return;
			}

			if ( version_compare( $this->version, $version_info->new_version, '<' ) ) {
				$update_cache->response[ $this->name ] = $version_info;
			}

			$update_cache->last_checked = current_time( 'timestamp' );
			$update_cache->checked[ $this->name ] = $this->version;

			set_site_transient( 'update_plugins', $update_cache );

		}
		else {
			$version_info = $update_cache->response[ $this->name ];
		}

		// Restore our filter
		add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_update' ) );

		if ( ! empty( $update_cache->response[ $this->name ] ) && version_compare( $this->version, $version_info->new_version, '<' ) ) {

			// build a plugin list row, with update notification
			$wp_list_table = _get_list_table( 'WP_Plugins_List_Table' );
			# <tr class="plugin-update-tr"><td colspan="' . $wp_list_table->get_column_count() . '" class="plugin-update colspanchange">
			echo '<tr class="plugin-update-tr" id="' . $this->slug . '-update" data-slug="' . $this->slug . '" data-plugin="' . $this->slug . '/' . $file . '">';
			echo '<td colspan="3" class="plugin-update colspanchange">';
			echo '<div class="update-message notice inline notice-warning notice-alt">';

			$changelog_link = self_admin_url( 'index.php?edd_sl_action=view_plugin_changelog&plugin=' . $this->name . '&slug=' . $this->slug . '&TB_iframe=true&width=772&height=911' );

			if ( empty( $version_info->download_link ) ) {

				printf(
					__( 'There is a new version of %1$s available. %2$sView version %3$s details%4$s.', ATUM_TEXT_DOMAIN ),
					esc_html( $version_info->name ),
					'<a target="_blank" class="thickbox" href="' . esc_url( $changelog_link ) . '">',
					esc_html( $version_info->new_version ),
					'</a>'
				);

			}
			else {

				printf(
					__( 'There is a new version of %1$s available. %2$sView version %3$s details%4$s or %5$supdate now%6$s.', ATUM_TEXT_DOMAIN ),
					esc_html( $version_info->name ),
					'<a target="_blank" class="thickbox" href="' . esc_url( $changelog_link ) . '">',
					esc_html( $version_info->new_version ),
					'</a>',
					'<a href="' . esc_url( wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $this->name, 'upgrade-plugin_' . $this->name ) ) .'">',
					'</a>'
				);

			}

			do_action( "in_plugin_update_message-{$file}", $plugin, $version_info );

			echo '</div></td></tr>';

		}

	}

	/**
	 * Updates information on the "View version x.x details" page with custom data.
	 *
	 * @since 1.2.0
	 *
	 * @param mixed   $_data
	 * @param string  $_action
	 * @param object  $_args
	 *
	 * @return object $_data
	 */
	public function plugins_api_filter( $_data, $_action = '', $_args = null ) {

		if ( $_action != 'plugin_information' ) {
			return $_data;
		}

		if ( ! isset( $_args->slug ) || ( $_args->slug != $this->slug ) ) {
			return $_data;
		}

		$to_send = array(
			'slug'   => $this->slug,
			'is_ssl' => is_ssl(),
			'fields' => array(
				'banners' => array(),
				'reviews' => FALSE
			)
		);

		$cache_key = ATUM_PREFIX . 'api_request_' . md5( serialize( $this->slug . $this->api_data['license'] . $this->beta ) );

		// Get the transient where we store the api request for this plugin for 24 hours
		$api_request_transient = $this->get_cached_version_info( $cache_key );

		// If we have no transient-saved value, run the API, set a fresh transient with the API value, and return that value too right now.
		if ( empty( $api_request_transient ) ) {

			$api_response = $this->api_request($to_send);

			// Expires in 3 hours
			$this->set_version_info_cache( $api_response, $cache_key );

			if ( FALSE !== $api_response ) {
				$_data = $api_response;
			}

		}
		else {
			$_data = $api_request_transient;
		}

		// Convert sections into an associative array, since we're getting an object, but Core expects an array.
		if ( isset( $_data->sections ) && ! is_array( $_data->sections ) ) {
			$new_sections = array();
			foreach ( $_data->sections as $key => $key ) {
				$new_sections[ $key ] = $key;
			}

			$_data->sections = $new_sections;
		}

		// Convert banners into an associative array, since we're getting an object, but Core expects an array.
		if ( isset( $_data->banners ) && ! is_array( $_data->banners ) ) {
			$new_banners = array();
			foreach ( $_data->banners as $key => $key ) {
				$new_banners[ $key ] = $key;
			}

			$_data->banners = $new_banners;
		}

		return $_data;

	}

	/**
	 * Calls the API and, if successfull, returns the object delivered
	 *
	 * @since 1.2.0
	 *
	 * @param array   $data   Parameters for the API action.
	 *
	 * @return bool|object
	 */
	private function api_request( $data ) {

		$data = array_merge( $this->api_data, $data );

		if ( $data['slug'] != $this->slug ) {
			return;
		}

		// Don't allow a plugin to ping itself
		if( $this->api_url == trailingslashit( home_url() ) ) {
			return FALSE;
		}

		if ( empty( $data['item_name'] ) || empty( $data['license'] ) ) {
			return FALSE;
		}

		$version = isset( $data['version'] ) ? $data['version'] : FALSE;
		$request = Addons::get_version( $data['item_name'], $data['license'], $version, ! empty( $data['beta'] ) );

		if ( ! is_wp_error( $request ) ) {
			$request = json_decode( wp_remote_retrieve_body( $request ) );
		}

		if ( $request && isset( $request->sections ) ) {
			$request->sections = maybe_unserialize( $request->sections );
		}
		else {
			$request = false;
		}

		if ( $request && isset( $request->banners ) ) {
			$request->banners = maybe_unserialize( $request->banners );
		}

		if( ! empty( $request ) ) {
			foreach( $request->sections as $key => $section ) {
				$request->$key = (array) $section;
			}
		}

		return $request;

	}

	/**
	 * Show the changelog on the update popup
	 *
	 * @since 1.2.0
	 */
	public function show_changelog() {

		global $edd_plugin_data;

		if( empty( $_REQUEST['edd_sl_action'] ) || 'view_plugin_changelog' != $_REQUEST['edd_sl_action'] ) {
			return;
		}

		if( empty( $_REQUEST['plugin'] ) || empty( $_REQUEST['slug'] ) ) {
			return;
		}

		if( ! current_user_can( 'update_plugins' ) ) {
			wp_die( __( 'You do not have permission to install plugin updates', ATUM_TEXT_DOMAIN ), __( 'Error', ATUM_TEXT_DOMAIN ), array( 'response' => 403 ) );
		}

		$data         = $edd_plugin_data[ $_REQUEST['slug'] ];
		$beta         = ! empty( $data['beta'] ) ? TRUE : FALSE;
		$cache_key    = md5( ATUM_PREFIX . 'plugin_' . sanitize_key( $_REQUEST['plugin'] ) . '_' . $beta . '_version_info' );
		$version_info = $this->get_cached_version_info( $cache_key );

		if( FALSE === $version_info ) {

			$version = isset( $data['version'] ) ? $data['version'] : FALSE;
			$request = Addons::get_version( $data['item_name'], $data['license'], $version, ! empty( $data['beta'] ) );

			if ( ! is_wp_error( $request ) ) {
				$version_info = json_decode( wp_remote_retrieve_body( $request ) );
			}

			if ( ! empty( $version_info ) && isset( $version_info->sections ) ) {
				$version_info->sections = maybe_unserialize( $version_info->sections );
			}
			else {
				$version_info = false;
			}

			if( ! empty( $version_info ) ) {
				foreach( $version_info->sections as $key => $section ) {
					$version_info->$key = (array) $section;
				}
			}

			$this->set_version_info_cache( $version_info, $cache_key );

		}

		if( ! empty( $version_info ) && isset( $version_info->sections['changelog'] ) ) {
			echo '<div style="background:#fff;padding:10px;">' . $version_info->sections['changelog'] . '</div>';
		}

		exit;

	}

	/**
	 * Get the addon's version info previously cached
	 *
	 * @since 1.2.0
	 *
	 * @param string $cache_key
	 *
	 * @return array|bool|mixed|object
	 */
	public function get_cached_version_info( $cache_key = '' ) {

		if( empty( $cache_key ) ) {
			$cache_key = $this->cache_key;
		}

		$cache = get_option( $cache_key );

		if( empty( $cache['timeout'] ) || current_time( 'timestamp' ) > $cache['timeout'] ) {
			return FALSE; // Cache has expired
		}

		return json_decode( $cache['value'] );

	}

	/**
	 * Save the addon's version info in cache
	 *
	 * @since 1.2.0
	 *
	 * @param string $value
	 * @param string $cache_key
	 */
	public function set_version_info_cache( $value = '', $cache_key = '' ) {

		if( empty( $cache_key ) ) {
			$cache_key = $this->cache_key;
		}

		$data = array(
			'timeout' => strtotime( '+3 hours', current_time( 'timestamp' ) ),
			'value'   => json_encode( $value )
		);

		update_option( $cache_key, $data );

	}

}