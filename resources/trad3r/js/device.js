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

    /**
     * Работа с модальным окном
     * для добавления новых элементов в select
     * @param el
     */
    showModal(el) {
        showModal();
        $(el).closest('.simple-select-drop').find('ul.simple-select-list').attr('id', Gadget.getEditedSelectClass());
    }
    
    hideModal(isChange){
        let editedSelect = $("#" + Gadget.getEditedSelectClass());
        if(isChange) {
            let newValue = $('#id-edited-textarea').val();
            if(newValue.length > 0) {
                let li = '<li class="simple-select-item" role="option" data-value="' + newValue + '">' + newValue + '</li>';
                editedSelect.append(li);
            }
        }

        editedSelect.removeAttr('id');
        
        hideModal();
    }
}

var gadget = new Device();

$(document).ready(function () {
    // $('#device-model').chosen({
    //     disable_search_threshold: 10,
    //     no_results_text         : "",
    //     search_contains         : true,
    //     width                   : '100%'
    // }).change(function() {
    //     let deviceId = +$(this).val();
    //     gadget.update(deviceId);
    // });
});

$('#new-device').on('click', function () {
    $(this).addClass(Gadget.getHiddenClass());

    let newRow = $('#empty-row');
    let tableBody = $('.table-body');
    tableBody.append("<div class='table-row' data-id='0'>" + newRow.html() + "</div>");
    scrollToEditedRow(tableBody.find('.table-row').last());
});