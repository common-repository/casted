/**
 * List Card component
 */

/**
 * External Dependencies
 */
import { Card } from '@wordpress/components';

const ListCard = (props) => {
	const { vertical = false } = props;

	const flexDirection = vertical ? 'flex-column' : 'flex-row';

	return (
		<Card size="extraSmall" className="casted-list-card">
			<div className={`casted-card-body ${flexDirection}`}>
				{props.children}
			</div>
		</Card>
	);
};

export default ListCard;
