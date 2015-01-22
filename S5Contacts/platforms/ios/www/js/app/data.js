(function ($) {
	var global = {},
		local = {
			dataFile: '/data/contacts.json'
		};

	global.getcontacts = function () {
		$.get(local.dataFile, global.rendercontacts, 'json');
	};

	global.rendercontacts = function (data) {
		var contactList = $('#contact-list'),
			template = Handlebars.compile(contactList.html());

		contactList.html(template(data));
	};

	if (!window.app) window.app = {};
	window.app.data = global;
})(jQuery);