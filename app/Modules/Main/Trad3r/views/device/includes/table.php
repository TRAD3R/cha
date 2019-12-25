<?php

use App\Html;
use App\Models\Device;
use App\Params;
use yii\web\View;

/**
 * @var View $this
 * @var Device[] $devices 
 * @var int $totalCount
 * @var array $params
 * @var int $offset
 */
 ?>
<div class="page page-devices">
  <h2 class="page-title dr-h2">Девайсы</h2>

  <div class="table" id="horizontal-scroller">
    <div class="table-content">
      <?php echo $this->render('table_head', [
              'sortedColumnsAsc' => $params[Params::SORT_ASC], 
              'sortedColumnsDesc' =>$params[Params::SORT_DESC]
      ]); ?>
      <?php echo $this->render('table_body', compact('devices', 'offset')); ?>
    </div>
  </div>
  <div class="table-btn-tool">
    <button id="new-device" type="button" class="btn btn-primary">
      <span class="icon">
        <svg width="12" height="13" viewBox="0 0 12 13" xmlns="http://www.w3.org/2000/svg">
        <path d="M6.99951 5.229H11.5591V7.19434H6.99951V12.3604H4.91064V7.19434H0.351074V5.229H4.91064V0.456055H6.99951V5.229Z" fill="white"/>
        </svg>
      </span>
      <span class="btn-text">Новая запись</span>
    </button>
    <?=Html::renderPaginator([
      'page' => $params[Params::PAGE],
      'per_page' => $params[Params::PER_PAGE],
      'total_count' => $totalCount,
    ])?>
  </div>
</div>

<script>
    /** Класс для скрытия элемента */
    const CLASS_HIDDEN_ELEMENT = 'hidden-el';
    const ID_EDITED_SELECT = 'edited-select';

    var Device = {
        el: null,
        row: null,
        deviceId: 0,
        rowHtml: '',
        body: null,
        btnSave: null,
        btnCancel: null,
        CLASS_SELECT: 'select',
        CLASS_TEXT: 'text',
        CLASS_CHECKBOX: 'checkbox',
        page: <?=$params[Params::PAGE]?>,
        perPage: <?=$params[Params::PER_PAGE]?>,
        sortAsc: '<?= $_GET[Params::SORT_ASC]?>',
        sortDesc: '<?= $_GET[Params::SORT_DESC]?>',
        changeInput: function() {
            this.el.addClass('edited');

            if(this.el.hasClass(this.CLASS_SELECT)) {
                this.getSelectInput();
            }else if(this.el.hasClass(this.CLASS_TEXT)) {
                this.getTextInput();
            }else if(this.el.hasClass(this.CLASS_CHECKBOX)) {
                this.getCheckboxInput();
            }
        },
        getCheckboxInput: function () {
            let input = this.el.find('input').eq(0);
            input.removeAttr('disabled');
        },
        getTextInput: function () {
            let text = this.el.text();
            let input = this.el.find('.input-text');
            input.value = text;
        },
        getSelectInput: function () {
            $.ajax({
                url: '/devices/specification/list/' + this.el.data('id'),
                method: 'GET',
                success: function (res) {
                    if(res.status === 'success'){
                        let selected = Device.el.find('input').val();
                        let select = Device.createSelect(res.list, selected);
                        Device.el.find('.simple-select-drop-inner').html(select);
                    }
                }
            })
        },
        createSelect: function (list, selected) {

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
        },
        updateRow: function() {
            this.deviceId = +this.row.data('id');

            let data = this.getEditedCells();
            $.ajax({
                url: '/devices/' + this.deviceId,
                method: 'POST',
                data: data,
                success: function (res) {
                    if(res.status === 'success'){
                        Device.row.html(res.row);
                        Device.row.removeClass('edited-row');
                        Device.body.removeClass('edited-body');
                    }

                    $("#new-device").removeClass(CLASS_HIDDEN_ELEMENT);
                }
            })
        },
        deleteRow: function() {
            let id = this.row.data('id');
            $.ajax({
                url: '/devices/remove/' + id,
                method: 'GET',
                success: function (res) {
                    if(res.status === 'success'){
                        Device.row.remove();
                        Device.body.removeClass('edited-body');
                    }
                }
            })
        },
        cancelChanges: function () {
            this.row.data('id') > 0 ? this.row.html(this.rowHtml) : this.row.remove();
            Device.row.removeClass('edited-row');
            Device.body.removeClass('edited-body');

            $("#new-device").removeClass(CLASS_HIDDEN_ELEMENT);
        },
        getEditedCells: function () {
            let data = {};
            let cells = this.deviceId > 0 ? '.edited'  : '.editable';
            console.log(this.deviceId, cells);
            this.row.find(cells).each(function () {
                let id = $(this).data('id');
                let value = null;
                if($(this).hasClass(Device.CLASS_SELECT) || $(this).hasClass(Device.CLASS_TEXT)) {
                    value = $(this).find('input').eq(0).val();
                }else if($(this).hasClass(Device.CLASS_CHECKBOX)) {
                    value = $(this).find('input').prop('checked') ? 1 : 0;
                }
                data[$(this).data('id')] = value;
            });

            data['sequenceNumber'] = this.row.find('.sequence-number').eq(0).text();

            return data;
        },
        changePerPage: function (perPage) {
            this.perPage = perPage;
            this.update();
        },
        addSort: function(type, param) {
            let sortAsc = this.toArray(this.sortAsc);
            let sortDesc = this.toArray(this.sortDesc);

            let res = {};
            if(type === '<?=Params::SORT_ASC?>') {
                res = this.addSortParam(sortAsc, sortDesc, +param);
                this.sortAsc = res.sortIn.join(',');
                this.sortDesc = res.sortOut.join(',');
            }else{
                res = this.addSortParam(sortDesc, sortAsc, +param);
                this.sortDesc = res.sortIn.join(',');
                this.sortAsc = res.sortOut.join(',');
            }
            
            this.update();
        },
        removeSort: function(param) {
            this.sortAsc = this.removeSortParam(this.toArray(this.sortAsc), param);
            this.sortDesc = this.removeSortParam(this.toArray(this.sortDesc), param);
            
            this.update();
        },
        update: function () {
            let query = "?<?=Params::PAGE?>=" + this.page + "&<?=Params::PER_PAGE?>=" + this.perPage;
            if(this.sortAsc) {
                query += "&<?=Params::SORT_ASC?>=" + this.sortAsc;
            }
            
            if(this.sortDesc) {
                query += "&<?=Params::SORT_DESC?>=" + this.sortDesc;
            }

            location.href = location.origin + location.pathname + query;
        },
        addSortParam: function (sortIn, sortOut, param) {
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
        },
        removeSortParam: function (sort, param) {
            if(sort.includes(param)) {
                sort.splice(sort.indexOf(param), 1);
            }

            return sort.length > 0 ? sort.join(',') : '';
        },
        toArray: function (string) {
            let res = [];
            
            if( string.length > 0)
            res = string.split(',').map(function(item) {
                return parseInt(item, 10);
            });
            
            return res;
        }
    };
</script>
