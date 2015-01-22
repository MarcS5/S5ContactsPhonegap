var routes = angular.module('contactsRoute', ['ngRoute']);

routes.config(['$routeProvider', function ($routeProvider) {
	$routeProvider.
		when('/contact/:id', {
			templateUrl: 'views/detail.html',
			controller: 'ContactDetailController'
		}).
		when('/favorites', {
			templateUrl: 'views/overview.html',
			controller: 'FavoritesController'
		}).
		when('/', {
			templateUrl: 'views/overview.html',
			controller: 'ContactsController'
		}).
		when('/edit/', {
			templateUrl: 'views/edit.html',
			controller: 'EditController'
		}).
		when('/edit/:id', {
			templateUrl: 'views/edit.html',
			controller: 'EditController'
		}).
		otherwise({ redirectTo: '/' });
}]);