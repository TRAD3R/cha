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

document.querySelector('#device_model_chosen').addEventListener('change', ({target}) => {
    alert("Change");
});