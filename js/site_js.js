$(document).ready(function(){
  
	$('.slider_in').bxSlider({
		auto: true,
		nextSelector: '#slider-next',
		prevSelector: '#slider-prev',
		nextText: '<div class="boll_right"></div>',
		prevText: '<div class="boll_left"></div>'
	});
	$('.news_slide').bxSlider({
		auto: true,
		mode: 'vertical',
	});
	
});

