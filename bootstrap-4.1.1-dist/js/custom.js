$(document).ready(function() {

	// Initially hide results for projects
	// $(".results").hide();

	// Handle project click
	$('.box-project-heading').click(function(){
		
		$(this).next(".box-project-results").slideToggle();

	});
});