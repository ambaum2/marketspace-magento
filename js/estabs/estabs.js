/*see original on thedotworld group site called mydoc2jstabv2 
js/jquery/estabs/estabs.js*/
jQuery.noConflict();
jQuery(document).ready(function() {
eltabs = jQuery('div[id*="tab"]');//find all tabs
if(eltabs.length >0) {
function sortTabName(a,b) { //sort by tab number ex: tab1 tab2 ...
 return parseInt(a.id.substr(3,(a.id.length)-3))-parseInt(b.id.substr(3,(a.id.length)-3));
}
eltabs.sort(sortTabName);
jQuery("#mktSubCats").append("<ul id='mktSubCatList'></ul>");
for(i=0;i<eltabs.length;i++) { //img tags for ie 8 and below
var ele = "<li class='subCatsTab'><!--[if lte IE 8]><img src='/skin/frontend/default/default/images/es15/leftTab.png' /><![endif]-->"
	+ "<!--[if !IE]> --><a href='#"+eltabs[i].id+"esl'><!-- <![endif]--><!--[if lte IE 8]><a class='ieEslTabs' href='#"+eltabs[i].id+"esl'><![endif]-->"
	+ "<!--[if gte IE 9]><a href='#"+eltabs[i].id+"esl'><![endif]-->"
	+ jQuery(eltabs[i]).attr("title")+"</a><!--[if lte IE 8]><img src='/skin/frontend/default/default/images/es15/rightTab.png' /><![endif]--></li>";
jQuery("#mktSubCatList").append(ele);
var currDiv = jQuery(eltabs[i].id).html();
jQuery("#mktSubCats").append("<div id='"+eltabs[i].id+"esl'>"+eltabs[i].innerHTML+"</div>");
jQuery("#"+eltabs[i].id).hide();
//oldDiv.parentNode.removeChild(oldDiv);
//var wrapDiv = document.createElement('DIV');
//wrapDiv.id=eltabs[i].id;
//wrapDiv.innerHTML = eltabs[i].innerHTML;
//document.getElementById("mktSubCats").appendChild(wrapDiv);
}


jQuery('#mktSubCats').tabs();

jQuery('#mktSubCats').css("border","none");
//jQuery('#mktSubCats #mktSubCatList .subCatsTab a').css("border-bottom","2px solid white");
jQuery('#mktSubCats .ui-widget-header').css("border-bottom","13px solid #009900");
jQuery('#mktSubCats').css("background","none");
jQuery('#mktSubCats .ui-widget-header').css("background", "none");
//jQuery('#mktSubCats .subCatsTab').css('background','#99CC99');
//jQuery('#mktSubCats .subCatsTab').css('border-top-right-radius','18px');
//jQuery('#mktSubCats .subCatsTab').css('border-top-left-radius','18px');
}
});



