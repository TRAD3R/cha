class Gadget
{
    constructor(page, perPage, sortAsc, sortDesc) {
        this.el = null;
        this.row = null;
        this.deviceId = 0;
        this.rowHtml = '';
        this.body = null;
        this.page = page;
        this.perPage = perPage;
        this.sortAsc = sortAsc;
        this.sortDesc = sortDesc;
    }

    static getSelectClass(){ return 'select'; }
    static getTextClass(){ return 'text'; }
    static getCheckboxClass(){ return 'checkbox'; }
    static getHiddenClass(){ return 'hidden-el'; }
    static getEditedSelectClass(){ return 'edited-select'; }

    changeInput() {
        this.el.addClass('edited');

        if(this.el.hasClass(Gadget.getSelectClass())) {
            this.getSelectInput();
        }else if(this.el.hasClass(Gadget.getTextClass())) {
            this.getTextInput();
        }else if(this.el.hasClass(Gadget.getCheckboxClass())) {
            this.getCheckboxInput();
        }
    }

    getCheckboxInput() {
        let input = this.el.find('input').eq(0);
        input.removeAttr('disabled');
    }

    getTextInput() {
        let text = this.el.text();
        let input = this.el.find('.input-text');
        input.value = text;
    }

    getSelectInput(url = '') {
        let that = this;
        $.ajax({
            url: url,
            method: 'GET',
            success: function (res) {
                if(res.status === 'success'){
                    let selected = that.el.find('input').val();
                    let select = that.createSelect(res.list, selected);
                    that.el.find('.simple-select-drop-inner').html(select);
                }
            }
        })
    }

    createSelect(list, selected) {
        let ul = document.createElement('ul');
        ul.classList.add("simple-select-list");
        ul.setAttribute("role", "listbox");

        for (let el of list) {
            let li = document.createElement('li');
            li.classList.add('simple-select-item');
            li.setAttribute("role", "option");
            li.setAttribute("data-value", el.id);
            li.innerText = el.title;
            if (el.id === selected) {
                li.classList.add("is-active");
            }
            ul.append(li);
        }

        return ul;
    }

    deleteRow(url = '') {
        let id = this.row.data('id');
        $.ajax({
            url: url + id,
            method: 'GET',
            success: function (res) {
                if(res.status === 'success'){
                    Device.row.remove();
                    Device.body.removeClass('edited-body');
                    $("#new-device").removeClass(Gadget.getHiddenClass());
                }
            }
        })
    }

    updateRow(url = '') {
        this.deviceId = +this.row.data('id');

        let that = this;
        let data = this.getEditedCells();
        $.ajax({
            url: url + this.deviceId,
            method: 'POST',
            data: data,
            success: function (res) {
                if(res.status === 'success'){
                    that.row.html(res.row);
                    that.row.removeClass('edited-row');
                    that.body.removeClass('edited-body');
                }

                $('.btn-operations').removeClass("is-active");
                $("#new-device").removeClass(Gadget.getHiddenClass());
            }
        })
    }

    cancelChanges () {
        this.row.data('id') > 0 ? this.row.html(this.rowHtml) : this.row.remove();
        this.row.removeClass('edited-row');
        this.body.removeClass('edited-body');
        $('.btn-operations').removeClass("is-active");

        $("#new-device").removeClass(Gadget.getHiddenClass());
    }

    getEditedCells() {
        let data = {};
        let cells = this.deviceId > 0 ? '.edited'  : '.editable';

        this.row.find(cells).each(function () {
            let id = $(this).data('id');
            let value = null;
            if($(this).hasClass(Gadget.getSelectClass()) || $(this).hasClass(Gadget.getTextClass())) {
                value = $(this).find('input').eq(0).val();
            }else if($(this).hasClass(Gadget.getCheckboxClass())) {
                value = $(this).find('input').prop('checked') ? 1 : 0;
            }
            data[$(this).data('id')] = value;
        });

        data['sequenceNumber'] = this.row.find('.sequence-number').eq(0).text();

        return data;
    }

    changePerPage(perPage) {
        this.perPage = perPage;
        this.update();
    }

    addSort(type, param) {
        let sortAsc = this.strToArray(this.sortAsc);
        let sortDesc = this.strToArray(this.sortDesc);

        let res = {};
        if(type === SORT_ASC) {
            res = this.addSortParam(sortAsc, sortDesc, +param);
            this.sortAsc = res.sortIn.join(',');
            this.sortDesc = res.sortOut.join(',');
        }else{
            res = this.addSortParam(sortDesc, sortAsc, +param);
            this.sortDesc = res.sortIn.join(',');
            this.sortAsc = res.sortOut.join(',');
        }

        this.update();
    }

    removeSort(param) {
        this.sortAsc = this.removeSortParam(this.strToArray(this.sortAsc), param);
        this.sortDesc = this.removeSortParam(this.strToArray(this.sortDesc), param);

        this.update();
    }

    update(id = 0) {
        let query = "?" + PAGE + "=" + this.page + "&" + PER_PAGE + "=" + this.perPage;
        if(this.sortAsc) {
            query += "&" + SORT_ASC + "=" + this.sortAsc;
        }

        if(this.sortDesc) {
            query += "&" + SORT_DESC + "=" + this.sortDesc;
        }

        if(id > 0) {
            query = "?gadget=" + id
        }

        location.href = location.origin + location.pathname + query;
    }

    addSortParam(sortIn, sortOut, param) {
        if(sortOut.includes(param)) {
            sortOut.splice(sortOut.indexOf(param), 1);
        }
        if (!sortIn.includes(param)) {
            sortIn.push(param);
        }

        return {
            sortIn: sortIn,
            sortOut: sortOut
        };
    }

    removeSortParam(sort, param) {
        if(sort.includes(param)) {
            sort.splice(sort.indexOf(param), 1);
        }

        return sort.length > 0 ? sort.join(',') : '';
    }

    strToArray(string) {
        let res = [];

        if( string.length > 0)
            res = string.split(',').map(item => {
                return parseInt(item, 10);
            });

        return res;
    }
}