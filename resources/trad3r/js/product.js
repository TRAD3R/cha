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
        
        that.el.find('span.cap').addClass(HIDDEN_EL_CLASS);
        $.ajax({
            url: url,
            method: 'GET',
            success: function (res) {
                if(res.status === 'success'){
                    let select = createChosenSelect(that.el.find('select'), res.list);
                    
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
        newRow($(this), 'empty-row-parent');
    });
    $('#new-product-child').on('click', function () {
        newRow($(this), 'empty-row-child');
    });
});

function createChosenSelect(select, list) {
    for (let item in list) {
        let option = document.createElement('option');
        option.value = list[item].id;
        option.innerText = list[item].title;
        select.append(option);
    }
    
    return select;
}

function newRow(el, newRowId) {
    el.closest('.dropdown').removeClass('is-active');
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