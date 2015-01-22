var services = angular.module('contactsService', ['ngResource']);

services.factory('Page', [function () {
	var title = 'S5 Contacts';
	return {
		title: function () { return title; },
		setTitle: function (newTitle) { title = newTitle }
	};
}]);

services.factory('Contacts', ['$resource', function ($resource) {
	return $resource('http://contacts.themarc.nl/data/?:id');
}]);

services.factory('Favorites', [function () {
	var favorites = localStorage.getItem('ContactsFavorites') ? JSON.parse(localStorage.getItem('ContactsFavorites')) : null;

	function getAllFavorites() {
		return favorites ? favorites : [];
	}

	function addToFavorites(id) {
		if (favorites === null)	favorites = [];

		favorites.push(id);
		localStorage.setItem('ContactsFavorites', JSON.stringify(favorites));
	}

	function removeFromFavorites(id) {
		if (favorites && favorites.length > 0) {
			var index = favorites.indexOf(id);
			if (index > -1)
				favorites = favorites.splice(id, 1);
		}
		localStorage.setItem('ContactsFavorites', JSON.stringify(favorites));
	}

	return {
		all: getAllFavorites,
		add: addToFavorites,
		remove: removeFromFavorites
	}
}]);