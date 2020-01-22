<?php

use App\Helpers\ListingHelper;
use App\Params; ?>
<main class="page">
  <div class="container-fluid">
    <nav class="navigation">
      <ul class="navigation-bar">
        <li>
          <a href="/devices" class="tab
            <?php if(App\App::i()->getController()->id == 'device') {
                      echo 'active';
                  }
                ?>
            "><?=Yii::t('front', 'DEVICES')?></a>
        </li>
        <li>
          <a href="/products" class="tab
            <?php 
                if(App\App::i()->getController()->id == 'product') {
                    echo 'active';
                }
          ?>
            "><?=Yii::t('front', 'PRODUCTS')?></a>
        </li>
        <li>
          <a href="/listings?<?=Params::LISTING_TYPE.'='.ListingHelper::PRODUCTS?>" class="tab
            <?php 
                if(App\App::i()->getController()->id == 'listing') {
                    echo 'active';
                } 
          ?>
            "><?=Yii::t('front', 'LISTINGS')?></a>
        </li>
      </ul>
    </nav>

