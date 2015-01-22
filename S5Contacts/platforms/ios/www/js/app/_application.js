(function ($) {
	var global = {},
		local = {};

	$(function () {
		app.data.getcontacts();

		//$(window).on('contactsLoaded', app.data.rendercontacts);
	});

})(jQuery);