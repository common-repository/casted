/**
 * Casted Error component
 */

/**
 * External Dependencies
 */
import { Notice } from '@wordpress/components';

const CastedError = () => {
	return (
		<Notice className="casted-notice" status="error" isDismissible={false}>
			<p>
				Your WordPress site has lost its connection to Casted. To continue using
				this block,{' '}
				<a href="/wp-admin/admin.php?page=casted-settings">click here</a> to
				reconnect on the Casted Settings page.
			</p>
		</Notice>
	);
};

export default CastedError;
