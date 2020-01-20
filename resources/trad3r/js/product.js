
class Product extends Gadget
{
    constructor() {
        let params = getAllUrlParams(location.search);
        super(params[PAGE], params[PER_PAGE], params[SORT_ASC], params[SORT_DESC]);
    }

    getSelectInput() {
        let url = '/products/specification/list/' + this.el.data('id');
        let that = this;

        that.el.addClass('preloader-cell');
        that.el.find('span.cap').addClass(Gadget.getHiddenClass());
        $.ajax({
            url: url,
            method: 'GET',
            success: function (res) {
                if(res.status === 'success'){
                    let select = that.createSelect(res.list, that.el.find('select'), that.el.find('span.item-selected').data('id'));
                    
                    select.chosen({
                        disable_search_threshold: 10,
                        no_results_text         : "",
                        search_contains         : true,
                        width                   : '100%'
                    });
                        
                    that.el.removeClass('preloader-cell');
                }
            }
        })
    }
    
    createSelect(list, select, isset) {
        let selectedValues = [];
        
        if(typeof isset === 'string'){
            selectedValues = isset.split(',');
        }

        for (let item in list) {
            let option = document.createElement('option');
            option.value = list[item].id;
            option.innerText = list[item].title;
            if(selectedValues.includes(list[item].id)) {
                option.selected = true;
            }
            select.append(option);
        }

        return select;
    }

    getEditedCells() {
        let data = {};
        let cells = this.gadgetId > 0 ? '.edited'  : '.editable';

        this.row.find(cells).each(function () {
            let id = $(this).data('id');
            let value = null;
            if($(this).hasClass(Gadget.getTextClass())) {
                value = $(this).find('input').eq(0).val();
            }else if($(this).hasClass(Gadget.getTextareaClass())) {
                value = $(this).find('textarea').val();
            }else if($(this).hasClass(Gadget.getCheckboxClass())) {
                value = $(this).find('input').prop('checked') ? 1 : 0;
            }else if($(this).hasClass(Gadget.getSelectClass())) {
                let selected = [];
                $(this).find('.search-choice, .chosen-single').each(function () {
                    selected.push($(this).find('span').text());
                });
                value = selected.join(",");
                
            }
            data[$(this).data('id')] = value;
        });
            
        return data;
    }

    deleteRow() {
        super.deleteRow('/products/remove/');
    }

    updateRow() {
        super.updateRow('/products/');
    }

    /**
     * Работа с модальным окном
     * для добавления новых элементов в select
     * @param el
     */
    showModal(el) {
        showModal();
        $(el).closest('.table-cell').attr('id', Gadget.getEditedSelectClass());
        $('#id-edited-textarea').val($(el).val());
    }

    hideModal(isChange){
        let editedCell = $("#" + Gadget.getEditedSelectClass());
        if(isChange) {
            let newValue = $('#id-edited-textarea').val();
            editedCell.find('textarea').text(newValue);
            editedCell.find('span').text(newValue);
        }

        editedCell.removeAttr('id');

        hideModal();
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
    $('#new-product-individual').on('click', function () {
        newRow($(this), 'empty-row-individual', -1);
    });
});

function newRow(el, newRowId, data_id = 0) {
    el.closest('.dropdown').removeClass('is-active');
    let tableBody = $('.' + TABLE_BODY_CLASS);
    let rowTemplate = $('#' + newRowId);
    let newRow = document.createElement('div');
    newRow.classList.add(TABLE_ROW_CLASS);
    newRow.setAttribute('data-id', data_id);
    newRow.innerHTML = rowTemplate.html();
    tableBody.append(newRow);
    let rows = tableBody.find('.' + TABLE_ROW_CLASS);
    scrollToEditedRow(rows.last());
}