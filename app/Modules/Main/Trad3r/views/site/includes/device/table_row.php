<?php
/**
 * @var $device Device
 * @var $specifications DeviceSpecification
 * @var $sequenceNumber int
 */

use App\Lib\Tables\TableStructure;
use App\Models\Device;
use App\Models\DeviceSpecification; ?>

<div class="table-row">
    <div class="btn-box-wrapper"></div>
    <div class="table-cell">
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
    
    <div class="table-cell type-<?=$specifications->type->type; ?>" data-id="<?=TableStructure::DEVICE_TYPE?>">
        <?=$specifications->type->type;?>
    </div>
    <div class="table-cell" data-id="<?=TableStructure::DEVICE_BRAND?>">
        <?=$device->brand->name?>
    </div>
    <div class="table-cell" data-id="<?=TableStructure::DEVICE_MODEL?>">
        <?=$device->title?>
    </div>
    <div class="table-cell" data-id="<?=TableStructure::DEVICE_YEAR?>">
        <?=$specifications->year;?>
    </div>
    <div class="table-cell" data-id="<?=TableStructure::DEVICE_LENGTH?>">
        <?=$specifications->length;?>
    </div>
    <div class="table-cell" data-id="<?=TableStructure::DEVICE_WIDTH?>">
        <?=$specifications->width;?>
    </div>
    <div class="table-cell" data-id="<?=TableStructure::DEVICE_DEPTH?>">
        <?=$specifications->depth;?>
    </div>
    <div class="table-cell" data-id="<?=TableStructure::DEVICE_SCREEN_SIZE?>">
        <?=$specifications->screensize;?>
    </div>
    <div class="table-cell" data-id="<?=TableStructure::DEVICE_CARD_MEMORY?>">
        <?php
        echo $specifications->cardMemory ? $specifications->cardMemory->size : "-";
        ?>
    </div>
    <div class="table-cell text-center" data-id="<?=TableStructure::DEVICE_35_JACK?>">
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
    <div class="table-cell text-center" data-id="<?=TableStructure::DEVICE_BLUETOOTH?>">
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
    <div class="table-cell" data-id="<?=TableStructure::DEVICE_USB_TYPE?>">
        <?php
        echo $specifications->usbType ? $specifications->usbType->type : "-";
        ?>
    </div>
    <div class="table-cell" data-id="<?=TableStructure::DEVICE_USB_STANDARD?>">
        <?php
        echo $specifications->usbStandard ? $specifications->usbStandard->standard : "-";
        ?>
    </div>
    <div class="table-cell text-center" data-id="<?=TableStructure::DEVICE_WIRELESS_CHARGE?>">
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
    <div class="table-cell text-center" data-id="<?=TableStructure::DEVICE_FAST_CHARGE?>">
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
    <div class="table-cell text-center" data-id="<?=TableStructure::DEVICE_REMOVABLE_BATTERY?>">
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
    <div class="table-cell" data-id="<?=TableStructure::DEVICE_PRICE?>">
        <?=$specifications->price;?>
    </div>
    <div class="table-cell" data-id="<?=TableStructure::DEVICE_IMAGE?>">
        <?=$specifications->image;?>
    </div>
</div>
