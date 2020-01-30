const TABLE_BODY = $('.table-body');
const LISTING_FILE = $(".file-list");
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
    $.post('progress.php',{},
         function (res) {
             $("#progress-p").text(res + "%");
             $("#progress-bar").css("width", res + "%");
         }
    );
}

function showFileUrl(res) {
    let link = document.createElement('a');
    link.classList.add("file");
    link.href = res.href;
    link.innerText = res.file;
    
    LISTING_FILE.append(link);
}

function listingCreate() {
    hideModal();
    let title = $('#id-edited-input').val();
    inProgress = true;
    ERRORS.html('');
    LISTING_FILE.html('');

    let checked = getIds();
    let url = new URL(location.href);
    let actionType = $("#action-type").val();
    let products = getSelectedProducts();

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
                products: products
            }, success: function (res) {
                if(res.status === 'success'){
                    showFileUrl(res);
                    
                    if(res.errors){
                        let errors = res.errors;
                        for (let i in errors){
                            addError(errors[i]);
                        }
                    }
                }else{
                    addError(res.error);
                }
            }, error: function (xhr) {
                addError(xhr.responseJSON.message);
            }, complete: function () {
                clearInterval(showProgress);
            }
        });
        
        let showProgress = setInterval(function () {
            getProgress();
        }, 300)
    }else{
        addError("Не выбрано ни одного гаджета");
    }
    
}

function getSelectedProducts() {
    let products = [];
    
    $("#product-list").find("input[type='checkbox']:checked").each(function () {
        products.push($(this).data('id'));
    });
    
    return products.join(",");
}

function getPerPage() {
    let perPage = 100;
    
    let activeItem = $('.pagination').find(".simple-select-item.is-active");

    if(activeItem) {
        perPage = activeItem.data('value');
    }
    
    return perPage;
}

function filterListing() {
    let from = $("#date-start").val();
    let to = $("#date-end").val();

    let products = getSelectedProducts();
    let perPage = getPerPage();
    let url = "listings?type=devices&date_from=" + from + "&date_to=" + to + "&products=" + products + "&per_page=" + perPage;
    location.href = url;
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

