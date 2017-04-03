$(document).ready( function() {

	$(".validate").validate();
	$(".validate_1").validate();
	$(".validate_2").validate();
	$(".validate_3").validate();
	$(".validate_4").validate();


	$('a, .btn, input').on('touchstart', function () {
        $(this).trigger('hover');
    }).on('touchend', function () {
        $(this).trigger('hover');
    });


	function get_set_money(val) {
		val = parseFloat(val).toFixed(2).replace(/./g, function(c, i, a) {
		    return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
		});;
		return val;
	}

	/** decimal and int formatin */

	$(".number").keyup(function (){
		if(this.value.match(/[^0-9.]/g)){
	    	this.value = this.value.replace(/[^0-9.]/g,'');
	  	}
	});

	$(".digits").keyup(function (){
		if(this.value.match(/[^0-9]/g)){
	    	this.value = this.value.replace(/[^0-9]/g,'');
	  	}
	});


	/** money format */
	$('input[type=text].money').number( true, 2, '.', ',', true);
		// cep telefonlari icin money hack
		$("input[type=tel]").each(function() {
			$(this).attr('type', 'text');
			$('input[type=text].money').number( true, 2, '.', ',', true);
			$(this).attr('type', 'tel');
		});
		

		$("input[type=tel].money").keydown(function () {
			if($(this).attr('type') == 'tel') {
				$(this).attr('data-type', 'tel');
				if($(this).is(':focus')) {
					$(this).attr('type', 'text');
				} 
			}
		});
		$("input[type=tel].money").focusin(function () {
			if($(this).attr('type') == 'tel') {
				$(this).attr('data-type', 'tel');
				if($(this).is(':focus')) {
					$(this).attr('type', 'text');
				} 
			}
		});
		$(".money").focusout(function () {
			if($(this).attr('data-type') == 'tel') {
				if(!$(this).is(':focus')) {
					$(this).removeAttr('data-type');
					$(this).attr('type', 'tel');
				}
			}
			
		});


	/** site acilir acilmaz bir input focus olsun */
	$('.focus').focus();

	/** tooltip */
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover();

	/**
	 * dataTable
	 * table listelerinine dataTable ozelligi ekler, otomatik arama ve sıralama yapar, bir nevi hayat kurtaran bir eklenti
	 */
	$('.dataTable').DataTable({
		"order": [],
		"bLengthChange": false,
		"info":     false,
		"language": {
	        "sProcessing":    "Procesando...",
	        "sLengthMenu":    "Mostrar _MENU_ registros",
	        "sZeroRecords":   "Arama sonuçlarına göre <b>log</b> kaydı bulunamadı.",
	        "sEmptyTable":    "Ningún dato disponible en esta tabla",
	        "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	        "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
	        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
	        "sInfoPostFix":   "",
	        "sSearch":        "<i class='fa fa-search'></i>",
	        "searchPlaceholder": "Tablo içinde ara...",
	        "sUrl":           "",
	        "sInfoThousands":  ",",
	        "sLoadingRecords": "Cargando...",
	        "oPaginate": {
	            "sFirst":    "Primero",
	            "sLast":    "Último",
	            "sNext":    "Sonraki",
	            "sPrevious": "Önceki"
	        },
	        "oAria": {
	            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	        }
	    }
	});

	/* dataTable for log : log kayitlari icin kulanılır */
	$('.dataTable-logs').DataTable({
        "paging":   true,
        "ordering": true,
        "info":     false,
        "bLengthChange": false,
        "language": {
	        "sProcessing":    "Procesando...",
	        "sLengthMenu":    "Mostrar _MENU_ registros",
	        "sZeroRecords":   "Arama sonuçlarına göre <b>log</b> kaydı bulunamadı.",
	        "sEmptyTable":    "Ningún dato disponible en esta tabla",
	        "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	        "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
	        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
	        "sInfoPostFix":   "",
	        "sSearch":        "<i class='fa fa-search'></i>",
	        "searchPlaceholder": "Log kayıtlarında ara...",
	        "sUrl":           "",
	        "sInfoThousands":  ",",
	        "sLoadingRecords": "Cargando...",
	        "oPaginate": {
	            "sFirst":    "Primero",
	            "sLast":    "Último",
	            "sNext":    "Sonraki",
	            "sPrevious": "Önceki"
	        },
	        "oAria": {
	            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	        }
	    }
    } );



	/* datetimepicker */
	$(".datetime").datetimepicker({
		format: 'YYYY-MM-DD HH:mm',
		dayViewHeaderFormat: 'MMMM YYYY',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: "fa fa-angle-double-left",
            next: "fa fa-angle-double-right",
            today: "fa fa-calendar-check-o",
            clear: 'fa fa-eraser',
            close: 'fa fa-times'
        },
        tooltips: {
		    today: 'Bu gün',
		    clear: 'Temizle',
		    close: 'Kapat',
		    selectMonth: 'Ay Seçiniz',
		    prevMonth: 'Önceki Ay',
		    nextMonth: 'Sonraki Ay',
		    selectYear: 'Yıl Seçiniz',
		    prevYear: 'Önceki Yıl',
		    nextYear: 'Sonraki Yıl',
		    selectDecade: 'On Yıl Seçiniz',
		    prevDecade: 'Önceki On Yıl',
		    nextDecade: 'Sonraki On Yıl',
		    prevCentury: 'Önceki Yüzyıl',
		    nextCentury: 'Sonraki Yüzyıl',
		    selectTime: "Tarih Seçiniz"
		},
        showTodayButton:true,
        showClose:true,
        ignoreReadonly:true
    });


	/* datetimepicker */
	$(".date").datetimepicker({
		format: 'YYYY-MM-DD',
		dayViewHeaderFormat: 'MMMM YYYY',
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: "fa fa-angle-double-left",
            next: "fa fa-angle-double-right",
            today: "fa fa-calendar-check-o",
            clear: 'fa fa-eraser',
            close: 'fa fa-times'
        },
        tooltips: {
		    today: 'Bu gün',
		    clear: 'Temizle',
		    close: 'Kapat',
		    selectMonth: 'Ay Seçiniz',
		    prevMonth: 'Önceki Ay',
		    nextMonth: 'Sonraki Ay',
		    selectYear: 'Yıl Seçiniz',
		    prevYear: 'Önceki Yıl',
		    nextYear: 'Sonraki Yıl',
		    selectDecade: 'On Yıl Seçiniz',
		    prevDecade: 'Önceki On Yıl',
		    nextDecade: 'Sonraki On Yıl',
		    prevCentury: 'Önceki Yüzyıl',
		    nextCentury: 'Sonraki Yüzyıl',
		    selectTime: "Tarih Seçiniz"
		},
        showTodayButton:true,
        showClose:true,
        ignoreReadonly:true
    });




	/* tab menu auto click and # */
	// Javascript to enable link to tab
	var url = document.location.toString();
	if (url.match('#')) {
	    $('.til-nav-page.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
	}

	// Change hash for page-reload
	$('.til-nav-page.nav-tabs a').on('shown.bs.tab', function (e) {
	    window.location.hash = e.target.hash;
	})
	/* //.tab menu auto click and # */




	/* select style */
	$('.select').selectpicker({
	  style: 'btn-default',
	  tickIcon: 'fa fa-check',
	  size: 4,
	  refresh:true
	});
	

	/* colorpicker */
	$('.colorpicker').colorpicker();


	

});



/**
* math_vat_rate()
* KDV tutarindaki degeleri alip basina "1." veya "1.0" gibi degerler ekler.
*/
function math_vat_rate(vat) {
	var math_tax_rate = '';
	if(vat.length == 2){ math_tax_rate =  parseFloat('1.'+vat); }
	else { math_tax_rate = parseFloat('1.'+'0'+vat); }
	return math_tax_rate;
}

/**
* get_set_decimal()
* parasal degerlerdeki virgulleri siler
*/
function get_set_decimal(val) {
	return val.replace(',', '');
}


/* delay - bekletici */
var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();



/* getJSON aramalari icin kullanilir */
function input_getJSON_account(input, div_class, item, json_url, db_s_where)
{
	if(db_s_where.length < 1) { db_s_where = 'all'; }
	// div name
	var open_div_name = '.liveData.'+div_class+'';

	// eger div menusu eklenmemis ise ekleyelim
	if ($(input).parent().find(open_div_name).length < 1){
		$(input).after('<div class="dropdown liveData '+div_class+'"><ul class="dropdown-menu inner"></ul></div>');
	}

	// body keydown
	$('body').keydown(function() {
		if ($(input).parent().find(open_div_name+'.open ul li:first-child a').is(":focus")) {
			if(event.which == 38) {
				setTimeout(function(){$(input).focus();}, 1);
			}
		} else if ($(input).parent().find(open_div_name+'.open ul li:last-child a').is(":focus")) {
			if(event.which == 40) {
				setTimeout(function(){$(input).focus();}, 1);
			}
		}
	});

	// body click
	$('body').click(function() {
		$(open_div_name).removeClass('open');
		$(open_div_name+' ul').html('');
	});


	// input keyup
	$(input).keydown(function() {
		if(event.which == 40) { // eger asagi butonuna basilmis ise ilk eleman secilsin
			$(input).parent().find(open_div_name+' ul li:first-child a').focus();
		} else if(event.which == 38) { // eger asagi butonuna basilmis ise ilk eleman secilsin
			$(input).parent().find(open_div_name+' ul li:last-child a').focus();
		}
	});



	// input text change
	$(input).on('input',function() {
		delay(function(){
			input = $(input);
			if(input.val() == '') { // eger metin kutusu bos ise listeleme kutusunu gizle
				$(open_div_name).removeClass('open');
				$(open_div_name+' ul').html('');
			} else {
				$.getJSON( json_url+"?s="+$(input).val()+"&db-s-where="+db_s_where+"", function( data ) {
					// listeleme kutusunu tekrar gizle
					$(open_div_name).removeClass('open');
					$(open_div_name+' ul').html('');

					// JSON ile donen degerler
				  	$.each( data, function( i, list ){

				  		// attr icine eklenecek deger icin string olustur
				  		var attr_str = '';

						//attr_str = attr_str + ' data-'+attr[l]+'="'+data[i][attr[l]]+'"';
						$.each(data[i], function(col_name) {
							attr_str = attr_str + ' data-'+col_name+'="'+data[i][col_name]+'"';
						});


						// gosterilecek liste elemeni
			  			var text_str = '';
			  			$.each( item, function( key, val ) {
							text_str = text_str + val.replace('[TEXT]', data[i][key]);
						});


				  		// listeleme kutusuna elemanları ekle
						$(input).parent().find(open_div_name+' ul').append('<li><a href="javascript:;" class="item getJSON_'+div_class+'" onclick="'+div_class+'_getJSON_click(this);" '+attr_str+'>'+text_str+'</a></li>');
					});
					$(input).focus();
				})
				.done(function() {
					// listeleme kutusunu tekrar aktif et
				  	$(input).parent().find(open_div_name).addClass('open');
				})
				.fail(function() {
				    $(open_div_name).removeClass('open');
					$(open_div_name+' ul').html('');
				})
				.always(function() {

				});
			}
	    }, 200 );
	});
} //.input_getJSON_account()






/**
 * calc_val_length()
 * bir inputtaki karakteri sayar ve istenilen nesneye basar
 */
function calc_val_length(input, return_html) {

	var length = $(input).val().length;
	$(return_html).html(length);

	$(input).bind('keydown keyup keypress change',function(){
	    var length = $(this).val().length;
	    $(return_html).html(length);
	});
} //.calc_val_length()






/** for chart js **/
function cjartjs_addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}







/*
| -------------------------------------------------------------------
|  js_til_select_div()
| -------------------------------------------------------------------
| bir select nesnesinin secilen elemana gore bir div gosterilip gosterilmeyecegini secer
| biraz karisik oldu biliyoruz :)
*/
function js_til_select_div(div_name, item, effect) {
	$(div_name).hide();

	if(item.val().length > 0) {
		if(effect == false) {
			$('[data-div_selected="'+item.val()+'"]').show(effect);
			$('.js_til_select-'+item.val()).show(effect);
		} else {
			$('[data-div_selected="'+item.val()+'"]').show('slide', { direction: 'up', mode: 'hide' }, 500);
			$('.js_til_select-'+item.val()).show('slide', { direction: 'up', mode: 'hide' }, 500);
		}
    }
} //.til_select_div()

$(document).ready(function() {
	$('.js_til_select_div').change(function() {
		var div_name = $(this).attr('data-div');
		js_til_select_div(div_name, $(this), true);
	});

	$('.js_til_select_div').each(function() {
		var div_name = $(this).attr('data-div');
		js_til_select_div(div_name, $(this), false);
	});
});
/* /.js_til_select_div() */


function js_til_checked_show(div_name, item, effect) {
	$(div_name).hide();

	if(item.is(':checked')) {
		if(effect == false) {
			$(div_name).show(effect);
		} else {
			$(div_name).show('slide', { direction: 'up', mode: 'hide' }, 500);
		}
	}

}

$(document).ready(function() {
	$('[data-checked_show]').change(function() {
		var div_name = $(this).attr('data-checked_show');
		js_til_checked_show(div_name, $(this), true);
	});
	$('[data-checked_show]').each(function() {
		var div_name = $(this).attr('data-checked_show');
		js_til_checked_show(div_name, $(this), false);
	});
});








/*
| -------------------------------------------------------------------
|  add_div_item
| -------------------------------------------------------------------
| bir div grubuu cogaltir, div icindeki tum elemetleri kopyalar ve bir alt satıra yenisi ekler
| div icindeki cogaltilacak nesnede .clone_item sınıfını arar
*/
$(document).ready(function() {
	$('[data-function="add_div_item"]').click(function() {
		var div_global = $(this).attr('data-div');
		var max_element 	= $(this).attr('data-max_element'); if(max_element == 'undefined') { max_element = '99'; }
		var div_id = Math.floor(Math.random() * 1000) + 1;

		if($(div_global + ' .clone_item').length >= max_element) { console.log('max div sayisina ulasildi.'); return false; } {

			var clone_item = $(div_global + ' .clone_item').html();
			$(div_global).append('<div class="clone_item" id="'+div_id+'">'+clone_item+'</div>');
			$(div_global + ' .clone_item:last-child').find('input').val('');
			$(div_global + ' .clone_item:last-child').find('select option:selected').removeAttr("selected");

			$(div_global + ' .clone_item:last-child').find(':input').each(function() {
				$(this).attr("id",  $(this).attr("id")+'_'+div_id);
			});

			$(div_global + ' .clone_item:last-child').find('label').each(function() {
				$(this).attr("for",  $(this).attr("for")+'_'+div_id);
			});

		}
	});


	$(document).on('click', '.clone_item [data-function="remove_div_item"]', function() {
		var div_global = $(this).attr('data-div');

		if($(div_global + ' .clone_item').length > 1) {
			$(this).parents('.clone_item').remove();
		} else {

		}
	});
});
/* /.add_div_item */

