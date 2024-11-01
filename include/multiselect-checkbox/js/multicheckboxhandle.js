jQuery( document ).ready( function( $ ) 
{
	$('#wimplecf_multiselect_optionsDiv').hide();
		
	$('#wimplecf_multiselect_value').click( function()
	{
		$('#wimplecf_multiselect_optionsDiv').toggle();
	});
	
	$('body').click( function(e)
	{
		if ( ( e.target.className !== "wimplecf_multiselect_valueCls" ) && 
			( e.target.className !== "wimplecf_multiselect_optionsDivCls" ) &&
			( e.target.className !== "wimplecf_multiselect_checkbox" ) && 
			( e.target.className !== "wimplecf_multi_check_sec" ) && 
			( e.target.className !== "wimplecf_multicheckboxhandlecls" ) )
		{
			$("#wimplecf_multiselect_optionsDiv").hide();
		}
	});	
	
	$(".wimplecf_multicheckboxhandlecls").change( function() 
	{
			var wimplecf_checkedValues = $('.wimplecf_multicheckboxhandlecls:checkbox:checked').map( function() {
			return this.value;
			}).get().join(", ");
			
			$('#wimplecf_multiselect_value').val(wimplecf_checkedValues);
	});

});