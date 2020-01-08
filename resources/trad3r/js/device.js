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

var gadget = new Device();

$(document).ready(function () {
    $('#device-model').chosen({
        disable_search_threshold: 10,
        no_results_text         : "",
        search_contains         : true,
        width                   : '100%'
    }).change(function() {
        let deviceId = +$(this).val();
        gadget.update(deviceId);
    });
});