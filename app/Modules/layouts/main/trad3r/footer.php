<?php 

use App\Helpers\ListingHelper;
use App\Html;
use App\Params;
use yii\web\View;

/**
 * @var View $this;
 */
?>

</div>
</main>

<div class="btn-operations">
  <div class="btn-operations-edit">

  </div>
</div>

<div class="modal">
  <div id="modal-content-textarea" class="modal-content">
    <div class="modal-content-wrapper">
      <label for="id-edited-textarea">Введите текст: </label>
      <textarea name="edited-textarea" id="id-edited-textarea"></textarea>
      <div class="modal-content-tools jc-end">
        <button type="button" class="btn btn-primary" onclick="gadget.hideModal(true)">Сохранить</button>
        <button type="button" class="btn btn-muted" onclick="gadget.hideModal(false)">Отменить</button>
      </div>
    </div>
    <div class="btn btn-box btn-close-modal"  onclick="gadget.hideModal(false)">
      <svg width="13" height="13" viewBox="0 0 13 13" xmlns="http://www.w3.org/2000/svg">
        <path d="M12.1615 0.893973C11.674 0.406436 10.8834 0.406436 10.3967 0.893973L6.52734 4.76385L2.65796 0.893973C2.17042 0.406436 1.3807 0.406436 0.893164 0.893973C0.405626 1.38151 0.405626 2.17123 0.893164 2.65877L4.76255 6.52848L0.892997 10.3984C0.405459 10.8859 0.405459 11.6756 0.892997 12.1632C1.13668 12.4068 1.45608 12.5289 1.77548 12.5289C2.09488 12.5289 2.41461 12.407 2.65796 12.1632L6.52734 8.29345L10.3967 12.1632C10.6404 12.4068 10.9598 12.5289 11.2792 12.5289C11.5986 12.5289 11.9178 12.407 12.1617 12.1632C12.6492 11.6756 12.6492 10.8859 12.1617 10.3984L8.29214 6.52865L12.1615 2.65894C12.6491 2.1714 12.6491 1.38151 12.1615 0.893973Z" fill="inherit"></path>
      </svg>
    </div>
  </div>
  <div id="modal-content-input" class="modal-content">
    <div class="modal-content-wrapper">
      <label for="id-edited-input">Введите название: </label>
      <div class="listing-modal-content">
        <div class="form-group row">
          <input name="edited-input" id="id-edited-input">
          <span class="">.xlsx</span>
        </div>
        <div class="form-group row">

          <div class="simple-select gray">
            <div class="simple-select-label">
            </div>
            <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
              <input hidden type="text" name="sort-view" value="<?=ListingHelper::ACTION_TYPE_UPDATE?>" data-default-value="50" id="action-type">
              <p class="simple-select-selected" data-placeholder=""><?=Yii::t('front', 'UPDATE')?></p>
              <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"/>
              </svg>
            </div>
            <div class="simple-select-drop">
              <div class="simple-select-drop-inner">
                <ul class="simple-select-list" role="listbox">
                  <li
                    class="simple-select-item"
                    data-value="<?=ListingHelper::ACTION_TYPE_UPDATE?>"
                    role="option"
                    value="<?=ListingHelper::ACTION_TYPE_UPDATE?>"><?=Yii::t('front', 'UPDATE')?></li>
                  <li
                    class="simple-select-item"
                    data-value="<?=ListingHelper::ACTION_TYPE_DELETE?>"
                    role="option"
                    value="<?=ListingHelper::ACTION_TYPE_DELETE?>"><?=Yii::t('front', 'DELETE')?></li>
                </ul>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-content-tools jc-end">
        <button type="button" class="btn btn-primary" onclick="listingCreate()">Создать </button>
        <button type="button" class="btn btn-muted" onclick="hideModal()">Отменить</button>
      </div>
    </div>
    <div class="btn btn-box btn-close-modal"  onclick="hideModal()">
      <svg width="13" height="13" viewBox="0 0 13 13" xmlns="http://www.w3.org/2000/svg">
        <path d="M12.1615 0.893973C11.674 0.406436 10.8834 0.406436 10.3967 0.893973L6.52734 4.76385L2.65796 0.893973C2.17042 0.406436 1.3807 0.406436 0.893164 0.893973C0.405626 1.38151 0.405626 2.17123 0.893164 2.65877L4.76255 6.52848L0.892997 10.3984C0.405459 10.8859 0.405459 11.6756 0.892997 12.1632C1.13668 12.4068 1.45608 12.5289 1.77548 12.5289C2.09488 12.5289 2.41461 12.407 2.65796 12.1632L6.52734 8.29345L10.3967 12.1632C10.6404 12.4068 10.9598 12.5289 11.2792 12.5289C11.5986 12.5289 11.9178 12.407 12.1617 12.1632C12.6492 11.6756 12.6492 10.8859 12.1617 10.3984L8.29214 6.52865L12.1615 2.65894C12.6491 2.1714 12.6491 1.38151 12.1615 0.893973Z" fill="inherit"></path>
      </svg>
    </div>
  </div>
  <div id="modal-content-log" class="modal-content">
    <div class="modal-content-wrapper">
        <div class="progress">
            <?=$this->render('@layouts/common/progress', ["progress" => 0])?>
        </div>
      <div class="modal-content-item file-list-wrapper">
        <p class="dr-h2">
          Файлы:
        </p>
        <div class="content-list file-list">
          
        </div>
      </div>
      <div class="modal-content-item error-list-wrapper">
        <p class="dr-h2">
          Ошибки:
        </p>
        <div id="errors" class="content-list error-list">
        </div>
      </div>
    </div>
    <div class="btn btn-box btn-close-modal"  onclick="hideModal()">
      <svg width="13" height="13" viewBox="0 0 13 13" xmlns="http://www.w3.org/2000/svg">
        <path d="M12.1615 0.893973C11.674 0.406436 10.8834 0.406436 10.3967 0.893973L6.52734 4.76385L2.65796 0.893973C2.17042 0.406436 1.3807 0.406436 0.893164 0.893973C0.405626 1.38151 0.405626 2.17123 0.893164 2.65877L4.76255 6.52848L0.892997 10.3984C0.405459 10.8859 0.405459 11.6756 0.892997 12.1632C1.13668 12.4068 1.45608 12.5289 1.77548 12.5289C2.09488 12.5289 2.41461 12.407 2.65796 12.1632L6.52734 8.29345L10.3967 12.1632C10.6404 12.4068 10.9598 12.5289 11.2792 12.5289C11.5986 12.5289 11.9178 12.407 12.1617 12.1632C12.6492 11.6756 12.6492 10.8859 12.1617 10.3984L8.29214 6.52865L12.1615 2.65894C12.6491 2.1714 12.6491 1.38151 12.1615 0.893973Z" fill="inherit"></path>
      </svg>
    </div>
  </div>
  <div id="modal-content-archive" class="modal-content">
    <div class="modal-content-wrapper">
      <p class="dr-h2"><?=Yii::t('front', 'ARCHIVE')?></p>
      <div id="listing-files" class="content-list file-list archive-file-list">
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
        <a href="#" class="file">Listing_example.xls</a>
      </div>
    </div>
    <div class="btn btn-box btn-close-modal"  onclick="hideModal()">
      <svg width="13" height="13" viewBox="0 0 13 13" xmlns="http://www.w3.org/2000/svg">
        <path d="M12.1615 0.893973C11.674 0.406436 10.8834 0.406436 10.3967 0.893973L6.52734 4.76385L2.65796 0.893973C2.17042 0.406436 1.3807 0.406436 0.893164 0.893973C0.405626 1.38151 0.405626 2.17123 0.893164 2.65877L4.76255 6.52848L0.892997 10.3984C0.405459 10.8859 0.405459 11.6756 0.892997 12.1632C1.13668 12.4068 1.45608 12.5289 1.77548 12.5289C2.09488 12.5289 2.41461 12.407 2.65796 12.1632L6.52734 8.29345L10.3967 12.1632C10.6404 12.4068 10.9598 12.5289 11.2792 12.5289C11.5986 12.5289 11.9178 12.407 12.1617 12.1632C12.6492 11.6756 12.6492 10.8859 12.1617 10.3984L8.29214 6.52865L12.1615 2.65894C12.6491 2.1714 12.6491 1.38151 12.1615 0.893973Z" fill="inherit"></path>
      </svg>
    </div>
  </div>
</div>
<div class="modal-overlay"></div>
<script>
    const PAGE = '<?=Params::PAGE?>';
    const PER_PAGE = '<?=Params::PER_PAGE?>';
    const SORT_ASC = '<?=Params::SORT_ASC?>';
    const SORT_DESC = '<?=Params::SORT_DESC?>';
</script>
