var app = angular.module('contactsApp', ['contactsService', 'contactsController', 'contactsFilter', 'contactsRoute']);

function checkFullscreen() {
	var iOS = (navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false);
	if (!!window.navigator.standalone && iOS) {
		document.getElementsByTagName('html')[0].className += ' fullscreen';
	}
}

function addLoadEvent(func) {
	var oldonload = window.onload;
	if (typeof window.onload != 'function') {
		window.onload = func;
	} else {
		window.onload = function () {
			if (oldonload) {
				oldonload();
			}
			func();
		}
	}
}

addLoadEvent(checkFullscreen);