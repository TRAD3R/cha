const BOX_WRAPPER = $('.btn-box-wrapper');

class Device extends Gadget
{
    constructor() {
        let params = getAllUrlParams(location.search);
        super(params[PAGE], params[PER_PAGE], params[SORT_ASC], params[SORT_DESC]);
    }

    getSelectInput() {
        let url = '/devices/specification/list/' + this.el.data('id');
        super.getSelectInput(url);
    }

    deleteRow() {
        super.deleteRow('/devices/remove/');
    }

    updateRow() {
        super.updateRow('/devices/');
    }
}

var device = new Device();

/**
 * Клонирование строки
 */
BOX_WRAPPER.on('click', '#btnDublicateRow', function () {
     device.row = $(this).closest('.table-row');
     device.body = $(this).closest('.table-body');
     device.body
        .append("<div class='table-row' data-id='0'>" +  device.row.html() + "</div>")
    ;
    let lastRow =  device.body.find('.table-row').last();
    scrollToEditedRow(lastRow);
});

/**
 * Удаление строки
 */
BOX_WRAPPER.on('click', '#btnDeleteRow', function () {
     device.row = $(this).closest('.table-row');
     device.body = $(this).closest('.table-body');
     device.deleteRow();
});


$('.table-body').on('dblclick', '.editable', function () {
    
     device.el = $(this);
     device.row =  device.el.closest('.table-row');

    if(! device.row.hasClass('edited-row')) {
        editRow( device);
    }

     device.changeInput();
});

$("#per_page").on('change', function () {
    let perPage = $(this).val();
     device.changePerPage(perPage);
});

$('.btn-remove-sort').on('click', function () {
     device.removeSort($(this).data('key'));
});