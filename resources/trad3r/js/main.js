/** TRD
 * Автоподргузка товаров
 *
 */
var Products = {
    autoload:       false,        // выбран метод автоподгрузка
    loading:        false,      // в процессе загрузки товаров
    page:           1,
    issetNextPage:  true,
    spinner:        $("#trd-spinner"),
    init: function(){
        var inputLimit = document.querySelector("#input-limit");
        if(inputLimit){
            var selectedOption = inputLimit.options.selectedIndex;
            if(inputLimit.options[selectedOption].value === 'авто') {
                this.autoload = true;
            }
        }
    },
    loadNextPage: function () {
        var type = '';
        var alias = '';
        var tableType = $('.products-category.list').hasClass('active') ? 'list' : 'grid';
        var pageType = this.getPageType();

        this.spinner.css('display', 'block');
        this.loading = true;
        this.page++;


        var searchParams = location.search.length > 2 ? location.search : "?";
        type = '{{ path("opt.ajax.product.next_page") }}';

        alias = location.pathname.split('/').pop();

        searchParams += '&page_type=' + pageType + '&alias=' + alias + '&alpage=' + this.page + "&table_type=" + tableType;

        var url = type + searchParams;
        $.ajax({
            url: url,
            method: 'GET',
            success: function (data) {
                if(tableType === 'grid') {
                    $(".products-category.grid.active").eq(0).append(data.html);
                }else{
                    $(".products-category.list.active").find('table.product-table-list tbody').eq(0).append(data.html);
                }

                Products.spinner.css('display', 'none');
                Products.loading = false;
                Products.issetNextPage = data.issetNextPage;
                setLoopForImages();
            }
        });
    },
    getPageType: function()
    {
        var pageType = 'catalog';

        if(location.pathname.indexOf('/brands') === 0){
            pageType = 'brands';
        }else if(location.pathname.indexOf('/hit') === 0){
            pageType = 'hit';
        }else if(location.pathname.indexOf('/new') === 0){
            pageType = 'new';
        }else if(location.pathname.indexOf('/waiting') === 0){
            pageType = 'waiting';
        }

        return pageType;
    }
};

Products.init();

$(window).on('scroll', function () {
    var win = $(window);
    var content = $("#content");
    if(content) {
        var screenBottom = win.scrollTop() + win.height();
        var contentOffset = content.offset();
        if(contentOffset) {
            var contentBottom = content.offset().top + content.height();
            //Складываем значение прокрутки страницы и высоту окна, этим мы получаем положение страницы относительно нижней границы окна
            if (screenBottom - (win.height() / 7) >= contentBottom) {
                if (Products.issetNextPage && Products.autoload && !Products.loading) {
                    Products.loadNextPage();
                }
            }
        }
    }
});
/* TRD */


$(document).ready(function () {
    var paginationItem = $('.pagination-item');
    paginationItem.on('click', function () {
        paginationItem.removeClass('active');
        $(this).addClass('active');
    });

    var btnDublicateRow = `
    <button type="button" class="btn btn-box primary" id="btnDublicateRow">
      <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M6.99951 5.229H11.5591V7.19434H6.99951V12.3604H4.91064V7.19434H0.351074V5.229H4.91064V0.456055H6.99951V5.229Z" fill="white"/>
      </svg>
    </button>
    `;
    $(".table-body .table-row")
        .mouseenter(function(){
        $(this).find('.btn-box-wrapper').html(btnDublicateRow).addClass("active");
    })
        .mouseleave(function () {
            $(this).find('.btn-box-wrapper').removeClass("active").html("");
        });

    var horizontalScroller = document.getElementById("horizontal-scroller");
    if (horizontalScroller) {
        horizontalScroller.addEventListener('wheel', function(event) {
            if (event.deltaMode == event.DOM_DELTA_PIXEL) {
                var modifier = 1;
                // иные режимы возможны в Firefox
            } else if (event.deltaMode == event.DOM_DELTA_LINE) {
                var modifier = parseInt(getComputedStyle(this).lineHeight);
            } else if (event.deltaMode == event.DOM_DELTA_PAGE) {
                var modifier = this.clientHeight;
            }
            if (event.deltaY != 0) {
                // замена вертикальной прокрутки горизонтальной
                this.scrollLeft += modifier * event.deltaY;
                event.preventDefault();
            }
        });
    }

    /**
     * Временно на плюсе. Потом перенести на кнопку
     */
    $('.btn-box-wrapper').on('click', '#btnDublicateRow', function () {
        Device.el = $(this).closest('.table-row');
        Device.updateRow();
    });

    var btnOperationsEdit = `
      <button type="button" class="btn btn-dark-blue btn-cancel-change">Отменить</button>
      <button type="button" class="btn btn-primary btn-save-change">Сохранить</button>
    `;

    $('.table-body').on('dblclick', '.editable', function () {
        $(this).addClass('edited');
        let currentRow = $(this).closest('.table-row');
        currentRow.addClass('edited-row');
        $(this).closest('.table-body').addClass('edited-body');
        currentRow.find('.btn-operations .btn-operations-edit').html(btnOperationsEdit);
        Device.el = $(this);
        Device.changeInput();
    })
});

var Device = {
    el: null,
    CLASS_SELECT: 'select',
    CLASS_TEXT: 'text',
    CLASS_CHECKBOX: 'checkbox',
    changeInput: function() {
        console.log(this.el.classList);
        if(this.el.hasClass(this.CLASS_SELECT)) {
            this.getSelectInput();
        }else if(this.el.hasClass(this.CLASS_TEXT)) {
            this.getTextInput();
        }else if(this.el.hasClass(this.CLASS_CHECKBOX)) {
            this.getCheckboxInput();
        }
    },
    getCheckboxInput: function () {
        let input = this.el.find('input').eq(0);
        input.removeAttr('disabled');
    },
    getTextInput: function () {
        let text = this.el.text();
        let input = this.el.find('.input-text');
        input.value = text;
    },
    getSelectInput: function () {
        $.ajax({
            url: '/device/specification/list/' + this.el.data('id'),
            method: 'GET',
            success: function (res) {
                if(res.status === 'success'){
                    let selected = Device.el.find('input').val();
                    let select = Device.createSelect(res.list, selected);
                    Device.el.find('.simple-select-drop-inner').html(select);
                }
            }
        })
    },
    createSelect: function (list, selected) {

        let ul = document.createElement('ul');
        ul.classList.add("simple-select-list");
        ul.setAttribute("role", "listbox");

        for (let el of list) {
            let li = document.createElement('li');
            li.classList.add('simple-select-item');
            li.setAttribute("role", "option");
            li.setAttribute("data-value", el.id);
            li.innerText = el.title;
            if (el.id === selected) {
                li.classList.add("is-active");
            }
            ul.append(li);
        }

        return ul;
    },
    updateRow: function() {
        let deviceId = this.el.data('id');
        let sequenceNumber = this.el.find('.sequence-number').eq(0).text();

        let data = this.getEditedCells();
        $.ajax({
            url: '/device/' + deviceId,
            method: 'POST',
            data: data,
            success: function (res) {
                if(res.status === 'success'){
                    Device.el.html(res.row);
                    Device.el.find('.sequence-number').eq(0).text(sequenceNumber);
                }
            }
        })
    },
    getEditedCells: function () {
        let data = {};
        let cells = this.el.find('.edited');
        
        cells.each(function () {
            let id = $(this).data('id');
            
            let value = null;
            if($(this).hasClass(Device.CLASS_SELECT) || $(this).hasClass(Device.CLASS_TEXT)) {
                value = $(this).find('input').eq(0).val();
            }else if($(this).hasClass(Device.CLASS_CHECKBOX)) {
                value = $(this).find('input:checked') ? 1 : 0;
            }
            data[$(this).data('id')] = value;
        });
        
        return data;
    }
};

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
        if (!$(e.target).closest('.selectmenu').length) {
            $('.selectmenu').removeClass('is-active');
        }
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown').removeClass('active');
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