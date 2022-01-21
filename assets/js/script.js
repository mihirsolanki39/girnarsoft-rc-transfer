$(document).ready(function() {
	$('body').videoBG({
		position:"fixed",
		zIndex:0,
		mp4:'videos/christmas_snow.mp4',
		ogv:'videos/christmas_snow.ogv',
		webm:'videos/christmas_snow.webm',
		poster:'videos/christmas_snow.jpg',
		opacity:1,
		fullscreen:true,
	});
	
	
	$('#div_demo').videoBG({
		mp4:'videos/tunnel_animation.mp4',
		ogv:'videos/tunnel_animation.ogv',
		webm:'videos/tunnel_animation.webm',
		poster:'videos/tunnel_animation.jpg',
		scale:true,
		zIndex:0
	});
	
	
	$('#text_replacement_demo').videoBG({
		mp4:'videos/text_replacement.mp4',
		ogv:'videos/text_replacement.ogv',
		webm:'videos/text_replacement.webm',
		poster:'videos/text_replacement.png',
		textReplacement:true,
		width:760,
		height:24
	});
		
})