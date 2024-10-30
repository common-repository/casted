/**
 * Casted Modal component
 */

/**
 * External Dependencies
 */
import { Modal } from '@wordpress/components';

const CastedModal = (props) => {
	const { children } = props;

	return (
		<Modal
			className="casted-modal"
			isDismissible={true}
			shouldCloseOnClickOutside={false}
			shouldCloseOnEsc={false}
		>
			{children}
		</Modal>
	);
};

export default CastedModal;
