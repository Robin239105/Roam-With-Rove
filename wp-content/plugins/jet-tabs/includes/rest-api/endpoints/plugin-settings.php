<?php
namespace Jet_Tabs\Endpoints;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Define Posts class
 */
class Plugin_Settings extends Base {

	/**
	 * [get_method description]
	 * @return [type] [description]
	 */
	public function get_method() {
		return 'POST';
	}

	/**
	 * Returns route name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'plugin-settings';
	}

	/**
	 * [callback description]
	 * @param  [type]   $request [description]
	 * @return function          [description]
	 */
	public function callback( $request ) {

		$data = $request->get_params();

		$current = get_option( jet_tabs_settings()->key, array() );

		if ( is_wp_error( $current ) ) {
			return rest_ensure_response( [
				'status'  => 'error',
				'message' => __( 'Server Error', 'jet-tabs' ),
			] );
		}
		$messages = [ __( 'Settings have been saved', 'jet-tabs' ) ];
		$current_cache_expiration = isset( $current['useTemplateCache'] ) ? $current['useTemplateCache']['cacheExpiration'] : 'week';

		foreach ( $data as $key => $value ) {
			$current[ $key ] = is_array( $value ) ? $value : esc_attr( $value );

			if ( 'useTemplateCache' === $key ) {
				$cache_expiration = $value['cacheExpiration'];

				if ( $current_cache_expiration !== $cache_expiration ) {
					\Jet_Cache\Manager::get_instance()->db_manager->delete_cache_by_source( 'elementor_library' );
					$messages[] = __( 'Tabs templates cache has been cleared', 'jet-tabs' );
				}
			}
		}

		update_option( jet_tabs_settings()->key, $current );


		return rest_ensure_response( [
			'status'  => 'success',
			'message' => implode( '. ', $messages ),
		] );
	}

}
