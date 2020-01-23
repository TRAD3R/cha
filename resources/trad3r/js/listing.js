const TABLE_BODY = $('.table-body');
const LISTING_FILE = $("#file-list");
const ERRORS = $("#errors");
const OLD_LISTINGS_FIELD = $("#listing-files");

var inProgress = false;

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
        url: 'listings/progress',
        async: true,
        success: function (res) {
            if (res.status === 'success') {
                // LISTING_FILE.text(res.progress);
            }
        }
    });
}

function listingCreate() {
    hideModal();
    let title = $('#id-edited-input').val();
    inProgress = true;
    ERRORS.html('');
    LISTING_FILE.text('');
    LISTING_FILE.attr('href', "#");

    let checked = getIds();
    let url = new URL(location.href);
    let actionType = $("#action-type").val();

    showModal("log");

    if(checked.length){
        $.ajax({
            url: '/listings/create',
            method: "POST",
            async: true,
            data: {
                ids: checked.join(','),
                filename: title,
                type: url.searchParams.get('type'),
                actionType: actionType,
            }, success: function (res) {
                if(res.status === 'success'){
                    LISTING_FILE.attr("href", res.href);
                    LISTING_FILE.text(res.file);
                    if(res.errors){
                        let errors = res.errors;
                        for (let i in errors){
                            addError(errors[i]);
                        }
                    }
                }else{
                    addError(res.error);
                }
                
                clearInterval(showProgress);
            }
        });
        
        let showProgress = setInterval(function () {
            getProgress();
        }, 1000)
    }else{
        addError("Не выбрано ни одного гаджета");
    }
    
}

function addError(msg) {
    let error = document.createElement("p");
    error.classList.add('error');
    error.innerText = msg;
    ERRORS.append(error);
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

function showArchive() {
    OLD_LISTINGS_FIELD.html('');
    
    $.ajax({
        url: "listings/archive",
        method: "GET",
        success: function (res) {
            if(res.status === "success"){
                let files = res.files;
                
                if(Object.keys(files).length){
                    for (let filename in files){
                        let link = createLink(filename, files[filename]);
                        
                        OLD_LISTINGS_FIELD.append(link);
                    }
                }else{
                    OLD_LISTINGS_FIELD.innerText = "Еще не создано ни одного листинга"
                }
            }
        }
    });
    showModal('archive');
}

function createLink(filename, href) {
    let link = document.createElement("a");
    link.href = href;
    link.innerText = filename;
    link.classList.add("file");
    
    return link;
}

