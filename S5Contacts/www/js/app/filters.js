var services = angular.module('contactsFilter', []);

services.filter('profilePicture', function () {
	return function (input) {
		if (input) {
			if (input.indexOf('http') > -1) {
				return input; 
			} else {
				return 'images/profile/' + input;
			}
		} else {
			return 'images/profile/default.png';
		}
	}
});