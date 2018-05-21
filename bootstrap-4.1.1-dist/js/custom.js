jQuery(document).ready(function() {

	// Initially hide results for projects
	jQuery("results").hide();

	// Handle project click
	jQuery(".box-projects h4").click(function(){

		jQuery(this).next(".results").slideToggle();

	});
});