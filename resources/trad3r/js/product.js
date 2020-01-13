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

        that.el.addClass('preloader-cell');
        that.el.find('span.cap').addClass(Gadget.getHiddenClass());
        $.ajax({
            url: url,
            method: 'GET',
            success: function (res) {
                if(res.status === 'success'){
                    if (that.el.hasClass('select-image')) {
                        let select = that.createImageSelect(res.list, that.el.find('img').data('id'))
                    } else {
                        let select = that.createSelect(res.list, that.el.find('select'), that.el.find('span.item-selected').data('id'));
                        select.chosen({
                            disable_search_threshold: 10,
                            no_results_text         : "",
                            search_contains         : true,
                            width                   : '100%'
                        });
                    }
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

    createImageSelect(list, selected) {
        let ul = document.createElement('ul');
        ul.classList.add("simple-select-list");
        ul.setAttribute("role", "listbox");

        for (let el of list) {
            let li = document.createElement('li');
            let img = document.createElement('img');
            li.classList.add('simple-select-item');
            li.setAttribute("role", "option");
            li.setAttribute("data-value", el.id);
            img.src = "/images/swatches/" + el.title;
            img.title = el.title;
            img.alt = el.title;
            li.innerHTML = img;
            if (el.id === selected) {
                li.classList.add("is-active");
            }
            ul.append(li);
        }

        return ul;
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
});

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