<?php

	include_once WPSC_TE_V2_CLASSES_PATH . '/controller.php';
	include_once WPSC_TE_V2_CONTROLLERS_PATH . '/customer-account.php';

	/**
	 * Note: Look at the controllers in core, for example, the very one this extends
	 * for example on what else you might do in this class.
	 */
	class WPSC_Controller_Wishlist extends WPSC_Controller_Customer_Account {
		public function wishlist() {
			$this->view = 'wishlist';
		}
	}