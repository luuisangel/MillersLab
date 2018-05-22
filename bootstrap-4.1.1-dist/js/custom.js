$(document).ready(function() {

	// Initially hide results for projects
	// $(".results").hide();

	// Handle project click
	$('.box-projects h4').click(function(){

		
		$(this).next(".results").slideToggle();

	});
});