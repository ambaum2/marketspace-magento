/*escape locally custom datepick for product view
// this can be cleaned up later one(comments taken out etc.)
*/

jQuery(document).ready(function(){
//don't do this if the width of the select is greater than the width of its first child option
    jQuery('select[id*="select"]').mousedown(function(){
	var lenArray= jQuery(this).children().length;
	var width = 0;
	var currLen = 0;
	var i = 0;
	for(i=0;i<=lenArray;i++) {
		currLen=jQuery(this).children().eq(i).text().length;
		if(currLen > width) {
		  width = currLen;
		}
	}
    if(jQuery.browser.msie && width > 25) {
        jQuery(this).css("width","auto");
    }
    });
    jQuery('select[id*="select"]').change(function(){
	    if (jQuery.browser.msie) {
	        jQuery(this).css("width","20%");
	    }
    });

});


jQuery(document).ready(function() {
	function updateSelected(dates) { 
	    jQuery('select[id*="month"]').val(dates.length ? dates[0].getMonth() + 1 : ''); 
	    jQuery('select[id*="day"]').val(dates.length ? dates[0].getDate() : ''); 
	    jQuery('select[id*="year"]').val(dates.length ? dates[0].getFullYear() : ''); 
	    //checkLinkedDays(); // Disable invalid days 
	} 
	var d = new Date();
	var curr_date = d.getDate();
	var curr_month = d.getMonth();
	curr_month++;
	var curr_year = d.getFullYear();
	var startDate = curr_month + "/" + curr_date + "/" + curr_year;
	var endDate = curr_month + "/" + curr_date + "/" + (d.getFullYear()+1);
	jQuery('#selectedPicker').datepick({ 
	    minDate: startDate, maxDate: endDate, 
	    alignment: 'bottomRight', onSelect: updateSelected, 
	    showTrigger: '<img id="calImg" style="cursor:pointer;" src="http://escapelocally.com/skin/frontend/default/default/images/date_picker.jpg" />' }); 
	});
	jQuery('.datepick').css("width","218px");
// Update datepicker from three select controls 
jQuery('select[id*="month"],select[id*="day"],select[id*="year"]').change(function() { 
    jQuery('#selectedPicker').datepick('setDate', new Date( 
        jQuery('select[id*="year"]').val(), jQuery('select[id*="month"]').val() - 1, 
        jQuery('select[id*="day"]').val())); 
});


