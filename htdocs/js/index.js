//login dropdown script
$(document).ready(function () {
	$('#session').click(function () {
		if ($('#signin-dropdown').is(":visible")) {
			$('#signin-dropdown').hide()
			$('#session').removeClass('active');
		} else {
			$('#signin-dropdown').show()
			$('#session').addClass('active');
		}
		return false;
	});
	$('#signin-dropdown').click(function(e) {
		e.stopPropagation();
	});
	$(document).click(function() {
		$('#signin-dropdown').hide();
		$('#session').removeClass('active');
	});
});   


//slider script
$('#slider').slidertron({
		viewerSelector: '.viewer',
		reelSelector: '.viewer .reel',
		slidesSelector: '.viewer .reel .slide',
		advanceDelay: 3000,
		speed: 'slow',
		navPreviousSelector: '.previous-button',
		navNextSelector: '.next-button',
		indicatorSelector: '.indicator li',
		slideLinkSelector: '.link'
});


$('#nav').dropotron();


$('.gallery').poptrox({
		overlayColor: '#222222',
		overlayOpacity: 0.75,
		popupCloserText: 'Close',
		usePopupCaption: true,
		usePopupDefaultStyling: false
});
