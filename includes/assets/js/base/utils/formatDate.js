/**
 * Given a Date string, outputs date in mm(.|/)dd(.|/)yy
 *
 * @param {string} date Date to be formated
 * @param {string} seperator Seperator to be used. Either "." or "/".
 * @return {string} String of formated date.
 */
const formatDate = (date, seperator) => {
	const dateObj = new Date(date);

	const dateString =
		('0' + (dateObj.getMonth() + 1)).slice(-2) +
		seperator +
		('0' + dateObj.getDate()).slice(-2) +
		seperator +
		dateObj.getFullYear().toString().slice(-2);

	return dateString;
};

module.exports = { formatDate };
