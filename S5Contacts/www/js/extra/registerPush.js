﻿function init() {
	document.addEventListener("deviceready", initPushwoosh, true);
}

function initPushwoosh() {
	var pushNotification = window.plugins.pushNotification;
	//set push notifications handler
	document.addEventListener('push-notification', function (event) {

		console.log(event);

		var title = event.notification.title;
		var userData = event.notification.userdata;

		if (typeof (userData) != "undefined") {
			console.warn('user data: ' + JSON.stringify(userData));
		}

		if (event.notification.foreground) {
			alert(title);
		}
	});

	//initialize Pushwoosh with projectid: "GOOGLE_PROJECT_NUMBER", appid : "PUSHWOOSH_APP_ID". This will trigger all pending push notifications on start.
	pushNotification.onDeviceReady({ projectid: "108129937111", appid: "DF7E2-613D8" });

	//register for pushes
	pushNotification.registerDevice(
        function (status) {
        	var pushToken = status;
        	console.warn('push token: ' + pushToken);
        },
        function (status) {
        	console.warn(JSON.stringify(['failed to register ', status]));
        }
    );
}