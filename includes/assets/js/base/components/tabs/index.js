/**
 * Tabs component
 */

const Tabs = (props) => {
	const { tabs = [], activeTab } = props;

	return (
		<div className="casted-tabs-wrapper">
			{tabs &&
				tabs.map((tab) => {
					return (
						<div
							key={tab.id}
							className={
								tab.id === activeTab
									? 'casted-tab casted-tab-active'
									: 'casted-tab'
							}
							onClick={() => props.onSelect(tab.id)}
						>
							<h5>{tab.text}</h5>
							<div className="casted-tab-info">{tab.info}</div>
						</div>
					);
				})}
		</div>
	);
};

export default Tabs;
