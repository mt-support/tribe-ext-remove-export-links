<?php
/**
 * Plugin Name:       The Events Calendar Extension: Remove Export Links
 * Plugin URI:        https://theeventscalendar.com/extensions/remove-export-links/
 * Description:       Remove the Export Links from Event Views
 * Version:           1.0.0
 * Extension Class:   Tribe__Extension__Remove_Export_Links
 * GitHub Plugin URI: https://github.com/mt-support/tribe-ext-remove-export-links
 * Author:            Modern Tribe, Inc.
 * Author URI:        http://m.tri.be/1971
 * License:           GPL version 3 or any later version
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       tribe-ext-remove-export-links
 *
 *     This plugin is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     any later version.
 *
 *     This plugin is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *     GNU General Public License for more details.
 */

// Do not load unless Tribe Common is fully loaded and our class does not yet exist.
if (
	class_exists( 'Tribe__Extension' )
	&& ! class_exists( 'Tribe__Extension__Remove_Export_Links' )
) {
	/**
	 * Extension main class, class begins loading on init() function.
	 */
	class Tribe__Extension__Remove_Export_Links extends Tribe__Extension {

		/**
		 * Setup the Extension's properties.
		 *
		 * This always executes even if the required plugins are not present.
		 */
		public function construct() {
			$this->add_required_plugin( 'Tribe__Events__Main' );
			$this->set_url( 'https://theeventscalendar.com/extensions/remove-export-links/' );
		}

		/**
		 * Extension initialization and hooks.
		 */
		public function init() {
			add_action( 'init', array( $this, 'remove_hooks' ) );
		}

		public function remove_hooks() {
			$provider = $this->ical_provider();
			/**
			 * Removes the markup for "+Ical Export" and "+Google Calendar" links on Single Events.
			 */
			remove_action( 'tribe_events_single_event_after_the_content', array( $provider, 'single_event_links' ) );

			/**
			 * Removes the markup for the "+ Export Events" link on Calendar views.
			 */
			remove_filter( 'tribe_events_after_footer', array( $provider, 'maybe_add_link' ) );
		}

		/**
		 * Makes the extension compatible with older versions of The Events Calendar.
		 */
		protected function ical_provider() {
			return function_exists( 'tribe' ) ? tribe( 'tec.iCal' ) // Current
				: 'Tribe__Events__iCal'; // Legacy
		}
	} // end class
} // end if class_exists check
