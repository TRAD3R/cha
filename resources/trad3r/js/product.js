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