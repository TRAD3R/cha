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

    /**
     * Клонирование строки
     */
    $('.btn-box-wrapper').on('click', '#btnDublicateRow', function () {
        Device.row = $(this).closest('.table-row');
        Device.body = $(this).closest('.table-body');
        Device.body
            .append("<div class='table-row' data-id='0'>" + Device.row.html() + "</div>")
            ;
        Device.body.find('.table-row').last().find('.editable').first().dblclick();
    });


    $('.table-body').on('dblclick', '.editable', function () {
        Device.row = $(this).closest('.table-row');
        if(!Device.row.hasClass('edited-row')) {
            Device.rowHtml = Device.row.html();
            Device.row.addClass('edited-row');
            Device.body = $(this).closest('.table-body');
            Device.body.addClass('edited-body');
            // currentRow.find('.btn-operations .btn-operations-edit').html(btnOperationsEdit);
            Device.btnSave = createBtnSave(Device);
            Device.btnCancel = createBtnCancel(Device);
            
            Device.row
                .find('.btn-operations .btn-operations-edit')
                .html('')
                .append(Device.btnCancel)
                .append(Device.btnSave)
            ;
        }
        Device.el = $(this);
        Device.changeInput();
    })
    
    
});

var Device = {
    el: null,
    row: null,
    deviceId: 0,
    rowHtml: '',
    body: null,
    btnSave: null,
    btnCancel: null,
    CLASS_SELECT: 'select',
    CLASS_TEXT: 'text',
    CLASS_CHECKBOX: 'checkbox',
    changeInput: function() {
        this.el.addClass('edited');
        
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
        this.deviceId = +this.row.data('id');

        let data = this.getEditedCells();
        $.ajax({
            url: '/device/' + this.deviceId,
            method: 'POST',
            data: data,
            success: function (res) {
                if(res.status === 'success'){
                    Device.row.html(res.row);
                    Device.row.removeClass('edited-row');
                    Device.body.removeClass('edited-body');
                }
            }
        })
    },
    // addDevice: function() {
    //     this.deviceId = +this.row.data('id');
    //
    //     let data = this.getEditedCells();
    //     $.ajax({
    //         url: '/device/' + this.deviceId,
    //         method: 'POST',
    //         data: data,
    //         success: function (res) {
    //             if(res.status === 'success'){
    //                 Device.row.html(res.row);
    //                 Device.row.removeClass('edited-row');
    //                 Device.body.removeClass('edited-body');
    //             }
    //         }
    //     })
    // },
    cancelChanges: function () {
        this.row.html(this.rowHtml);
        Device.row.removeClass('edited-row');
        Device.body.removeClass('edited-body');
    },
    getEditedCells: function () {
        let data = {};
        let cells = this.deviceId > 0 ? '.edited'  : '.editable';
        console.log(this.deviceId, cells);
        this.row.find(cells).each(function () {
            let id = $(this).data('id');
            let value = null;
            if($(this).hasClass(Device.CLASS_SELECT) || $(this).hasClass(Device.CLASS_TEXT)) {
                value = $(this).find('input').eq(0).val();
            }else if($(this).hasClass(Device.CLASS_CHECKBOX)) {
                value = $(this).find('input').prop('checked') ? 1 : 0;
            }
            data[$(this).data('id')] = value;
        });
        
        data['sequenceNumber'] = this.row.find('.sequence-number').eq(0).text();
        
        return data;
    }
};

function createBtnSave(device)
{
    let btn = createBtn("Сохранить", 'change-save', ['btn-primary','btn-save-change']);
    console.log(btn);
    btn.addEventListener('click', () => {
        device.updateRow();
    });
    
    return btn;
}

function createBtnCancel(device)
{
    let btn = createBtn("Отменить", 'change-cancel', ['btn-dark-blue','btn-cancel-change']);

    btn.addEventListener('click', () => {
        device.cancelChanges();
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

/*фильтрация и сортировка столбцов*/
$(document).ready(function() {
    var btnFilterHead = $('.btn-filter-column');
    var dropdownToolAll = $('.column-tool-dropdown');
    var btnfilterCancel = $('.btn-filter-cancel');
    var btnfilterApply = $('.btn-filter-apply');
    var itemTool = $('.column-tool-item');

    // открытие модального окна фильтрации и сортировки
    btnFilterHead.on('click', function(){
        btnFilterHead.removeClass('is-active');
        dropdownToolAll.removeClass('is-active');

        let tableCell = $(this).closest('.table-cell');

        tableCell.find('.column-tool-dropdown').addClass('is-active');
    });

    //кнопка Отмена
    btnfilterCancel.on('click', function() {
        dropdownToolAll.removeClass('is-active');
    });

    // выбор сортировки
    itemTool.on('click', function() {
        itemTool.removeClass('is-active');
        $(this).addClass('is-active');
    });

    // выбираем и убираем состояние checked у checkbox
    $('.column-tool-total > button').on('click', function(){
        var checkboxes = $(this)
            .closest('.column-tool-total')
            .next('.column-tool-list')
            .find("input[type='checkbox']");

        if ($(this).hasClass('btn-select-all')) {
            checkboxes.prop('checked', true);
        } else {
            checkboxes.prop('checked', false);
        }
    });

});



function showModal(){
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