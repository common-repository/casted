/**
 * Quote Card component
 */

/**
 * Internal Dependencies
 */
import { CardAction } from '../index';

const QuoteCard = (props) => {
	const { clip, activeClip, selectedQuote } = props;

	return (
		<>
			<div className="casted-quote-content">
				<h4 className="casted-quote-title">{clip.title}</h4>
				<div
					className={
						clip.id === activeClip
							? 'casted-quote-text'
							: 'casted-quote-text casted-quote-trim'
					}
				>
					"{clip.text}"
				</div>
			</div>
			{clip.id === activeClip ? (
				<div className="casted-quote-options">
					<CardAction
						title="Cancel"
						className="casted-card-action-no-outline"
						onClick={() => {
							props.onSelectActiveQuote(0);
						}}
					/>
					<CardAction
						title="Add Pull Quote"
						className="casted-card-action-green"
						onClick={() => {
							props.onSelectQuote(clip);
						}}
					/>
				</div>
			) : (
				<CardAction
					title="Select Quote"
					onClick={() => {
						props.onSelectActiveQuote(clip.id);
					}}
				/>
			)}
		</>
	);
};

export default QuoteCard;
