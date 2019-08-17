$(document).ready(function() {
     $(".js-multiple").select2({ width: 'resolve' });
     $(document).on('change', '.dayoff', function(){
     	if(state = $(this).prop("checked")){
     		// $(this).parent().siblings().find('.select2-selection__rendered').children().remove();
     		$(this).parent().siblings().find('.select2-selection__choice__remove').each(function(){$(this).click();});
     		$(this).parent().siblings().find('.target').val('');
     		$(this).parent().siblings().find('.target').prop("disabled", true);
     	}else{
     		$(this).parent().siblings().find('.target').prop("disabled", false);
     	}
     });
     $('input:checked').each(function() {
           $(this).parent().siblings().find('.target').val('');
           $(this).parent().siblings().find('.target').prop("disabled", true);
     });	  
});