(function($){
	function initialiseField( $el ) {
		var container = $el;
		var starList = $(".star-rating", container);
		var starListItems = $(".star", starList);
		var starListItemStars = $(".star-icon", starListItems);
		var starField = $("input", container);
		var clearButton = $("a.clear-button", container);
		var allowHalf = (starField.data('allow-half') == 1);
		var emptyClass = window.starClasses.empty;
		var halfClass = window.starClasses.half;
		var fullClass = window.starClasses.full;

		console.log(window.starClasses);

		starListItems.bind("click", function(e){
			e.preventDefault();

			var starValue = $(this).index();
			starField.val(starValue + 1);

			if (allowHalf) {
				var width = $(this).innerWidth();
				var offset = $(this).offset();
				var leftSideClicked = (width / 2) > (e.pageX - offset.left);

				if (leftSideClicked) {
					starField.val(starField.val() - 0.5);
				}
			}

			clearActiveStarClassesFromList();

			starListItems.each(function(index){
				var icon = $('.star-icon', $(this));
				var starValue = starField.val();

				if (index < starValue) {
					icon.removeClass(emptyClass)
						.removeClass(halfClass)
						.addClass(fullClass);

					if (allowHalf && (index + .5 == starValue)) {
						icon.removeClass(fullClass);
						icon.addClass(halfClass);
					}
				}
			});
		});

		clearButton.bind("click", function(e){
			e.preventDefault();

			clearActiveStarClassesFromList();

			starField.val(0);
		});

		function clearActiveStarClassesFromList()
		{
			starListItemStars
				.removeClass(fullClass)
				.removeClass(halfClass)
				.addClass(emptyClass);
		}
	}

	// Instantiate
	acf.add_action('ready append', function($el) {
		acf.get_fields({
			type: 'star_rating_field'
		}, $el).each(function(){
			initialiseField($(this));
		});
	});
})(jQuery);
