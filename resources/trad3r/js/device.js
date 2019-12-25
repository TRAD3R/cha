// /** Класс для скрытия элемента */
// const CLASS_HIDDEN_ELEMENT = 'hidden-el';
// const ID_EDITED_SELECT = 'edited-select';
//
// var Device = {
//     el: null,
//     row: null,
//     deviceId: 0,
//     rowHtml: '',
//     body: null,
//     btnSave: null,
//     btnCancel: null,
//     CLASS_SELECT: 'select',
//     CLASS_TEXT: 'text',
//     CLASS_CHECKBOX: 'checkbox',
//     page: 1,
//     perPage: 50,
//     changeInput: function() {
//         this.el.addClass('edited');
//
//         if(this.el.hasClass(this.CLASS_SELECT)) {
//             this.getSelectInput();
//         }else if(this.el.hasClass(this.CLASS_TEXT)) {
//             this.getTextInput();
//         }else if(this.el.hasClass(this.CLASS_CHECKBOX)) {
//             this.getCheckboxInput();
//         }
//     },
//     getCheckboxInput: function () {
//         let input = this.el.find('input').eq(0);
//         input.removeAttr('disabled');
//     },
//     getTextInput: function () {
//         let text = this.el.text();
//         let input = this.el.find('.input-text');
//         input.value = text;
//     },
//     getSelectInput: function () {
//         $.ajax({
//             url: '/device/specification/list/' + this.el.data('id'),
//             method: 'GET',
//             success: function (res) {
//                 if(res.status === 'success'){
//                     let selected = Device.el.find('input').val();
//                     let select = Device.createSelect(res.list, selected);
//                     Device.el.find('.simple-select-drop-inner').html(select);
//                 }
//             }
//         })
//     },
//     createSelect: function (list, selected) {
//
//         let ul = document.createElement('ul');
//         ul.classList.add("simple-select-list");
//         ul.setAttribute("role", "listbox");
//
//         for (let el of list) {
//             let li = document.createElement('li');
//             li.classList.add('simple-select-item');
//             li.setAttribute("role", "option");
//             li.setAttribute("data-value", el.id);
//             li.innerText = el.title;
//             if (el.id === selected) {
//                 li.classList.add("is-active");
//             }
//             ul.append(li);
//         }
//
//         return ul;
//     },
//     updateRow: function() {
//         this.deviceId = +this.row.data('id');
//
//         let data = this.getEditedCells();
//         $.ajax({
//             url: '/device/' + this.deviceId,
//             method: 'POST',
//             data: data,
//             success: function (res) {
//                 if(res.status === 'success'){
//                     Device.row.html(res.row);
//                     Device.row.removeClass('edited-row');
//                     Device.body.removeClass('edited-body');
//                 }
//
//                 $("#new-device").removeClass(CLASS_HIDDEN_ELEMENT);
//             }
//         })
//     },
//     cancelChanges: function () {
//         this.row.data('id') > 0 ? this.row.html(this.rowHtml) : this.row.remove();
//         Device.row.removeClass('edited-row');
//         Device.body.removeClass('edited-body');
//        
//         $("#new-device").removeClass(CLASS_HIDDEN_ELEMENT);
//     },
//     getEditedCells: function () {
//         let data = {};
//         let cells = this.deviceId > 0 ? '.edited'  : '.editable';
//         console.log(this.deviceId, cells);
//         this.row.find(cells).each(function () {
//             let id = $(this).data('id');
//             let value = null;
//             if($(this).hasClass(Device.CLASS_SELECT) || $(this).hasClass(Device.CLASS_TEXT)) {
//                 value = $(this).find('input').eq(0).val();
//             }else if($(this).hasClass(Device.CLASS_CHECKBOX)) {
//                 value = $(this).find('input').prop('checked') ? 1 : 0;
//             }
//             data[$(this).data('id')] = value;
//         });
//
//         data['sequenceNumber'] = this.row.find('.sequence-number').eq(0).text();
//
//         return data;
//     },
//     changePerPage: function (perPage) {
//         this.perPage = perPage;
//         this.update();
//     },
//     update: function () {
//         console.log(location);
//     }
// };