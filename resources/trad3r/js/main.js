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
    
    $('.table-body').on('dblclick', '.editable', function () {
        $(this).addClass('edited');
        $(this).closest('.table-row').addClass('edited-row');
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
        let input = document.createElement('input');
        input.type = 'text';
        input.value = text;
        this.el.html(input);
    },
    getSelectInput: function () {
        $.ajax({
            url: '/device/specification/list/' + this.el.data('id'),
            method: 'GET',
            success: function (res) {
                if(res.status === 'success'){
                    let select = Device.createSelect(res.list);
                    Device.el.html(select);
                }
            }
        })
    },
    createSelect: function (list) {
        let select = document.createElement('select');

        for (let el of list) {
            let option = document.createElement('option');
            option.value = el.id;
            option.innerText = el.title;
            select.append(option);
        }

        return select;
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
            if($(this).hasClass(Device.CLASS_SELECT)) {
                value = $(this).find('select').eq(0).find('option:selected').val();
            }else if($(this).hasClass(Device.CLASS_TEXT)) {
                value = $(this).find('input').eq(0).val();
            }else if($(this).hasClass(Device.CLASS_CHECKBOX)) {
                value = $(this).find('input:checked') ? 1 : 0;
            }
            data[$(this).data('id')] = value;
        });
        
        return data;
    }
};

