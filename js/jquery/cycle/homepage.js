jQuery.noConflict();
jQuery(document).ready(function() {
    jQuery('#s5').cycle({
		fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
        delay: -4000,
        speed: 300,
        timeout: 10000, //timeout is the time between slide transitions this is about 6 seconds
        pager: '#slideNav',
        next: '#next',
        prev: '#prev',
        pause: 1
	});
	jQuery('#slidePause').click(function() {
		jQuery('#s5').cycle('pause');
	});
	jQuery('#prev,#next').click(function() {
		jQuery('#s5').cycle('resume');
	});
});