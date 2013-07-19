jQuery.noConflict();
	jQuery(document).ready(function() {
		/*jQuery('.topLink a').hover(
			function () {
				jQuery(this).children("img").attr("src",switchSrc(this,"_1.png","_2.png"));
			},
			function () {
				jQuery(this).children("img").attr("src",switchSrc(this,"_2.png","_1.png"));
			}); */
		jQuery('.mainLink').hover(
			function () { /*
				imageSrc = jQuery(this).find("img").attr('src');
				imageSrc = imageSrc.replace("_1.png","_2.png");
				jQuery(this).find("img").attr("src",imageSrc);*/
				jQuery(this).children("ul").stop(true,true).slideDown("600");
			},
			function () { /*
				imageSrc = jQuery(this).find("img").attr('src');
				imageSrc = imageSrc.replace("_2.png","_1.png");
				jQuery(this).find("img").attr("src",imageSrc);*/
				jQuery(this).children("ul").stop(true,true).slideUp("600");
			});
		jQuery('.subLink').hover(
 			function () {
		 		jQuery(this).children("ul").stop(true,true).slideDown("600");
		 	},
		 	function () {
		 		jQuery(this).children("ul").stop(true,true).slideUp("600");
		}); 
	});


	function switchSrc(index,srcFrom,srcTo) {
		src = jQuery(index).children("img").attr('src');
		src = src.replace(srcFrom,srcTo);
		return src;
	}