<?php
/**
 * @var string $title
 * @var string $value
 */

use App\Helpers\TextHelper; 
?>

<div class="simple-select">
    <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
        <input hidden type="text" name="sort-view" value="<?=$value?>" data-default-value="<?=$value?>">
        <p class="simple-select-selected" data-placeholder="<?=$title?>"><?=$title?></p>
        <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"/>
        </svg>
    </div>
    <div class="simple-select-drop">
        <div class="simple-select-drop-inner">
        </div>
        <div class="simple-select-add">
            <button type="button" class="btn btn-primary" onclick="showModal(this)">
                <?=TextHelper::upperFirstChar(Yii::t('front', 'ADD'));?>
            </button>
        </div>
    </div>
</div>