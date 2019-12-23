<?php
/**
 * @var $device Device
 * @var $specifications DeviceSpecification
 * @var $sequenceNumber int
 */

use App\Helpers\PriceHelper;
use App\Models\Device;
use App\Models\DeviceSpecification;
use App\Tables\DeviceTableStructure;

/** @var DeviceSpecification $specifications */
$specifications = $device->specifications;
?>


    <div class="btn-box-wrapper"></div>
    <div class="btn-operations">
      <div class="btn-operations-edit">

      </div>
    </div>
    <div class="table-cell sequence-number">
        <?=$sequenceNumber?>
    </div>
    <div class="table-cell">
        <?php
        try {
            $dateCreated = new DateTime($specifications->date_created);
            echo $dateCreated->format('d.m.Y');
        } catch (Exception $e) {
        }
        ?>
    </div>
    
    <div class="table-cell type-<?=$specifications->type->type; ?> editable select" data-id="<?=DeviceTableStructure::DEVICE_TYPE?>">
      <div class="simple-select">
        <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
          <input hidden type="text" name="sort-view" value="<?=$specifications->type->id;?>" data-default-value="1">
          <p class="simple-select-selected" data-placeholder="<?=$specifications->type->type;?>"><?=$specifications->type->type;?></p>
          <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"/>
          </svg>
        </div>
        <div class="simple-select-drop">
          <div class="simple-select-drop-inner">
          </div>
        </div>
      </div>
    </div>
    <div class="table-cell editable select" data-id="<?=DeviceTableStructure::DEVICE_BRAND?>">
      <div class="simple-select">
        <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
          <input hidden type="text" name="sort-view" value="<?=$device->brand->id?>" data-default-value="1">
          <p class="simple-select-selected" data-placeholder="<?=$device->brand->name?>"><?=$device->brand->name?></p>
          <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"/>
          </svg>
        </div>
        <div class="simple-select-drop">
          <div class="simple-select-drop-inner">
          </div>
        </div>
      </div>
    </div>
    <div class="table-cell editable text" data-id="<?=DeviceTableStructure::DEVICE_MODEL?>">
      <input class="input-text" type="text" value="<?=$device->title?>">
    </div>
    <div class="table-cell editable text" data-id="<?=DeviceTableStructure::DEVICE_YEAR?>">
      <input class="input-text" type="text" value="<?=$specifications->year;?>">
    </div>
    <div class="table-cell editable text" data-id="<?=DeviceTableStructure::DEVICE_LENGTH?>">
        <input class="input-text" type="text" value="<?=$specifications->length;?>">
    </div>
    <div class="table-cell editable text" data-id="<?=DeviceTableStructure::DEVICE_WIDTH?>">
        <input class="input-text" type="text" value="<?=$specifications->width;?>">
    </div>
    <div class="table-cell editable text" data-id="<?=DeviceTableStructure::DEVICE_DEPTH?>">
        <input class="input-text" type="text" value="<?=$specifications->depth;?>">
    </div>
    <div class="table-cell editable text" data-id="<?=DeviceTableStructure::DEVICE_SCREEN_SIZE?>">
        <input class="input-text" type="text" value="<?=$specifications->screensize;?>">
    </div>
    <div class="table-cell editable select" data-id="<?=DeviceTableStructure::DEVICE_CARD_MEMORY?>">
      <div class="simple-select">
        <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
          <input hidden type="text" name="sort-view" value="<?=$specifications->usbType->id?>" data-default-value="1">
          <p class="simple-select-selected" data-placeholder="<?php echo $specifications->cardMemory ? $specifications->cardMemory->size : "-";?>">
            <?php echo $specifications->cardMemory ? $specifications->cardMemory->size : "-"; ?></p>
          <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"/>
          </svg>
        </div>
        <div class="simple-select-drop">
          <div class="simple-select-drop-inner">
          </div>
        </div>
      </div>
    </div>
    <div class="table-cell text-center editable checkbox" data-id="<?=DeviceTableStructure::DEVICE_35_JACK?>">
      <label class="checkbox">
        <input type="checkbox" <?php echo ($specifications->jack_35)?"checked":""; ?> disabled/>
        <span class="checkbox-box">
          <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">
          <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>
          </svg>
        </span>
        <span class="checkbox-text"></span>
      </label>
    </div>
    <div class="table-cell text-center editable checkbox" data-id="<?=DeviceTableStructure::DEVICE_BLUETOOTH?>">
      <label class="checkbox">
        <input type="checkbox" <?php echo ($specifications->bluetooth)?"checked":""; ?> disabled/>
        <span class="checkbox-box">
          <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">
          <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>
          </svg>
        </span>
        <span class="checkbox-text"></span>
      </label>
    </div>
    <div class="table-cell editable select" data-id="<?=DeviceTableStructure::DEVICE_USB_TYPE?>">
      <div class="simple-select">
        <div class="simple-select-main" tabindex="0" role="combobox" aria-expanded="false">
          <input hidden type="text" name="sort-view" value="<?=$specifications->usbType->id?>" data-default-value="1">
          <p class="simple-select-selected" data-placeholder="<?php echo $specifications->usbType ? $specifications->usbType->type : "-";?>">
            <?php echo $specifications->usbType ? $specifications->usbType->type : "-"; ?></p>
          <svg width="11" height="5" viewBox="0 0 11 5" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.803223 0L5.80322 5L10.8032 0H0.803223Z" fill="inherit"/>
          </svg>
        </div>
        <div class="simple-select-drop">
          <div class="simple-select-drop-inner">
          </div>
        </div>
      </div>
    </div>
    <div class="table-cell editable selectable" data-id="<?=DeviceTableStructure::DEVICE_USB_STANDARD?>">
        <?php
        echo $specifications->usbStandard ? $specifications->usbStandard->standard : "-";
        ?>
    </div>
    <div class="table-cell text-center editable checkbox" data-id="<?=DeviceTableStructure::DEVICE_WIRELESS_CHARGE?>">
        <label class="checkbox">
            <input type="checkbox" <?php echo ($specifications->wireless_charge)?"checked":""; ?> disabled/>
            <span class="checkbox-box">
          <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">
          <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>
          </svg>
        </span>
            <span class="checkbox-text"></span>
        </label>
    </div>
    <div class="table-cell text-center editable checkbox" data-id="<?=DeviceTableStructure::DEVICE_FAST_CHARGE?>">
        <label class="checkbox">
            <input type="checkbox" <?php echo ($specifications->fast_charge)?"checked":""; ?> disabled/>
            <span class="checkbox-box">
          <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">
          <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>
          </svg>
        </span>
            <span class="checkbox-text"></span>
        </label>
    </div>
    <div class="table-cell text-center editable checkbox" data-id="<?=DeviceTableStructure::DEVICE_REMOVABLE_BATTERY?>">
        <label class="checkbox">
            <input type="checkbox" <?php echo ($specifications->removable_battery)?"checked":""; ?> disabled/>
            <span class="checkbox-box">
          <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">
          <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>
          </svg>
        </span>
            <span class="checkbox-text"></span>
        </label>
    </div>
    <div class="table-cell editable text" data-id="<?=DeviceTableStructure::DEVICE_PRICE?>">
      <input class="input-text" type="text" value="<?=PriceHelper::toFloat($specifications->price);?>">
    </div>
    <div class="table-cell editable text" data-id="<?=DeviceTableStructure::DEVICE_IMAGE?>">
      <input class="input-text" type="text" value="<?=$specifications->image;?>">
    </div>
