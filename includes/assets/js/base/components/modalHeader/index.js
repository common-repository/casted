/**
 * Modal Header component
 */

/**
 * External Dependencies
 */
import { Icon } from '@wordpress/components';

const ModalHeader = (props) => {
	const { showBack } = props;

	return (
		<div className="casted-modal-header">
			<div
				className={
					showBack
						? 'casted-modal-header-actions casted-justify-space'
						: 'casted-modal-header-actions'
				}
			>
				{showBack && (
					<div
						className="casted-back-button"
						onClick={() => props.backFunction()}
					>
						<Icon icon="arrow-left-alt2" />
						Back
					</div>
				)}
				<div className="casted-modal-close" onClick={() => props.onClose()}>
					<Icon icon="no-alt" />
				</div>
			</div>
			{props.children}
		</div>
	);
};

export default ModalHeader;
