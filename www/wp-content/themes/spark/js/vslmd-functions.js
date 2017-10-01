/**
 * File vslmd-functions.js.
 */
jQuery(function($){

"use strict";

/* ==================================================
	Scroll Top
================================================== */

$(document).ready(function(){
	
	$('.bottom-to-top span i').click(function(){
		$('html, body').animate({scrollTop : 0},600);
		return false;
	});
	
});


});