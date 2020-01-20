/**
 * Клонирование строки
 */

BOX_WRAPPER.on('click', '#btnDublicateRow', function () {
    gadget.row = $(this).closest('.table-row');
    gadget.body = $(this).closest('.table-body');
    gadget.body
        .append("<div class='table-row' data-id='0'>" +  gadget.row.html() + "</div>")
    ;
    let lastRow =  gadget.body.find('.table-row').last();
    scrollToEditedRow(lastRow);
});

/**
 * Удаление строки
 */
BOX_WRAPPER.on('click', '#btnDeleteRow', function () {
    gadget.row = $(this).closest('.table-row');
    gadget.body = $(this).closest('.table-body');
    gadget.deleteRow();
});


$('.table-body').on('dblclick', '.editable', function () {

    gadget.el = $(this);
    gadget.row =  gadget.el.closest('.table-row');

    if(!gadget.row.hasClass('edited-row')) {
        editRow(gadget);
    }

    gadget.changeInput();
});

$("#per_page").on('change', function () {
    let perPage = $(this).val();
    gadget.changePerPage(perPage);
});

$('.btn-remove-sort').on('click', function () {
    gadget.removeSort($(this).data('key'));
});

$(document).ready(function () {
    var paginationItem = $('.pagination-item');
    paginationItem.on('click', function () {
        paginationItem.removeClass('active');
        $(this).addClass('active');
    });
    
    $(".table-body")
        .on("mouseenter", ".table-row:not(.edited-row)", function(){
        addDoubleBtn($(this));
    })
        .on("mouseleave", ".table-row:not(.edited-row)", function(){
        removeDoubleBtn($(this));
    });

    $('.chosen-select')
        .chosen({
            disable_search_threshold: 10,
            no_results_text         : "",
            search_contains         : true,
            width                   : '100%'
        });
    $('body').on('click', '.chosen-select', function () {
        $(this).chosen({
            disable_search_threshold: 10,
            no_results_text         : "",
            search_contains         : true,
            width                   : '100%'
        });
    });
});



/**
 * Подготовка стоки к редактированию
 * @param gadget
 */
function editRow(gadget) {
    var btnDeleteRow = `
    <button type="button" class="btn btn-box btn-red" id="btnDeleteRow">
        <svg width="14" height="18" viewBox="0 0 14 18" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M1 16C1 17.1 1.9 18 3 18H11C12.1 18 13 17.1 13 16V4H1V16ZM3 6H11V16H3V6ZM10.5 1L9.5 0H4.5L3.5 1H0V3H14V1H10.5Z" fill="white"/>
        </svg>
    </button>
    `;

    gadget.rowHtml = gadget.row.html();
    gadget.row.addClass('edited-row');
    gadget.body = gadget.el.closest('.table-body');
    gadget.body.addClass('edited-body');
    gadget.btnSave = createBtnSave(gadget);
    gadget.btnCancel = createBtnCancel(gadget);

    $('.btn-operations .btn-operations-edit')
        .html('')
        .append(gadget.btnCancel)
        .append(gadget.btnSave)
    ;
    $('.btn-operations').addClass('is-active');

    $('body').addClass('operations-process');

    gadget.row
        .find(".btn-box-wrapper")
        .html(btnDeleteRow);

    $('#new-device').addClass(Gadget.getHiddenClass());
}

/**
 * Прокрутка экрана к редактируемой строке
 * @param row
 */
function scrollToEditedRow(row) {
    removeDoubleBtn(row);
    $('.table-body-wrapper').animate({scrollTop: row.offset().top + 50}, 500);
    row.find('.editable').first().dblclick();
}

/**
 * Добавление кнопки дублирования строки
 * @param row
 */
function addDoubleBtn(row) {
    var btnDublicateRow = `
    <button type="button" class="btn btn-box primary" id="btnDublicateRow">
      <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M6.99951 5.229H11.5591V7.19434H6.99951V12.3604H4.91064V7.19434H0.351074V5.229H4.91064V0.456055H6.99951V5.229Z" fill="white"/>
      </svg>
    </button>
    `;

    row.find('.btn-box-wrapper').html(btnDublicateRow).addClass("active");
}

/**
 * Удаление кнопки дублирования строки
 * @param row
 */
function removeDoubleBtn(row) {
    row.find('.btn-box-wrapper').removeClass("active").html("");
}

/**
 * Работа с кнопками сохранения и отмены
 * @param gadget
 * @returns {HTMLButtonElement}
 */
function createBtnSave(gadget)
{
    let btn = createBtn("Сохранить", 'change-save', ['btn-primary','btn-save-change']);
    btn.addEventListener('click', () => {
        gadget.updateRow();
    });
    
    return btn;
}

function createBtnCancel(gadget)
{
    let btn = createBtn("Отменить", 'change-cancel', ['btn-dark-blue','btn-cancel-change']);

    btn.addEventListener('click', () => {
        gadget.cancelChanges();
    });

    return btn;
}

function createBtn(text, id, classes)
{
    let btn = document.createElement('button');
    btn.type = 'button';
    btn.id = id;
    btn.classList.add('btn');
    for (let cl of classes) {
        btn.classList.add(cl);
    }
    
    btn.innerText = text;
    
    return btn;
}
/** Работа с кнопками сохранения и отмены */

/**
 * Показать модальное окно
 */
function showModal(){
    $('#id-edited-textarea').focus();
    $('.modal-overlay').addClass('active');
    $('.modal').addClass('active');
    $('.site').addClass('modal-open');
    $("body, html").css("overflow", "hidden");
}

function hideModal(){
    $('.modal-overlay').removeClass('active');
    $('.modal').removeClass('active');
    $('.site').removeClass('modal-open');
    $("body, html").css("overflow", "hidden auto");
}
/** Работа с модальным окном для добавления новых элементов в select */

/* кастомный select */
$(function () {
    $(document).on('click.simple-select', '.simple-select .simple-select-main', function (e) {
        let $dropdown = $(this).closest('.simple-select');

        $('.simple-select').not($dropdown).removeClass('is-active');
        $dropdown.toggleClass('is-active');
        if (e.originalEvent) {$dropdown.find('.focus').removeClass('focus'); return;}
        if ($dropdown.hasClass('is-active')) {
            $dropdown.find('.focus').removeClass('focus');
            if ($dropdown.find('.simple-select-item.is-active').length) {
                $dropdown.find('.is-active').addClass('focus');
            } else {
                $dropdown.find('.simple-select-item').first().addClass('focus');
            }
        } else {
            $dropdown.focus();
        }
    });
    $(document).on('click.simple-select', '.simple-select .simple-select-item:not(.is-active)', function (e) {
        let val = $(this).data('value');
        let select = $(this).closest('.simple-select');
        let text = $(this).text();

        select.removeClass('is-active');
        select.find('.simple-select-item').removeClass('is-active');
        select.find('.simple-select-selected').text(text);
        select.find('input').val(val).change();
        $(this).addClass('is-active').blur();//blur для закрытия списка, из-за стилей, которые позволяют открыть список при фокусе на эл. списка
    });
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.simple-select').length) {
            $('.simple-select').removeClass('is-active');
        }
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown').removeClass('is-active');
        }
    });
    $(document).on('keydown.simple-select', '.simple-select', function(event) {
        let $dropdown = $(this);
        let $toggle = $dropdown.find('.simple-select-main');
        let $focused_option = $($dropdown.find('.focus') || $dropdown.find('.simple-select-item.is-active'));
        $focused_option.length === 0 ? $focused_option = $dropdown.find('.simple-select-item').first() : '';
        if (event.keyCode === 32 || event.keyCode === 13) {// Space or Enter
            if ($dropdown.hasClass('is-active')) {
                $focused_option.trigger('click');
            } else {
                $toggle.trigger('click');
            }
            return false;
        } else if (event.keyCode === 40) {// Down
            if (!$dropdown.hasClass('is-active')) {
                $toggle.trigger('click');
            } else {
                let $next = $focused_option.nextAll('.simple-select-item:not(.disabled)').first();
                if ($next.length > 0) {
                    $dropdown.find('.focus').removeClass('focus');
                    $next.addClass('focus');
                }
            }
            return false;
        } else if (event.keyCode === 38) {// Up
            if (!$dropdown.hasClass('is-active')) {
                $toggle.trigger('click');
            } else {
                var $prev = $focused_option.prevAll('.simple-select-item:not(.disabled)').first();
                if ($prev.length > 0) {
                    $dropdown.find('.focus').removeClass('focus');
                    $prev.addClass('focus');
                }
            }
            return false;
        } else if (event.keyCode === 27) {// Esc
            if ($dropdown.hasClass('is-active')) {
                $toggle.trigger('click');
            }
        } else if (event.keyCode === 9) {// Tab
            if ($dropdown.hasClass('is-active')) {
                return false;
            }
        }
    });
});
/* кастомный select */

/*фильтрация и сортировка столбцов*/
$(document).ready(function() {
    var btnFilterHead = $('.btn-filter-column');
    var dropdownToolAll = $('.column-tool-dropdown');
    var btnfilterCancel = $('.btn-filter-cancel');
    var btnfilterApply = $('.btn-filter-apply');
    var itemTool = $('.column-tool-item');

    // открытие модального окна фильтрации и сортировки
    btnFilterHead.on('click', function(e){
        e.stopPropagation();
        dropdownToolAll.removeClass('is-active');
        let tableCell = $(this).closest('.table-cell');
        tableCell.find('.column-tool-dropdown').addClass('is-active');
    });

    //кнопка Отмена
    //закрытие модального окна сортировки
    btnfilterCancel.on('click', function() {
        dropdownToolAll.removeClass('is-active');
    });

    $('body').on('click', 'div', function (e) {
        if ($(".dropdown.is-active").length && !$(e.target).closest('.is-active').length) {
            e.stopPropagation();
            $('.dropdown').removeClass('is-active');
        }
    });

    // выбираем и убираем состояние checked у checkbox
    $('body').on('click', '.column-tool-total > button', function(){
        var checkboxes = $(this)
            .closest('.column-tool-total')
            .next('ul')
            .find("input[type='checkbox']");

        if ($(this).hasClass('btn-select-all')) {
            checkboxes.prop('checked', true);
        } else {
            checkboxes.prop('checked', false);
        }
    });
});

function sort(type, param) {
    Device.addSort(type, param);
}

/*dropdown*/
$(document).ready(function() {
    $('body').on('click', '.dropdown', function(){
        $(this).addClass('is-active');
    });

    $('.preloader').addClass('hidden-el');
    
    


    var selectProduct = `
        <div class="btn btn-dark-blue dropdown">
        <span class="btn-text">Выбрать товар</span>
        <span class="icon ml">
            <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"></path>
            </svg>
          </span>
        <div class="dropdown-list">
          <div class="column-tool-total">
              <button type="button" class="btn-select-all">Выбрать все</button>
              <button type="button" class="btn-remove-all disabled">Убрать все</button>
          </div>
          <ul>
            <li class="dropdown-list-item">
            <label class="checkbox">
                <input type="checkbox" />
                <span class="checkbox-box">
                  <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">
                  <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>
                  </svg>
                </span>
                <span class="checkbox-text">Product #1</span>
            </label>
            </li>
            <li class="dropdown-list-item">
            <label class="checkbox">
                <input type="checkbox" />
                <span class="checkbox-box">
                  <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">
                  <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>
                  </svg>
                </span>
                <span class="checkbox-text">Product #1</span>
            </label>
            </li>
            <li class="dropdown-list-item">
            <label class="checkbox">
                <input type="checkbox" />
                <span class="checkbox-box">
                  <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">
                  <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>
                  </svg>
                </span>
                <span class="checkbox-text">Product #1</span>
            </label>
            </li>
            <li class="dropdown-list-item">
            <label class="checkbox">
                <input type="checkbox" />
                <span class="checkbox-box">
                  <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">
                  <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>
                  </svg>
                </span>
                <span class="checkbox-text">Product #1</span>
            </label>
            </li>
            <li class="dropdown-list-item">
            <label class="checkbox">
                <input type="checkbox" />
                <span class="checkbox-box">
                  <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">
                  <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>
                  </svg>
                </span>
                <span class="checkbox-text">Product #1</span>
            </label>
            </li>
          </ul>
        </div>
      </div>
    `;

    var inputDateRange = `
        <div class="input-date-range">
          <div class="form-group inline-form">
            <label for="date-from">От:</label>
            <input type="date" id="date-start">
          </div>  
          <div class="form-group inline-form">
            <label for="date-from">До:</label>
            <input type="date" id="date-end">
          </div>
        </div>   
    `;
    $("#listing-to-device").on('click', function(){
        $('.btn-operations .btn-operations-edit')
            .html('')
            .append(inputDateRange)
            .append(selectProduct)
            // .append(gadget.btnCancel)
        ;
        $('.btn-operations').addClass('is-active');
        $('body').addClass('operations-process');

    })
});