var controllers = angular.module('contactsController', ['contactsService', 'ngToast']);

controllers.controller('MainController', ['$rootScope', '$scope', '$location', 'Page', 'ngToast', function ($rootScope, $scope, $location, Page, ngToast) {
	$scope.bodyClass = '';
	$rootScope.Page = Page;
	$scope.isAdmin = true;

	$scope.searchActive = false;

	$scope.goBack = function () {
		$scope.searchActive = false;
		$scope.search = '';
	};

	$scope.clearSearch = function () {
		$scope.search = '';
	};

	$scope.openSearch = function () {
		$scope.searchActive = true;
		document.getElementById("searchInput").focus();
	};

	$scope.historyBack = function () {
		window.history.back();
	};

}]);

controllers.controller('ContactsController', ['$scope', 'Page', 'Contacts', function ($scope, Page, Contacts) {
	$scope.$parent.bodyClass = 'overview';
	Page.setTitle('S5 Contacts');

	Contacts.query(function (data) {
		$scope.contacts = data;
	});
}]);

controllers.controller('FavoritesController', ['$scope', 'Page', 'Contacts', 'Favorites', function ($scope, Page, Contacts, Favorites) {
	$scope.$parent.bodyClass = 'favorites';
	Page.setTitle('S5 Contacts');
	var allFavorites = Favorites.all(),
		favoritesList = [];

	Contacts.query(function (data) {
		for (var i = 0; i < data.length; i++) {
			if (allFavorites.indexOf(data[i].id) > -1) {
				favoritesList.push(data[i]);
			}
		}
		$scope.contacts = favoritesList;
	});
}]);


controllers.controller('ContactDetailController', ['$scope', '$routeParams', 'Page', 'Contacts', 'Favorites', function ($scope, $routeParams, Page, Contacts, Favorites) {
	$scope.$parent.bodyClass = 'detail';
	var allFavorites = Favorites.all();

	Contacts.get({ id: $routeParams.id }, function (data) {
		Page.setTitle(data.firstName + ' ' + data.inBetween + ' ' + data.lastName + ' - S5 Contacts');
		$scope.contact = data;
		$scope.isFavorite = (allFavorites && allFavorites.indexOf(data.id) > -1);
	});

	$scope.toggleFavorite = function (id) {
		if ($scope.isFavorite) {
			Favorites.remove(id);
			$scope.isFavorite = false;
		} else {
			Favorites.add(id);
			$scope.isFavorite = true;
		}
	};

}]);

controllers.controller('EditController', ['$scope', '$routeParams', '$location', 'Page', 'Contacts', 'ngToast', function ($scope, $routeParams, $location, Page, Contacts, ngToast) {
	$scope.$parent.bodyClass = 'detail';
	var isAdmin = $scope.$parent.isAdmin;

	if ($routeParams.id) {
		Contacts.get({ id: $routeParams.id }, function (data) {
			if (data.status === false) {
				$scope.hideForm = data.hideForm;
				$scope.errorMessage = data.message;
			} else {
				Page.setTitle(data.firstName + ' ' + data.inBetween + ' ' + data.lastName + ' - S5 Contacts');
				$scope.contact = data;
			}
		});
	}

	$scope.saveContact = function (data) {
		if (isAdmin) {
			if ($scope.contactForm.$valid) {
				$scope.contactForm.$submitted = true;
				Contacts.save(data, function (outputData) {
					$scope.errorMessage = outputData.message;

					$location.path('/overview');
					if (!data.id) {
						ngToast.create('User added');
					} else {
						ngToast.create('User edited');
					}
				});
			} else {
				$scope.contactForm.$submitted = false;
			}
		}
	};

	$scope.deleteContact = function (data) {
		if (isAdmin) {
			if (confirm('Are you sure you want to delete this user?')) {
				Contacts.delete({ id: data.id }, function (outputData) {
					if (outputData.status) {
						$location.path('/overview');
					}
				});
			}
		}
	};
}]);