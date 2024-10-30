/**
 * Editor Wrapper component
 */

/**
 * External Dependencies
 */
import { Button } from '@wordpress/components';

const EditorWrapper = (props) => {
	const { title, disableEdit = false } = props;

	return (
		<div className="casted-editor-wrapper">
			<div className="casted-hover-edit">
				<h3>{title}</h3>
				<Button
					className="casted-edit-block-button"
					onClick={() => props.onEditClick()}
					disabled={disableEdit}
				>
					Edit
				</Button>
			</div>
			{props.children}
		</div>
	);
};

export default EditorWrapper;
