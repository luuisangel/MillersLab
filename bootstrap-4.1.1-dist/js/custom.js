$(document).ready(function() {

	// Handle project click
	$('.box-project-heading').click(function(){
		
		$(this).next(".box-project-techniques").slideToggle();

	});

	// Handle technique click

	$('.box-project-heading').click(function(){
		$(this).next(".results").slideToggle();
		$(this).find('.fas').toggleClass('fa-arrow-up fa-arrow-down');
		
	});

	$('.technique').click(function(){
		$(this).next(".results").slideToggle();
	});
});