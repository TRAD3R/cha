var allPhones = null;                       // объект всех телефонов из БД
var inputSearch = $('.search-select-input');	// поле поиска
var trd_result = '';				        // окно вывода подсказки
var res_window = $('.search-select-list');		// окно вывода результата

/* TRD ----------------------------SEARCH-----------------------------------*/
$(document).ready(function(){
	var arrPhones = ('Пустой массив');				// массив для хранения всех телефонов
	trd_getAllPhones();
	
	$(inputSearch).on('focus', function () {
        $(this).addClass('is-active');
    });
    $(inputSearch).on('blur', function () {
        $(this).removeClass('is-active');
    });

    // чтение ввода с клавиатуры
    $(inputSearch).keyup(function(e){
        e.preventDefault();

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
        url: 'devices/search',
        type: 'GET',
        data: {},
        success: function(res) {
            if(res.status){
                arrPhones = res.models;
            }
        }, // success
        error: function () {
            arrPhones = ['Проверьте лог-файл'];
        }
    }); // ajax
} // trd_getAllPhones

// выбираем все элементы, которые подходят для запроса
function searchModelsInArray(str) {
	str = str.trim().toUpperCase();	// перевод строки запроса в верхний регистр (для удобства сравнения)
	words = str.split(' ');		// разделение строки запроса по пробелам
	arr = [];           		// массив для результата

    // проверяем все элементы на соответствие запросу
    for (i = 0; i < arrPhones.length; i++) {
        matches = 0;			// количество слов, которые есть в названии из строки
        for (j = 0; j < words.length; j++) {
            // если в названии есть это слово
            if (arrPhones[i].title.toUpperCase().indexOf(words[j]) != -1) {
                // увеличиваем количество на 1
                matches++;
            } // if
        } // for j
        // если все слова есть в названии, то добавляем название в список
        if (matches === words.length) {
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
		res_window.html("").show();
		res_window.append('<ul>');
		for(var i in arr){
			if(arr[i] != ''){
				// добавляем слою позиции
				res_window.append('<li><a href="/devices?gadget=' + arr[i].id + '">'+ arr[i].title +'</a></li>');
			}
		}
		
		res_window.closest('.search-select-results').addClass('is-active');
	}
	scrollForResult();
} // insertInWindoeResult

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