$(document).ready(function() {


	$('[data-toggle="switch"]').each(function() {
		
		// ID degerini id degiskenine atayalim
		// eger attr ID yok ise biz olusturalim
		var id = $(this).attr('id');
		if(!id) { 
			$(this).attr('id', Math.floor(Math.random() * 666666666) + 1  ); 
			var id = $(this).attr('id'); 
		} 

		// Evet, Hayir gibi gorunecek etiketleri kontrol edelim
		var textOn = $(this).attr('text-on');
		if(!textOn) {
			textOn = "Evet";
		}
		var textOff = $(this).attr('text-off');
		if(!textOff) {
			textOff = "Hayır";
		}

		var switchSize = $(this).attr('switch-size');
		if(!switchSize) {
			switchSize = "md";
		}


		$(this).wrap('<div class="til-switch til-switch-'+switchSize+'" data-checkbox-id="'+id+'"></div>');
		$(this).parent().append('<div class="switch-text" on-text="'+textOn+'" off-text="'+textOff+'"></div>');

		// eger nesne label icinde degilse label icine alalim
		if($(this).closest('label').length < 1) {
			$(this).parent().wrap('<label></label>');
		}
		$(this).closest('label').addClass('til-switch-label');

	});




	
});

