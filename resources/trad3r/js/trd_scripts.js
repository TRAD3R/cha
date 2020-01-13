var $ = jQuery.noConflict();

suggest_count = 0;
input_initial_value = '';
suggest_selected = 0;
// var pattern = /^[a-z]{2}_[a-z]{2}$/i;
// var addr = window.location.pathname.split("/")[1];
var allPhones = null;               // объект всех телефонов из БД
var inputSearch = '';				// поле поиска
var trd_result = '';				// окно вывода подсказки
var res_window = '';				// окно вывода результата
var psa_loader = '';				// окно прелоадера
var search_action = '';				// значок лупы
var phrase_for_search_by_size = trd_getPhraseFromVocabulary('Größe manuell wählen');	// фраза подбора по размерам
var img_phoneForInputSizes = trd_getPhraseFromVocabulary('<div class="new-psa-searcher"><p class="info-mess-searcher">Kannst du keine passende Hülle für dich finden? Fülle die Felder aus:</p><div class="mobile-bg"><div class="input2"><input type="text" placeholder="Höhe" id="height" class="ps-trd-input"><span>mm</span></div><div class="input3"><input type="text" placeholder="Tiefe" id="depth" class="ps-trd-input"><span>mm</span></div><div class="input1"><input type="text" placeholder="Breite" id="width" class="ps-trd-input"><span>mm</span></div><a href="#" id="trd_search_size_link" class="btn btn-right" onClick="trd_picking_by_sizes(); return false;">Finde deine Hülle</a></div></div>');

$(window).load(function () {
   // console.log($(".qty")[0].value);
    $(".minus").on('click',function (e) {
        if($(".qty")[0].value<2) {
            $(".qty")[0].value=2;
        };
    });
});

/* TRD ----------------------------SEARCH-----------------------------------*/
$(window).load(function(){
	var arrPhones = ('Пустой массив');				// массив для хранения всех телефонов
	trd_getAllPhones();

    // получение данных по активному полю поиска
    $('body').on('focus', '.form-control', function (e) {
        if($(this).attr('id') == 'InputSearch'){
            $("#InputSearch_footer").val('');
            inputSearch = "#InputSearch";
            trd_result = ".result";
            res_window = '.result-window';
            psa_loader = '.psa-loader';
            search_action = '.search-action';
        }else{
            $("#InputSearch").val('');
            inputSearch = "#InputSearch_footer";
            trd_result = ".result_footer";
            res_window = '.result-window_footer';
            psa_loader = '.psa-loader_footer';
            search_action = '.search-action_footer';
        }
    }); // on

    // чтение ввода с клавиатуры
    $("#InputSearch").keyup(function(e){
        e.preventDefault();

        if($(".result").hasClass('trd_search_animate')) {
            $(".result").removeClass('trd_search_animate');
        } // if

        // удаление строки ошибки поиска
        $('.error_msg').remove();
        // определяем какие действия нужно делать при нажатии на клавиатуру
        switch(e.keyCode) {
            // игнорируем нажатия на эти клавишы
            case 13:  // enter
            case 27:  // escape
            case 38:  // стрелка вверх
            case 40:  // стрелка вниз
                break;

            default:
                // производим поиск только при вводе более 1 символа
                if($(this).val().length > 1){

                    input_initial_value = $(this).val(); // введенный текст
                    searchModelsInArray($(this).val());
                }else{
                    $(".result-window").hide();
                    $(".result").removeClass('trd_search_animate');
                } // if
                break;
        }  // switch
    });	// keyup

    // клик по результату подбора телефонов
    //считываем нажатие клавиш, уже после вывода подсказки
    $("#InputSearch").keydown(function(I){
        switch(I.keyCode) {
            // по нажатию клавиш прячем подсказку
            case 13: // enter
                $('.result-window').hide();
                //suggest_count = 0;
                getboons();

                return false;
                break;
            // делаем переход по подсказке стрелочками клавиатуры
            case 38: // стрелка вверх
            case 40: // стрелка вниз
                I.preventDefault();
                if(suggest_count){
                    //делаем выделение пунктов в слое, переход по стрелочкам
                    key_activate( I.keyCode-39 );
                } // if
                break;
        } // switch
    }); // keydown

// делаем обработку клика по лупе
    $('.form-group').on('click', ".search-action", function(){


        if($('#InputSearch').val().trim() != ''){
            getboons();
        } //if

    });

    // если кликаем в любом месте сайта, нужно спрятать подсказку и окно результата
    $('section, div').click(function(e){
        if($(this).hasClass("result") || $(this).hasClass("result-window") ) {
            console.log(120);
            // клик по элементу поля
            e.preventDefault();
            e.stopPropagation();
            $('ul li a').each(function(){
                if($(this).is(':hover')){
                    $("#InputSearch").val($(this).text());
                    $(".result-window").fadeOut(350).html('');
                    suggest_count = 0;
                    getboons();
                } // if
            });
        }else{
          $(".result-window").hide();
          $(".result_window_search").hide();
          $(".result").removeClass('trd_search_animate');
            e.stopPropagation();
        } // if
    }); // click

    // если кликаем на поле input и есть пункты подсказки, то показываем скрытый слой
    $('body').on('click', "#InputSearch", function(event){
      if(suggest_count && $(this).val().length > 1)
        $(".result-window").show();
      event.stopPropagation();
    }); // click
}); // ready

// создание массива с телефонами
function trd_getAllPhones() {
    $.ajax({
        url: TRDJS.ajax_url,
        type: 'POST',
        data: {
            action: 'trd_get_allPhones',
        },
        success: function(res) {
            allPhones = $.parseJSON(res);
            arrPhones = new Array();
            var i = 0;
            $.each(allPhones, function (key, item) {
                arrPhones[i++] = {
                    'url': key,
                    'title': item
                };
            })
        }, // success
        error: function () {
            arrPhones = ['Проверьте лог-файл'];
        }
    }); // ajax
} // trd_getAllPhones

// обработка клика по кнопке скрытия предупреждения
// об использовании кукис
function hideCookieNotice() {
        $.cookie('trd_cookie-notice', 'hide', { expires: 30, path: '/' });
        $('#trd-cookie-notice').hide();
        return false;
} // hideCookieNotice

// выбираем все элементы, которые подходят для запроса
function searchModelsInArray(str) {
	str = str.trim().toUpperCase();	// перевод строки запроса в верхний регистр (для удобства сравнения)
	words = str.split(' ');		// разделение строки запроса по пробелам
	arr = [];           		// массив для результата
    var excludesArr = ['hülle', 'für', 'handyhülle', 'tasche', 'reboon'];   // слова, которые не учитываются в запросе
    // если предположительно введен sku
    if(str.match(/^\d{4}$/) && str >= 5000) {
        $(".result-window").hide();
        return;
    } // if

// проверяем все элементы на соответствие запросу
    for (i = 0; i < arrPhones.length; i++) {
        matches = 0;			// количество слов, которые есть в названии из строки
        for (j = 0; j < words.length; j++) {
            // если введено исключающее слово, то пропускаем его
            // if(excludesArr.includes(words[j].toLowerCase())){matches++; continue;}
            if(excludesArr.indexOf(words[j].toLowerCase()) >= 0){matches++; continue;}
            // если в названии есть это слово
            if (arrPhones[i].title.toUpperCase().indexOf(words[j]) != -1) {
                // увеличиваем количество на 1
                matches++;
            } // if
        } // for j
        // если все слова есть в названии, то добавляем название в список
        if (matches == words.length) {
            newElement = arrPhones[i];
            arr.push(newElement);
        } // if
    } // for i
	showWindowResult(arr);
} // searchModelsInArray

// вывод окна-подсказки
function showWindowResult(arr) {
	if(arr.length > 0){
		suggest_count = arr.length;
		// перед показом слоя подсказки, его обнуляем
		$(".result-window").html("").show();
		$(".result-window").append('<ul>');
		for(var i in arr){
			if(arr[i] != ''){
				// добавляем слою позиции
				$(".result-window" + ' ul').append('<li><a href="' + arr[i].url +'">'+ arr[i].title +'</a></li>');
			}
		}
        $(".result-window" + ' ul').append('<li><a id="selection_by_sizes" onclick="search_by_size()"><i class="fa fa-arrows-alt" aria-hidden="true"></i> '+phrase_for_search_by_size+'</a></li>');
		$(".result-window").append('</ul>');
	}else{
        search_by_size();
	} // if
	scrollForResult();
} // insertInWindoeResult

// вывод окна ввода размеров для подбора чехла
function search_by_size() {
    $('.error_msg').remove();
    $(res_window).removeClass('overflow');
    $(res_window).html(img_phoneForInputSizes).show();
} // search_by_size

// ajax запрос на поиск и возврат чехлов для выбранного телефона
function getboons(){
    model = $.trim($("#InputSearch").val());
    lang = getLang();
    var query = '';

    for(var i = 0; i < arrPhones.length; i++){
        if(arrPhones[i].title == model && arrPhones[i].url.indexOf("//shop.reboon.de") > 0){
            location.href = arrPhones[i].url;
        }
    }

	// показ прелоадера
    $(".psa-loader").show();

    // ищем по sku
    // иначе по модели
    if(model >= 5000){
        $.ajax({
            type: "POST",
            url: TRDJS.ajax_url,
            data: {
                action: 'trd_get_realProductBySKU',
                "query": encodeURIComponent(model),
                "lang": encodeURI(lang)
            },
            success: function(res){
                $(".psa-loader").hide();
                if(res.indexOf("</span>")+1 > 1){
                    $('.form-group').prepend(res);
                    $(".result-window").show();
                }else{
                    $("body").prepend("<div class='trd_overflow'><div><span class='gps_ring'></span><span></span></div></div>");
                    window.location.replace(res);
                } // if
            } // success
        }); // ajax
    }else {
        $.ajax({
            type: "POST",
            url: TRDJS.ajax_url,
            data: {
                action: 'trd_get_acceptBoons',
                "query": encodeURIComponent(allPhones[model]),
                "lang": encodeURI(lang)
            },
            success: function (res) {
                $(".psa-loader").hide();
                query = model;
                if (res.indexOf("</div>") + 1 > 1) {
                    $(".result" + ' .psa-container').html("");
                    $(".result").addClass('trd_search_animate');
                    $(".result" + ' .psa-container').append(res);
                } else if (res.indexOf("</span>") + 1 > 1) {
                    query = model + " -- not found";
                    $('.form-group').prepend(res);
                    $(".result-window").show();
                } else {
                    $("body").prepend("<div class='trd_overflow'><div><span class='gps_ring'></span><span></span></div></div>");
                    window.location.replace(res);
                } // if
                saveQuery(query);
            } // success
        }); // ajax
    }
} // getboons

// Сохранение запроса в файл
function saveQuery(query) {
    $.ajax({
        url: TRDJS.ajax_url,
        type: "POST",
        data: {
            action: 'saveQuery',
            "query": query,
        }
    }) // ajax
}
// устанавливать скролл для окна результата
function scrollForResult(){
  if ($(".result-window" + ' ul').height() > 3) {
      $(".result-window").addClass('overflow');
  }else {
      $(".result-window").removeClass('overflow');
  } // if
} // scrollForResult

function key_activate(n){
    $(".result-window" + ' ul li').eq(suggest_selected-1).removeClass('active');

    // проход стрелками по окну выбора
    if(n == 1 && suggest_selected <= suggest_count){
      suggest_selected++;
    }else if(n == -1 && suggest_selected > 1){
      suggest_selected--;
    }

    // если есть элементы для отображения
    if( suggest_selected > 0){
      // функция скроллинга
      if(suggest_selected > 8){
      scrollLock = (suggest_selected - 8) * 37.07;
        $(".result-window").scrollTop(scrollLock);
      }else{ $(".result-window").scrollTop(0);}

      $(".result-window" + ' ul li').eq(suggest_selected-1).addClass("active");
      $("#InputSearch").val($(".result-window" + ' ul li').eq(suggest_selected-1).text());
    } else {
      $("#InputSearch").val(input_initial_value);
    }
  } // key_activate
/* TRD ----------------------------SEARCH-----------------------------------*/

/* TRD ----------------------------SEARCH-FOOTER-----------------------------------*/
$(document).ready(function(){
	// читаем ввод с клавиатуры
  $("#InputSearch_footer").keyup(function(e){
    e.preventDefault();
	if($('.result_footer').hasClass('trd_search_animate_footer')) {
		$('.result_footer').removeClass('trd_search_animate_footer');
	} // if

      // удаление строки ошибки поиска
      $('.error_msg').remove();
    // определяем какие действия нужно делать при нажатии на клавиатуру
    switch(e.keyCode) {
      // игнорируем нажатия на эти клавишы
      case 13:  // enter
      case 27:  // escape
      case 38:  // стрелка вверх
      case 40:  // стрелка вниз
      break;

      default:
        // производим поиск только при вводе более 1 символа
        if($(this).val().length > 1){

          input_initial_value = $(this).val(); // введенный текст
          searchModelsInArray_footer($(this).val());
        }else{
           $('.result-window_footer').hide();
		   $('result_footer').removeClass("trd_search_animate_footer");
		}
      break;
    }  // switch
  });	// keyup

  // делаем обработку клика по лупе
  $('.search-action_footer').click(function(){

      if($('#InputSearch_footer').val().trim() != ''){
          getboons_footer();
      } //if

  });

  // делаем обработку клика по подсказке
    /*$('body').on('click', '.result-window_footer ul li',function(e){
		e.preventDefault();
      // ставим текст в input поиска
      $('#InputSearch_footer').val($(this).text());
      // прячем слой подсказки
      $('.result-window_footer').fadeOut(350).html('');
      suggest_count = 0;
      getboons_footer();
    }); // on*/

  // если кликаем в любом месте сайта, нужно спрятать подсказку и окно результата
    $('section, div').click(function(e){
		if($(this).hasClass('result_footer') || $(this).hasClass('result-window_footer')) {
            // клик по элементу поля
            e.preventDefault();
            e.stopPropagation();
            $('ul li a').each(function(){
                if($(this).is(':hover')){
                    $("#InputSearch_footer").val($(this).text());
                    $(".result-window_footer").fadeOut(350).html('');
                    suggest_count = 0;
                    getboons_footer();
                } // if
            });
		}else{
		  $('.result-window_footer').hide();
		  $('.result_footer').hide();
		  $('.result_footer').removeClass('trd_search_animate_footer');

		}
        e.stopPropagation();
    }); // click

	// если кликаем на поле input и есть пункты подсказки, то показываем скрытый слой
    $('#InputSearch_footer').click(function(event){
      if(suggest_count && $(this).val().length > 1)
        $('.result-window_footer').show();
      event.stopPropagation();
    }); // click

	//считываем нажатие клавиш, уже после вывода подсказки
	$("#InputSearch_footer").keydown(function(I){
		switch(I.keyCode) {
			// по нажатию клавиш прячем подсказку
			case 13: // enter
				$('.result-window_footer').hide();
				suggest_count = 0;
				getboons_footer();
				return false;
			break;
			// делаем переход по подсказке стрелочками клавиатуры
			case 38: // стрелка вверх
			case 40: // стрелка вниз
				I.preventDefault();
				if(suggest_count){
					//делаем выделение пунктов в слое, переход по стрелочкам
					key_activate_footer( I.keyCode-39 );
				} // if
			break;
		} // switch
	}); // keydown
}); // ready

// выбираем все элементы, которые подходят для запроса
function searchModelsInArray_footer(str) {
    str = str.trim().toUpperCase();	// перевод строки запроса в верхний регистр (для удобства сравнения)
    words = str.split(' ');		// разделение строки запроса по пробелам
    arr = [];           		// массив для результата

// проверяем все элементы на соответствие запросу
    for (i = 0; i < arrPhones.length; i++){
        matches = 0;			// количество слов, которые есть в названии из строки
        for(j = 0; j < words.length; j++){
            // если в названии есть это слово
            if(arrPhones[i].title.toUpperCase().indexOf(words[j]) != -1){
                // увеличиваем количество на 1
                matches++;
            } // if
        } // for j
        // если все слова есть в названии, то добавляем название в список
        if(matches == words.length) {
            newElement = arrPhones[i];
            arr.push(newElement);
        } // if
    } // for i

	showWindowResult_footer(arr);
} // searchModelsInArray_footer

// вывод окна-подсказки
function showWindowResult_footer(arr) {
	if(arr.length > 0){
		suggest_count = arr.length;
		// перед показом слоя подсказки, его обнуляем
        $(".result-window_footer").html("").show();
        $(".result-window_footer").append('<ul>');
        for(var i in arr){
            if(arr[i] != ''){
                // добавляем слою позиции
                $(".result-window_footer" + ' ul').append('<li><a href="' + arr[i].url +'">'+ arr[i].title +'</a></li>');
            }
        }
        $(".result-window_footer" + ' ul').append('<li><a id="selection_by_sizes"><i class="fa fa-arrows-alt" aria-hidden="true"></i> '+phrase_for_search_by_size+'</a></li>');
        $(".result-window_footer").append('</ul>');
	}else{
        search_by_size_footer();
	} // if
	scrollForResult_footer();
} // insertInWindoeResult_footer

// вывод окна ввода размеров для подбора чехла
function search_by_size_footer() {
    $('.error_msg').remove();
    res_window = ".result-window_footer";
    psa_loader = ".psa-loader_footer";
    $(res_window).html(img_phoneForInputSizes).show();
} // search_by_size

// ajax запрос на поиск и возврат чехлов для выбранного телефона
function getboons_footer(){
	model = $("#InputSearch_footer").val();

    if(model.indexOf(phrase_for_search_by_size) + 1 > 0){
        search_by_size();
        return;
    }

    $('.psa-loader_footer').show();
	$.ajax({
	  type: "POST",
	  url: TRDJS.ajax_url,
	  data: {
		action: 'trd_get_acceptBoons',
		"query": encodeURIComponent(allPhones[model]),
          "lang": encodeURIComponent(lang)
	  },
	  success: function(res){
          $('.psa-loader_footer').hide();
		  if(res.indexOf("</div>")+1 > 1) {
			$('.result_footer .psa-container').html("");
			$('.result_footer').addClass('trd_search_animate_footer');
			$('.result_footer .psa-container').append(res);
			$('.result_footer').show(); //13.03.2018
		  }else if(res.indexOf("</span>")+1 > 1){
              $('.form-group').prepend(res);
              $('.result-window_footer').show();
          }else{
			  $("body").prepend("<div class='trd_overflow'><div></div></div>");
			  window.location.replace(res);
		  } // if
	  } // success
	}); // ajax
} // getboons_footer

// устанавливать скролл для окна результата
function scrollForResult_footer(){
  if ($('.result-window_footer ul').height() > 3) {
      $('.result-window_footer').addClass('overflow');
  }else {
      $('.result-window_footer').removeClass('overflow');
  } // if
} // scrollForResult_footer

// действие для стрелок
function key_activate_footer(n){
    $('.result-window_footer ul li').eq(suggest_selected-1).removeClass('active');

    if(n == 1 && suggest_selected <= suggest_count){
      suggest_selected++;
    }else if(n == -1 && suggest_selected > 1){
      suggest_selected--;
    }

    // если есть элементы для отображения
    if( suggest_selected > 0){
      // функция скроллинга
      if(suggest_selected > 8){
      scrollLock = (suggest_selected - 8) * 37.07;
        $('.result-window_footer').scrollTop(scrollLock);
      }else{ $('.result-window_footer').scrollTop(0);}

      $('.result-window_footer ul li').eq(suggest_selected-1).addClass("active");
      $("#InputSearch_footer").val($('.result-window_footer ul li').eq(suggest_selected-1).text());
    } else {
      $("#InputSearch_footer").val(input_initial_value);
    }
  } // key_activate_footer
/* TRD ----------------------------SEARCH-FOOTER-----------------------------------*/

/*-------------------------TRD Поиск с выбором модели------------------------------*/
curBrand = -1;					// текущий выбранный бренд
// document.getElementById("search_brand_footer").addEventListener("click", trd_search);
// document.getElementById("search_brand_top").addEventListener("click", trd_search);
//
// function trd_search(event){
//
// } // trd_search
$(document).ready(function(){
	// выбор бренда в списке

	$("#search_brand_footer #brand, #search_brand_top #brand").on('change', function(){
	  var curBlock = $(this).parent().parent().parent();
		curBrand = curBlock.find("#brand :selected").val();
		// если выбрали какой-то бренд
		if (curBrand != -1){
			// получем телефоны по бренду и помещаем в #model
			$('.psa-loader_searchtrd').show();
			$.ajax({
				url: TRDJS.ajax_url,
				type: 'POST',
				data: {
					action: 'trd_get_phonesByModel',
					"brand_id": curBrand,
                    "lang": lang
				},
				success: function(res) {
					$('.psa-loader_searchtrd').hide();
          curBlock.find('#model').html("");
          curBlock.find('#model').append(res);
          curBlock.find('#model').removeAttr("disabled");
          curBlock.find("#brand").blur();
				}
			}); // ajax
		}else{
			// очищаем #model
      curBlock.find('#model').html("");
      curBlock.find('#model').append("<option value='-1'>" + trd_getPhraseFromVocabulary("Modell") + "</option>");
      curBlock.find('#model').attr("disabled","disabled");
		} // if
	});// change

	// открытие списка брендов
	$("#search_brand_footer #brand, #search_brand_top #brand").focus(function(){
    var curBlock = $(this).parent().parent().parent();
    curBlock.find('#model').attr("disabled","disabled");
    curBlock.find("#model [value='-1']").attr("selected", "selected");
    curBlock.find("#brand [value='-1']").attr("selected", "selected");
    curBlock.find('.resultByModel').removeClass('trd_search_animate');
	});

	// выбор модели
	$("#search_brand_footer #model, #search_brand_top #model").change(function(){
    var curBlock = $(this).parent().parent().parent();
		$('.psa-loader_searchtrd').show();
        brand = curBlock.find("#brand :selected").text();
		model = curBlock.find("#model :selected").val();
		phone = brand+" "+model;
		$.ajax({
			type: "POST",
			url: TRDJS.ajax_url,
			data: {
				action: 'trd_get_acceptBoons',
				"query": encodeURIComponent(phone),
                "lang": encodeURIComponent(lang)
		},
		success: function(res){
			   // console.log(res);
            $('.psa-loader_searchtrd').hide();
            if(res.indexOf("</div>")+1 > 1) {
              curBlock.find('.resultByModel .psa-container').html("");
              curBlock.find('.resultByModel').addClass('trd_search_animate_footer');
              curBlock.find('.resultByModel .psa-container').append(res);
            }else if(res.indexOf("</span>")+1 > 1){
              curBlock.find('.form-group').prepend(res);
              curBlock.find('.resultByModel').show();
            }else{
              curBlock.find("body").prepend("<div class='trd_overflow'><div></div></div>");
                window.location.replace(res);
		  } // if
		} // success
		}); // ajax
	}); // change

  // setInterval(function () {
  //   $('div').on('click', function () {
  //     $('.resultByModel').each(function () {
  //       if($(this).hasClass('trd_search_animate_footer')){
  //         $(this).find('.psa-container').html('');
  //         $(this).removeClass('trd_search_animate_footer');
  //       }
  //     });
  //   })
  // }, 400);
}); // ready
/*-------------------------TRD Поиск с выбором модели-------------------*/

/*-------------------------TRD удаление title при наведении на ссылки (картинки)-------------------*/
$(document).ready(function(){
	setTimeout(function(){
		$('a').each(function(){
			$(this).attr("title","");
		});
	},10000);
});
/*-------------------------TRD удаление title при наведении на ссылки (картинки)-------------------*/

/*-------------------------TRD Подбор телефона по размеру-------------------*/
$(document).ready(function(){
	// ограничение на ввод только цифр и точки
	$("body").on('keypress', '.ps-trd-input', function(e){

        if($.browser.mozilla) {

            // if($(this).val()!= "" && $(this).val().match(/^(\d|,|\.)*$/) == null){
            //         e.preventDefault();
            //
            //     console.log("Браузер мозила  "+$(this).val());
            //     $(this).val().replace(/!(\d|,|\.)/,"");
            // }
            //
            // console.log($(this).val());

        }
        // ввод не цифр				      ввод не точки		ввод не запятой
        else if((e.keyCode < 48 || e.keyCode > 57) && e.keyCode != 46 && e.keyCode != 44){
			e.preventDefault();
        } // if

	}); // on
}); // ready

// подбор по размерам
function trd_picking_by_sizes(){
	height = $("#height").val();
	width = $("#width").val();
	depth = $("#depth").val();
    lang = getLang();
	// удалить результат прошлого поиска по размеру
	$("result_window_search").remove();


	if(height > 0 && width > 0 && depth > 0){
		$('.psa_loader').show();
		$.ajax({
			type: "POST",
			url: TRDJS.ajax_url,
			data: {
				action: 'trd_searchSize',
				"height": encodeURIComponent(height),
				"width": encodeURIComponent(width),
				"depth": encodeURIComponent(depth),
                "lang": lang
			},

			success: function(res){
                if(res.indexOf("div")+1 > 1) {

                    $('.result_window_search').html(res);
                    $('.result_window_search').show();
                    $('.result-window').hide();
                 }else{
                   $("body").prepend("<div class='trd_overflow'><div></div></div>");
                  window.location.replace(res);
                 } // if
                 $('.psa_loader').hide();
                //console.log(res);
			} // success
		}); // ajax
	}else{
		alert(trd_getPhraseFromVocabulary("Füllen Sie alle Felder aus"));
	} // if
} // trd_picking_by_sizes()
/*-------------------------TRD Подбор телефона по размеру-------------------*/


/*-------------------------TRD Возвращает переведенную фразу из словаря-------------------*/
function trd_getPhraseFromVocabulary(str) {
    result = '';
    lang = getLang();
    $.ajax({
        type: "POST",
        url: TRDJS.ajax_url,
        async: false,
        data: {
            action: 'trd_getVocabulary',
            "string": encodeURI(str),
            "lang": encodeURI(lang)
        },
        success: function(res){
            result = res;
        }, // success
        error: function () {
            result = str;
        }
    }); // ajax

    return result;
}
/*-------------------------TRD Возвращает переведенную фразу из словаря-------------------*/

/*-------------------------TRD получение языка из cookie-------------------*/
function getLang() {
    // lang = ($.cookie('lang')) ? $.cookie('lang') : 'de';

    //добавляем определение языка браузера
    lang = ($.cookie('lang')) ? $.cookie('lang') : null ;
    return lang;     //(lang.length == 2) ? lang : 'de';
} // getLang
/*-------------------------TRD получение языка из cookie-------------------*/

/*-------------------------Плагин для вывода картинок по наведению-------------------*/
$(document).ready(function(){
    a = $("a.woocommerce-main-image.zoom");
    img = a.children('img');
    $('.thumbnails.columns-3').on('mouseover', 'a', function(){
        $(".pp_content_container").attr("style","width:100%");
        a.children('iframe').hide();
        img.show();
        src=$(this).children('img').attr('src');
        src = src.replace('-min','');
        a.attr('href',src);
        img.attr('srcset',src);

        var _brand = $('#rd_brand').text();
        var _model = $('#rd_model').text();
        var _color = $('#rd_color').text();

        img.attr('title', _brand + " " +_model + " " + _color);
        img.attr('alt', _brand + " " +_model + " " + _color);
    }); //mouseover

    // $('.').on('focusin', 'span', function(){
    //     console.log('1123');
    //
    //     var _brand = $('#rd_brand').text();
    //     var _model = $('#rd_model').text();
    //     var _color = $('#rd_color').text();
    //
    //     img.attr('title', _brand + " " +_model + " " + _color);
    //     img.attr('alt', _brand + " " +_model + " " + _color);
    //
    // });



    $("div.pp_nav").on("click", "a", function () {
        console.log($(this).attr('class'));
    })
}); // ready

function changeTitle(){

    a = $("a.woocommerce-main-image.zoom");
    img = a.children('img');

    var _title = $('title').text().split('|')[0];
    var _color = $('#rd_color').text();
    var outputStr = _title + _color;



    img.attr('title', outputStr);
    img.attr('alt', outputStr);

    $('.thumbnails img').each(function(){
        $(this).attr('title', outputStr);
        $(this).attr('alt', outputStr);
    })

}
/*-------------------------Плагин для вывода картинок по наведению-------------------*/

/*-------------------------Кнопка показа видео-------------------*/
$(window).load(function () {
    // показ видео после нажатия по кнопке
    $(".thumbnails.columns-3").on('click', "#trd_video", function () {
      var aVideo = document.getElementById('go');
      if(aVideo) aVideo.click();
    }); // on
}); // load
/*-------------------------Кнопка показа видео-------------------*/

/*-------------------------Добавление параметра для переключателя языков в моделях-------------------*/
$(document).ready(function () {
    if(window.location.search.indexOf('?model=') == 0){
        links = $('.header-right.search-popup .wpml-ls-current-language ul.sub-menu li').children('a');
        attr = window.location.search;
        links.each(function () {
            href = $(this).attr('href') + attr;
            $(this).attr('href', href);
        }) // each
    }; // if
}); // ready
/*-------------------------Добавление параметра для переключателя языков в моделях-------------------*/

/*------------------------------------Работа в словаре-----------------------------------*/
/**
 * Замена текста
 * @param id
 * @param lang
 */
function trdUpdateNotice(id, lang) {
    tr = $('#'+id);                             // блок для редактирования
    newString = tr.find(".trd_second").val();  // текст для вставки

    $.ajax({
        url: TRDJS.ajax_url,
        type: 'POST',
        data: {
            action: 'trd_updateVocabulary',
            "id": encodeURIComponent(id),
            "newString": encodeURIComponent(newString),
            "lang": encodeURIComponent(lang)
        },
        success: function(res) {
            alert(res);
        } // success
    }); // ajax
} // trdUpdateNotice

/**
 * Удаление записи
 * @param id
 */
function trdRemoveNotice(id) {
    tr = $('#'+id);                       // блок для редактирования
    string = tr.find(".trd_main").val();  // текст для вставки

    decision = confirm("Вы уверены, что хотите удалить запись '"+string+"'");
    if(!decision) return;
    $.ajax({
        url: TRDJS.ajax_url,
        type: 'POST',
        data: {
            action: 'trd_removeVocabulary',
            "id": encodeURIComponent(id),
        },
        success: function(res) {
            if(res.length > 2)
                alert(res);
            else{
                tr.remove()
            }
        } // success
    }); // ajax
} // trdRemoveNotice

/*------------------------------------Замена текста в словаре-----------------------------------*/

/*------------------------------------Добавление текста в словарь-----------------------------------*/
function trdAddNotice() {
    newStr = $(".trd_addString").attr('value');  // текст для вставки
    $.ajax({
        url: TRDJS.ajax_url,
        type: 'POST',
        data: {
            action: 'trd_addVocabulary',
            "newStr": encodeURIComponent(newStr),
        },
        success: function(res) {
            alert(res);
        } // success
    }); // ajax
} // trdAddNotice
/*------------------------------------Добавление текста в словарь-----------------------------------*/

/*------------------------------------Формирование данных для zanox-----------------------------------*/
$(window).load(function () {
    href = window.location.href;
    // если находимся на странице корзины
    if(href.indexOf('de/cart/') > 0){
        products = $('table.shop_table.responsive.cart').find('tbody').find('tr.cart_item'); // выбираем все продукты
        var zx_products = [];
        $.each(products,function () {
            id = $(this).find("td.product-remove a").attr("data-product_id");
            amount = $(this).find("td.product-subtotal").text();
            amount = amount.match(/(\d+),(\d+)/g);
            qty = $(this).find("input.input-text.qty.text").val();
            zx_products.push({
                "identifier": id,
                "amount": amount[0],
                "currency": "EUR",
                "quantity": qty
            });
        }); // each
        var zx_language = "de";
    } // if
    // если находимся на странице товара
    else if(href.indexOf('de/shop/') > 0){

        //ссылка на <head>
        var head =  $('head');

        //id товара
        var zx_identifier = $('.variations_form.cart').attr("data-product_id");

        //название товара
        var zx_fn = $.trim($('.dhvc_woo_product_page_custom_field.dhvc_woo_product-meta-field-device_name').eq(1).text());

        //значек валюты
        var currency = $.trim($('.woocommerce-Price-amount.amount').eq(5).find('.woocommerce-Price-currencySymbol').text());

        //текстовое представление цены
        var zx_price = currency +" "+$.trim($('.single_variation_wrap .price').text()).match(/(\d+)\.(\d+)/g);

       // var x = $('.single_variation_wrap .price').text();
       // console.log(x);

        //численное представление цены
        var price = $.trim($('.single_variation_wrap .price').text());
        if (typeof price == "undefined")
          var zx_amount = price.match(/(\d+),(\d+)/g)[0];
        //console.log(zx_amount);

        //добавляем meta в head
        //<meta name="zx:identifier" content="123456789" />
        head.append("<meta name=\"zx:identifier\" content=\"" + zx_identifier + "\" />");

        //<meta name="zx:fn" content="Product Name" />
        head.append("<meta name=\"zx:fn\" content=\"" + zx_fn + "\" />");

        //<meta name="zx:price" content="3,99 €" />
        head.append("<meta name=\"zx:price\" content=\"" + zx_price + "\" />");

        //<meta name="zx:amount" content="3.99" />
        head.append("<meta name=\"zx:amount\" content=\"" + zx_amount + "\" />");

    }//if
});
/*------------------------------------Формирование данных для zanox-----------------------------------*/

/*------------------------------------Функции для GTranslate-----------------------------------*/
// $(document).ready(function () {
//      if(!$.cookie('lang') || $.cookie('lang') != 'de') {
//         if((location.href == location.protocol + '//' + location.host + '/') || (location.href == location.protocol + '//' + location.host)  ) {
//             changeLang('bro_lang');
//         }
//      }
// });
// переключение языка
function changeLang(curLang) {
    //переводим только при переходе на главную страницу
        if (curLang == 'bro_lang') {
            curLang = getLang();                                    // текущий язык страницы

            //gполучаем язык браузера
            var bro_lang = navigator.language.toLowerCase().slice(0, 2);

            if (curLang == null) {
                curLang = bro_lang;
            }
        }

        $.cookie('lang', curLang, {expires: 7, path: '/',});

        request = gt_request_uri.split("?", 2)[0];               // удаляем параметры из GET запроса

        // получение необходимой ссылки для не немецкого языка
        if (curLang.length != 0) {
            request = getCorrLink(request);
        } // if

        curLang = (curLang == 'de') ? '' : curLang;

        request = (request.length == 1) ? '/' : request;         // если переход на главную страницу, то ничего не добавляем

        location.href = location.protocol + '//' + location.host + '/' + curLang + request;
} // changeLang

// возвращает ссылку на немецком языке
function getCorrLink(url) {
    request = '';
    $.ajax({
        url: TRDJS.ajax_url,
        type: 'POST',
        async: false,
        data: {
            action: 'trd_getCorrLink',
            "url": encodeURI(url)
        },
        success: function(res) {
            request = res;
        } // success
    }); // ajax

    return request;
} // getCorrLing()
/*------------------------------------Функции для GTranslate -----------------------------------*/

/*------------------------------------Отметка рейтинга -----------------------------------*/
$(window).load(function () {
    aStars = $('p.stars').find('a');                // список всех "звезд"
    $('p.stars').on('click', 'a', function (e) {    // клик по "звезде"
        e.preventDefault();
        aStars.each(function () {
            $(this).removeClass('active');          // удаляем у всех класс active
        }); // each
        $(this).addClass("active");

        num = $(this).text();                       // получаем выбранную отметку
        // помечаем выбранную отметку в select
        $("#rating option").each(function () {
            $(this).removeAttr('selected');
            if($(this).attr('value') == num) $(this).attr('selected','');
        }) // each
    }); // on
}) // load
/*------------------------------------Отметка рейтинга -----------------------------------*/

/*------------------------------------Переключение способа оплаты -----------------------------------*/
$(window).load(function () {
    if(payMethods = $("ul.wc_payment_methods.payment_methods.methods")){
        payMethods.on("change", "input:radio", function () {
            var input = $(this);
            payMethods.find("input:radio").each(function () {
                if ($(this) != input) {
                    $(this).removeAttr("checked");
                    methodName = $(this).attr("value");
                    $("div.payment_method_" + methodName).hide();
                }
            });
            var methodName = $(this).attr("value");
            $(this).attr("checked", "checked");
            $("div.payment_method_" + methodName).show();

        });
    }

    // перекдючение способа оплаты в Paymill
    if(payMill = document.querySelector("#paymill_payment_form")){
        var paymillMethods = payMill.querySelectorAll(".paymill_form_switch"); // все доступные способы оплаты в Paymill
        paymillMethods.forEach(function (method) {
            method.addEventListener("click", function (event) { // в случае переключения способа
                if (!event.target.classList.contains("paymill_form_switch_active")) { // если выбран не активный способ
                    paymillMethods.forEach(function (method) {
                        if(method.classList.contains("paymill_form_switch_active")) {
                            method.classList.remove("paymill_form_switch_active");
                            payMill.querySelector("#" + method.id.replace("_switch", '')).style.display = "none";
                            payMill.querySelector("#" + event.target.id.replace("_switch", "")).style.display = "block";
                            event.target.classList.add("paymill_form_switch_active");
                            return;
                        }
                    })
                }
            })
        })
    }
})
/*------------------------------------Переключение способа оплаты -----------------------------------*/
/*-------------------------Добавление action к кнопке добавления товара-------------------*/
$(document).ready(function () {

  //  console.log(window.location.pathname.slice(1, 5));

    if(window.location.search.indexOf('/shop/') != 0 && window.location.pathname.slice(1, 5) != "shop"){

        var link = window.location.origin+ window.location.pathname.slice(3, window.location.pathname.length);
       // console.log(link);
       $(".variations_form").attr("action", link);

    }; // if


}); // ready
/*-------------------------Добавление параметра для переключателя языков в моделях-------------------*/

/**/
/*Показать форму входа на странице Checkout woocommerce-info*/
$(document).ready(function () {

    //  console.log(window.location.pathname.slice(1, 5));

    if(window.location.search.indexOf('/checkout') != 0 ){

        $('.showlogin').bind('click', function(){
            // //$('.global-login').show();
            if($('.global-login').css('display') == 'none'){
                $('.global-login').show();
            }else{
                $('.global-login').hide();

            }
            //console.log($('.global-login').prop('disabled'));
        });

    }; // if


}); // ready
/*******************************************************************************************************************/
/****Показать форму расчета доставки*/
$(document).ready(function () {

    //  console.log(window.location.pathname.slice(1, 5));

    if(window.location.search.indexOf('/cart') != 0 ){

        $('.shipping-calculator-button').bind('click', function(){
            $('.shipping-calculator-form').show();
        });

    }; // if


}); // ready
/*-----------------------------------*/
/*----------Запрет покупки товара которого нет на складе-------*/
$(document).ready(function () {
    $('.single_add_to_cart_button').bind('click', function(event){
       // console.log("click");
        if ( $( this ).is('.disabled') ) {

           // return false;
         //   console.log("disabled");
            event.preventDefault();

            if ( $( this ).is('.wc-variation-is-unavailable') ) {
                window.alert( trd_getPhraseFromVocabulary(wc_add_to_cart_variation_params.i18n_unavailable_text) );
            } else if ( $( this ).is('.wc-variation-selection-needed') ) {
                window.alert( wc_add_to_cart_variation_params.i18n_make_a_selection_text );
            }

        }
    });

}); // ready
/*-------------------------------------------------------------*/

/*----------Изменение ссылок для мобильного меню-------*/
$(document).ready(function () {
    // получаем язык страницы
    lang = getLang();
    // если мы находимся не на немецкой версии
    if(lang != 'de') {
        // проходимся по всем элементам меню
        $("#menu-main-menu.mobile-menu.accordion-menu").find("li").each(function () {
            href = this.getElementsByTagName('a')[0].pathname;  // получаем адрес ссылки
            url = href.replace("/"+lang,"");                  // извлекаем динамическую часть
            enURL = getCorrLink(url);                   // получаем адрес для не немецких страниц
            $(this).find('a').attr('href', '/'+lang+enURL);     // меняем адрес в ссылке
        });
    }
});
/*-------------------------------------------------------------*/

/****************Добавляем lazy load к картинкам ******************/
$(document).ready(function () {
    $("img.lazy").lazyload({
        effect : "fadeIn"
    });
});
/*----------------------------------------------------------------*/

/*
* Осветляем вариации, которых нет на складе
*
 */
$(window).load(function () {
    var formValue = $("form.variations_form.cart");     // находим форму с вариациями
    if(formValue != undefined){
        var jsonValue = formValue.attr("data-product_variations"); // получаем данные по всем вариациям из аттрибута
        variations = $.parseJSON(jsonValue);                       // распарсиваем значение
        if($.type(variations) === "array") {
            // for (var variation of variations) {
            for(var i = 0; i < variations.length; i++){
                var variation = variations[i];
                if (!variation["is_in_stock"]) {                   // если данной вариации нет на складе
                    varColor = variation["attributes"]["attribute_pa_color"];
                    $("input[value='" + varColor + "']").parent("label").css("opacity", '0.1');    // осветляем значок вариации
                }
            }
        }
    }
}) // document;
/*----------------------------------------------------------------*/

/*-------------------------------------------------------------*/
/*Добавление нескольких товаров в корзину*/
// $(document).ready(function (e) {
//
//
//     $(".btn_sell").on('click', function(event){
//
//         event.preventDefault();
//
//         //отправка чехла
//         addToCart(109,1);
//
//         //отправка буна
//         addToCart(1240,1);
//
//         //редирект на корзину
//         window.location.href = '/cart/';
//     //return true;
//
//       });
// });

function addMultipleProducts( sku, prod_id){
    //отправка чехла
    var cover = $('#btn_sell').attr("data-varid");
    var color = "";
    var formValue = $("form.variations_form.cart");     // находим форму с вариациями
    if(formValue != undefined){
        var jsonValue = formValue.attr("data-product_variations"); // получаем данные по всем вариациям из аттрибута
        var variations = $.parseJSON(jsonValue);                       // распарсиваем значение
        if($.type(variations) === "array") {
            // for (var variation of variations) {
            for(var i = 0; i < variations.length; i++){
                var variation = variations[i];
                //  console.log(variation);
                if (variation["variation_id"]==cover) {                   // если данной вариации нет на складе
                    var  varColor = variation["attributes"]["attribute_pa_color"];
                    color = varColor;
                }
            }
        }
    }

    var var_sku = $('#trd_sku').val();
   // addToCart(prod_id,cover,color,1,var_sku);

    // console.log(prod_id);
    var boon_sku = sku =='boonflip-XS'||sku =='boonflip-XS2'||sku =='boonflip-XS3'||sku =='boonflip-XS4'||sku =='booncover-XS'||sku =='booncover-XS2'||sku =='booncover-S'||sku =='booncover-S2'||sku =='booncover-S3'?1791:1796;
    var var_sku = sku =='boonflip-XS'||sku =='boonflip-XS2'||sku =='boonflip-XS3'||sku =='boonflip-XS4'||sku =='booncover-XS'||sku =='booncover-XS2'||sku =='booncover-S'||sku =='booncover-S2'||sku =='booncover-S3'?1794:1798;

    //  console.log(boon_sku);
    //отправка буна
    addToCart(boon_sku,var_sku,"",1,0);

    //редирект на корзину
    //window.location.href = '/cart/';
    $('.single_add_to_cart_button')[0].click();
}

//отправка данных в корзину
function addToCart(prod_id,p_id,color,qu, var_sku) {

    var url ='';
    var pa_groesse = $('#sidebar_powerpad_size').text();
    pa_groesse = pa_groesse.toLowerCase();
    pa_groesse = pa_groesse.replace(' ', '-');
    pa_groesse = pa_groesse.replace('(', '');
    pa_groesse = pa_groesse.replace(')', '');
    pa_groesse = pa_groesse.replace('mm', '');

    if(prod_id == p_id) {
        // url = '/cart/?post_type=product&add-to-cart=' + p_id + '&quantity=1';


        url = '/cart/?add-to-cart=' + p_id + '&quantity=1'+'&attribute_pa_groesse='+pa_groesse;
        console.log(url);
    }else{

        //   url = '/cart/?add-to-cart='+prod_id+'&variation_id=' + p_id/*+'&attribute_pa_color=pink'*/ + '&quantity=1';
        url = '/cart/?add-to-cart='+prod_id+'&variation_id=' + p_id + '&quantity=1'+'&attribute_pa_groesse='+pa_groesse;
        console.log(url);
    }

    //if(var_sku!=0) url+="&trd_sku="+var_sku;
    // $.get(url, function() {
    //     // success
    //   //  window.location.href = 'https://www.reboon.de/cart';
    //     console.log(url);
    // });

    $.ajax({
        url: url,
        type: 'get',
        async: false,
        data: {
            //  action: 'nk_add_products',
            //"url": encodeURI(url)
        },
        success: function(res) {
            //console.log(url);

        } // success

    }); // ajax

}//addToCart(p_id,qu)
//отправка данных в корзину
function addToCartPowerpads(prod_id, el) {

    var trd_powerpads = $(el).parent('div').find('ul li.active').find('.trd_price_powerpads');
    var variation_id = trd_powerpads.find('span.trd_pp_var_id').text();
    var pa_groesse = trd_powerpads.find('span.trd_pp_size').text();
    var qu = $(el).parent('div').find('input.pps-prod-counter').val();

    var url ='';
    if(prod_id == variation_id) {
        // url = '/cart/?post_type=product&add-to-cart=' + p_id + '&quantity=1';
        console.log('product');
        url = '/cart/?add-to-cart=' + prod_id + '&quantity='+qu+'&attribute_pa_groesse='+pa_groesse;

    }else{
        console.log('variation');
        //   url = '/cart/?add-to-cart='+prod_id+'&variation_id=' + p_id/*+'&attribute_pa_color=pink'*/ + '&quantity=1';
        url = '/cart/?add-to-cart='+prod_id+'&variation_id=' + variation_id + '&quantity='+qu +'&attribute_pa_groesse='+pa_groesse;

    }

 //   if(var_sku!=0) url+="&trd_sku="+var_sku;
    // $.get(url, function() {
    //     // success
    //   //  window.location.href = 'https://www.reboon.de/cart';
    //     console.log(url);
    // });

    $.ajax({
        url: url,
        type: 'get',
        async: false,
        data: {
            //  action: 'nk_add_products',
            //"url": encodeURI(url)
        },
        success: function(res) {
            window.location.href = '/cart/';

        } // success

    }); // ajax

}//addToCart(p_id,qu)
/*-------------------------------------------------------------*/

/*
* Добавляем класс, если нет sidebar
 */
$(document).ready(function () {
    if(document.getElementById("product_sidebar") == null){
        $(".product-summary-wrap").addClass("without-sidebar");
    }
})
/*----------------------------------------------------------------*/

/*----------------------------------------------------------------*/
/*          Изменение видимой цены для PowerPads                  */
/*----------------------------------------------------------------*/
$(document).ready(function () {
    $('.pps-sizes-price').on('click', 'li', function () {
        $(this).parent('ul').find('li').removeClass('active');
        $(this).addClass('active');
        var price = $(this).find('.trd_price_powerpads span.trd_var_price').html();

        $(this).parent('ul').parent('div').find('div.price').html(price);
    })
}); //ready
/*----------------------------------------------------------------*/

/* --------------------------------------------------*/
/*Добавление трекинга для ladenzeile*/
$(document).ready(function () {
    if(window.location.search.indexOf('/checkout') != 0 ){

        $('body').append(
          "<script type=\"text/javascript\">\n" +
            "    var vmt_pi = {\n" +
            "    'trackingId'\t\t: 'de-CMXLRP3VPQ',\n" +
            "    'version' \t\t: 's_0.0.1'};\n" +
            "  </script>\n" +
            "\n" +
            "  <script type=\"text/javascript\">\n" +
            "    var vmt = {};\n" +
            "    (function(d, p) {\n" +
            "      var vmtr = d.createElement('script'); vmtr.type = 'text/javascript'; vmtr.async = true;\n" +
            "      var cachebuster = Math.round(new Date().getTime() / 1000);\n" +
            "      vmtr.src = ('https:' == p ? 'https' : 'http') + '://www.ladenzeile.de/controller/visualMetaTrackingJs?cb=' + cachebuster;\n" +
            "      var s = d.getElementsByTagName('script')[0]; s.parentNode.insertBefore(vmtr, s);\n" +
            "    })(document, document.location.protocol);\n" +
            "  </script>"
        );
    };
}); //ready

/**
 * Add redirect_to for comment form
 */
$(document).ready(function () {
    $("#commentform").append("<input type='hidden' name='redirect_to' value='"+location.protocol + "//" + location.host+location.pathname+"'>")
})

/*----------------------------------------------------------------*/
/**
 * Work with comments
 */
$(document).ready(function () {
    var comment_form = $("#commentform");

    if(comment_form) {
        var submit = comment_form.find("#submit");      // submit button
        var rest = 20;                                  // rest of words in comment

        // add input for right redirect
        comment_form.append("<input type='hidden' name='redirect_to' value='" + location.protocol + "//" + location.host + location.pathname + "#reviews'>");
        submit.attr("disabled", 'disabled');

        var limitSymbol = $("p.limit_symbol").eq(0);                        // text about rest words

        comment_form.on('keyup', 'textarea[name=\'comment\'], input[name=\'comment_title\']', function () {
            var content = comment_form.find("textarea[name='comment']").val().split(/\s/);      // content of comment
            var title = comment_form.find("input[name='comment_title']").eq(0).val();           // title for comment

            if (content.length >= 20 && title != "") {
                submit.removeAttr("disabled");
                limitSymbol.hide();
            } else {
                submit.attr("disabled", 'disabled');
                limitSymbol.show();
                if(content == ""){
                    rest = 20;
                }else if((20 - content.length) < 0){
                    rest = 0;
                }else{
                    rest = 20 - content.length;
                }

                limitSymbol.find('span').text(rest);
            } // if-else
        }); // on
    } // if
});

// show comments for chosen page
function pageForComments(action, lastPage) {
    var curPage = parseInt($(".active_review_pag").eq(0).text());
    $(".active_review_pag")
        .removeClass("active_review_pag")
        .attr("onclick","pageForComments("+curPage+", " + lastPage + ")")
        .text();

    switch(action){
        case "+1":
            num = curPage + 1;
            break;
        case "-1":
            num = curPage - 1;
            break;
        default:
            num = parseInt(action);
    }

    // hide navigate buttons for first and last pages
    if(lastPage == 1 ) {
        $('.review_nav_prev').addClass('btn_nav_off');
        $('.review_nav_next').addClass('btn_nav_off');
    }else{
        if(num == 1){
            $('.review_nav_prev').addClass('btn_nav_off');
            $('.review_nav_next').removeClass('btn_nav_off');
        }else if(num == lastPage){
            $('.review_nav_prev').removeClass('btn_nav_off');
            $('.review_nav_next').addClass('btn_nav_off');
        }else{
            $('.review_nav_prev').removeClass('btn_nav_off');
            $('.review_nav_next').removeClass('btn_nav_off');
        }
    } // if-else

    $("#review_pagination li").each(function () {
        if($(this).find("p").text() == num)
            $(this)
                .addClass("active_review_pag")
                .attr("onclick",'');
    }) // each

    var product = $("form.cart").eq(0).find("input[name='add-to-cart']").eq(0).attr('value');
    
    $.ajax({
        url: TRDJS.ajax_url,
        type: 'POST',
        data: {
            action: 'trd_getComments',
            "page": num,
            "post_id": product,

        },
        success: function(res) {
            $("#comments_form").html(res);
        }, // success
    }); // ajax
} // pageForComments
/*----------------------------------------------------------------*/

/*----------------------------------------------------------------*/
// checked review
function trd_doneAction(el, id, act){
    var tr = $(el).parent().parent(); // current tr
    $.ajax({
        url: TRDJS.ajax_url,
        type: 'POST',
        data: {
            action: 'trd_doneAction',
            "id": id,
            "act": act,
        },
        success: function(res) {
            if(res == 1) {
                var type = "";
                var img = "";
                if(act){
                    type = "verified_row";
                    img = '<div class="wrap"><img class="verified" src="/images/verified_green.svg" alt="verified"><p class="date_verified">PP veschickt ';

                }else{
                    type = "canceled_row";
                    img = '<div class="wrap"><img class="verified" src="/images/canceled_red.svg" alt="canceled"><p class="date_verified">geschlossen ';
                }

                var date = new Date();
                var strDate = date.getDate()
                    +"."+((date.getMonth()) < 9 ? "0"+(date.getMonth()+1): (date.getMonth()+1))
                    +"."+date.getFullYear();
                tr.addClass(type); // add color for tr
                $(el).parent().html(img+strDate+'</p></div>');       // set img
                tr.find('.trd_review_notice').removeAttr("onclick");       // block notices
                tr.find('.btn_aktion_review').remove();       // block notices
                $(el).attr("onclick", "false");
                $(el).attr("disabled", "disabled");

            }else{
                console.log("Action error.");
            }
        }, // success
    })
}
/*----------------------------------------------------------------*/

/*----------------------------------------------------------------*/
// send Remind
function trd_remindAction(el, id){
    $.ajax({
        url: TRDJS.ajax_url,
        type: 'POST',
        data: {
            action: 'trd_remindAction',
            "id": id,
        },
        success: function(res) {
            var ul = $(el).parent().find('#remind');
            if(ul.find('li').length == 0) ul.prepend('Hinweis-Mail versandt <br>');
            var date = new Date(res*1000);
            console.log(date);
            var strDate = date.getDate()
                +"."+((date.getMonth()) < 9 ? "0"+(date.getMonth()+1): (date.getMonth()+1))
                +"."+date.getFullYear();
            ul.append("<li>"+strDate+"</li>");
            ul.show();

        }, // success
    })
}
/*----------------------------------------------------------------*/

/*----------------------------------------------------------------*/
function editNotice(el, id){
  var td = $(el);
  td.attr('id', "tmp_editNotice");
  $("body").append("<div class='popup';>"+ //Добавляем в тело документа разметку всплывающего окна
    "<div class='popup_bg'></div>"+ // Блок, который будет служить фоном затемненныv
    "<div id='modal_close'>"+
    "<svg version='1.1' id='Capa_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' viewBox='0 0 512 512' xml:space='preserve'>"+
    "<style type='text/css'> .st0{fill:inherit;} </style>"+
    "<g><g id='cross'><g>"+
    "<polygon class='st0' points='512,30.1 482.3,0.5 256,226.4 29.7,0.5 0,30.1 226.3,256 0,481.9 29.7,511.5 256,285.6 482.3,511.5 512,481.9 285.7,256             '/>"+
    "</g> </g> </g> </svg></span></div>"+

    "<div class='popup_content_wrap'>"+
    "<div class='popup_content'>"+

    "<p class='title-presse'>Notiztext eingeben</p>"+
    "<textarea class='notice_aktion' name='popup_textarea_name' id='popup_textarea' cols='30' rows='10'>" +
    td.find('p').text()+
    "</textarea>"+
    "<input onclick='saveNotice(this,"+ id+ ")' class=\"aktion_button\" name=\"send_aktion\" type=\"submit\" id=\"btn_aktion_review_sbm\" value=\"SPEICHERN\">"+

    "</div></div>"+ // Контент всплывающего окна

    "</div>");

    $(".popup").fadeIn(500); // Медленно выводим изображение
    $(".popup").css('display', 'flex');
    $(".notice_aktion").focus();
    $(".popup_bg, #modal_close").click(function(){	// Событие клика на затемненный фон
      $(".popup").fadeOut(500);	// Медленно убираем всплывающее окно
      setTimeout(function() {	// Выставляем таймер
        $(".popup").remove(); // Удаляем разметку всплывающего окна
      }, 500);
    });

}
/*----------------------------------------------------------------*/


/*----------------------------------------------------------------*/
/**
 * Сохранение новой заметки
 *
 * @param el    - текущий элемент
 * @param main  - элемент, который редактируется
 * @param id    - id записи
 */
function saveNotice(el, id){
    var notice = $(el).prev('textarea').val();
    var main = $("#tmp_editNotice");
    $.ajax({
        url: TRDJS.ajax_url,
        type: 'POST',
        data: {
            action: 'trd_saveNotice',
            "id": id,
            "notice": notice
        },
        success: function(res) {
            if(res == 'Success'){
                main.html('<p class="overflow_text">'+notice+'</p>');
                $("#Capa_1").click();
                main.removeAttr("id");
            }
        }, // success
    })
} // saveNotice
/*----------------------------------------------------------------*/

if(modal_close = document.getElementById('modal_close')){
  modal_close.addEventListener('click', function(){document.querySelector('.actionWindow-wrp').style.display = 'none'})
}

if(unsubscribeBtn = document.getElementById('btnAbbetellen')){
  unsubscribeBtn.addEventListener('click', unsubscribe);
}

function unsubscribe() {
  event.preventDefault();
  $.ajax({
    type: "POST",
    url: TRDJS.ajax_url,
    data: {
      action: 'trd_unsubscribe',
    },
    success: function(res){
      console.log(res);
      if(res)
        alert("Sie haben sich erfolgreich von der Liste abgemeldet.");
        location.href = "https://www.reboon.de/"
    } // success
  }); // ajax
}