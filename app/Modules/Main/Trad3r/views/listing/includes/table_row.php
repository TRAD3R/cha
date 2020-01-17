<?php
/**
 * @var View $this
 * @var Product $product
 */

use App\Models\Product;
use yii\web\View;

?>

    <div class="table-cell text-center checkbox">
      <label class="checkbox">
        <input type="checkbox" disabled/>
        <span class="checkbox-box">
          <svg width="13" height="11" viewBox="0 0 12 10" xmlns="http://www.w3.org/2000/svg">
          <path d="M11.7832 1.67096L10.7303 0.61808C10.586 0.473602 10.4104 0.401337 10.204 0.401337C9.99744 0.401337 9.82186 0.473602 9.67749 0.61808L4.59871 5.70454L2.32257 3.42064C2.17803 3.27611 2.00256 3.20392 1.79618 3.20392C1.58966 3.20392 1.41419 3.27611 1.26965 3.42064L0.21677 4.47355C0.0722387 4.61805 0 4.79358 0 5.00007C0 5.2064 0.0722387 5.38209 0.21677 5.52657L3.0193 8.32904L4.07227 9.38193C4.21672 9.52651 4.39224 9.5987 4.59871 9.5987C4.80509 9.5987 4.98062 9.52632 5.12515 9.38193L6.17809 8.32904L11.7832 2.72393C11.9276 2.5794 12 2.4039 12 2.19741C12.0001 1.99102 11.9276 1.8155 11.7832 1.67096Z" fill="inherit"/>
          </svg>
        </span>
        <span class="checkbox-text"></span>
      </label>
    </div>
    <div class="table-cell">
        <?=$product->id?>
    </div>
    <div class="table-cell">
        <?=$product->name?>
    </div>
