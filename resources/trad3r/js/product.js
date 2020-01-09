const BOX_WRAPPER = $('.btn-box-wrapper');

class Product extends Gadget
{
    constructor() {
        let params = getAllUrlParams(location.search);
        super(params[PAGE], params[PER_PAGE], params[SORT_ASC], params[SORT_DESC]);
    }

    getSelectInput() {
        let url = '/products/specification/list/' + this.el.data('id');
        super.getSelectInput(url);
    }

    deleteRow() {
        super.deleteRow('/products/remove/');
    }

    updateRow() {
        super.updateRow('/products/');
    }
}

var gadget = new Product();

$(document).ready(function () {
    $('#new-product-parent').on('click', function () {
        newRow('empty-row-parent');
    });
    $('#new-product-child').on('click', function () {
        newRow('empty-row-child');
    });
});

function newRow(newRowId) {
    let tableBody = $('.' + TABLE_BODY_CLASS);
    let rowTemplate = $('#' + newRowId);
    let newRow = document.createElement('div');
    newRow.classList.add(TABLE_ROW_CLASS);
    newRow.setAttribute('data-id', 0);
    newRow.innerHTML = rowTemplate.html();
    tableBody.append(newRow);
    let rows = tableBody.find('.' + TABLE_ROW_CLASS);
    scrollToEditedRow(rows.last());
}