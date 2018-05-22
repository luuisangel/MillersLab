$(document).ready(function() {

	// Handle project click
	$('.box-project-heading').click(function(){
		
		$(this).next(".box-project-techniques").slideToggle();

	});

	// Handle technique click

	$('.technique').click(function(){
		
		$(this).next(".results").slideToggle();

	});
});