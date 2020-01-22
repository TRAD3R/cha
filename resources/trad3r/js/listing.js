const TABLE_BODY = $('.table-body');
const LISTING_FILE = $(".showed-listing-file");

$(document).ready(function () {
    $("#select-all").on('click', selectAll);
});

let Listing = {
    create: function () {
        let url = 'listings/create';
        $.ajax({
            url: url,
            method: "post",
            data: {
                filename: 'new_file1',
                products: '1,2'
            },
            success: function (res) {
                console.log(res)
            }
        })
    }
};

function getProgress() {
    /** todo реализоваь прогрессбар */
    $.ajax({
        url: 'listings/progress'
    }).done(function (res) {
        if(res.status === 'success'){
            // LISTING_FILE.text(res.progress);
        }
    })
    
}

function listingCreate() {
    hideModal();
    let title = $('#id-edited-input').val();
    let inProgress = true;

    let checked = getIds();
    let url = new URL(location.href);
    let actionType = $("#action-type").val();

    showModal("log");

    if(checked.length){
        $.ajax({
            url: '/listings/create',
            method: "POST",
            data: {
                ids: checked.join(','),
                filename: title,
                type: url.searchParams.get('type'),
                actionType: actionType,
            }
        })
        .done(function (res) {
                if(res.status === 'success'){
                    LISTING_FILE.attr("href", res.href);
                    LISTING_FILE.text(res.file);
                }else{
                    LISTING_FILE.text(res.error);
                }
        })
        .always(function () {
            inProgress = false;
            clearInterval(showProgress);
        });
        
        let showProgress = setInterval(function () {
            getProgress();
        }, 1000)
    }
    
}

/**
 * Получить ID выбранных товаров
 * @returns {[]}
 */
function getIds() {
    let ids = [];
    
    TABLE_BODY.find("input[type='checkbox']:checked").each(function () {
        ids.push($(this).closest('.table-row').data('id'));
    });
    
    return ids;
}

function selectAll() {
    let state = $("#select-all").prop('checked');
    var checkboxes = TABLE_BODY.find("input[type='checkbox']");

    checkboxes.each(function () {
        $(this).prop("checked", state);
    })
}