const BOX_WRAPPER = $('.btn-box-wrapper');

class Product extends Gadget
{
    constructor() {
        let params = getAllUrlParams(location.search);
        super(params[PAGE], params[PER_PAGE], params[SORT_ASC], params[SORT_DESC]);
    }

    getSelectInput() {
        let url = '/products/specification/list/' + this.el.data('id');
        let that = this;
        
        $.ajax({
            url: url,
            method: 'GET',
            success: function (res) {
                if(res.status === 'success'){
                    let select = that.el.find('select');
                    for (let item of res.list) {
                        let option = document.createElement('option');
                        option.value = item.id;
                        option.innerText = item.title;
                        select.append(option);
                    }
                    
                    select.chosen({
                        disable_search_threshold: 10,
                        no_results_text         : "",
                        search_contains         : true,
                        width                   : '100%'
                    });
                }
            }
        })
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