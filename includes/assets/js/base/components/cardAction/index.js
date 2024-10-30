/**
 * Card Action component
 */

/**
 * External Dependencies
 */
import { Icon, Button } from '@wordpress/components';

const CardAction = (props) => {
	const {
		title = '',
		onClick = () => {},
		className = 'casted-card-action-outline',
		disabled = false,
		showIcon = false,
	} = props;

	return (
		<Button
			isSecondary
			onClick={onClick}
			disabled={disabled}
			className={className}
		>
			{title}
			{showIcon && <Icon icon="arrow-right-alt2" />}
		</Button>
	);
};

export default CardAction;
