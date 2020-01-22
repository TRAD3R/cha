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
            ">
            <span class="icon">
              <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path d="M8 1H1V8H8V1Z" stroke="inherit" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M19 1H12V8H19V1Z" stroke="inherit" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M19 12H12V19H19V12Z" stroke="inherit" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M8 12H1V19H8V12Z" stroke="inherit" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
            <span class="btn-text">
              <?=Yii::t('front', 'DEVICES')?>
            </span>
          </a>
        </li>
        <li>
          <a href="/products" class="tab
            <?php 
                if(App\App::i()->getController()->id == 'product') {
                    echo 'active';
                }
          ?>
            ">
            <span class="icon">
              <svg width="20" height="23" viewBox="0 0 20 23" xmlns="http://www.w3.org/2000/svg">
              <path d="M19 14.9979V6.99795C18.9996 6.64722 18.9071 6.30276 18.7315 5.99911C18.556 5.69546 18.3037 5.44331 18 5.26795L11 1.26795C10.696 1.09241 10.3511 1 10 1C9.64893 1 9.30404 1.09241 9 1.26795L2 5.26795C1.69626 5.44331 1.44398 5.69546 1.26846 5.99911C1.09294 6.30276 1.00036 6.64722 1 6.99795V14.9979C1.00036 15.3487 1.09294 15.6931 1.26846 15.9968C1.44398 16.3004 1.69626 16.5526 2 16.7279L9 20.7279C9.30404 20.9035 9.64893 20.9959 10 20.9959C10.3511 20.9959 10.696 20.9035 11 20.7279L18 16.7279C18.3037 16.5526 18.556 16.3004 18.7315 15.9968C18.9071 15.6931 18.9996 15.3487 19 14.9979Z" stroke="inherit" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M1.27002 5.95789L10 11.0079L18.73 5.95789" stroke="inherit" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M10 21.0779V10.9979" stroke="inherit" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
            <span class="btn-text">
              <?=Yii::t('front', 'PRODUCTS')?>
            </span>
            </a>
        </li>
        <li>
          <a href="/listings?<?=Params::LISTING_TYPE.'='.ListingHelper::PRODUCTS?>" class="tab
            <?php 
                if(App\App::i()->getController()->id == 'listing') {
                    echo 'active';
                } 
          ?>
            ">
            <span class="icon">
              <svg width="22" height="22" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg">
              <path d="M19 8H10C8.89543 8 8 8.89543 8 10V19C8 20.1046 8.89543 21 10 21H19C20.1046 21 21 20.1046 21 19V10C21 8.89543 20.1046 8 19 8Z" stroke="inherit" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M4 14H3C2.46957 14 1.96086 13.7893 1.58579 13.4142C1.21071 13.0391 1 12.5304 1 12V3C1 2.46957 1.21071 1.96086 1.58579 1.58579C1.96086 1.21071 2.46957 1 3 1H12C12.5304 1 13.0391 1.21071 13.4142 1.58579C13.7893 1.96086 14 2.46957 14 3V4" stroke="inherit" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M19 8H10C8.89543 8 8 8.89543 8 10V19C8 20.1046 8.89543 21 10 21H19C20.1046 21 21 20.1046 21 19V10C21 8.89543 20.1046 8 19 8Z" stroke="inherit" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M4 14H3C2.46957 14 1.96086 13.7893 1.58579 13.4142C1.21071 13.0391 1 12.5304 1 12V3C1 2.46957 1.21071 1.96086 1.58579 1.58579C1.96086 1.21071 2.46957 1 3 1H12C12.5304 1 13.0391 1.21071 13.4142 1.58579C13.7893 1.96086 14 2.46957 14 3V4" stroke="inherit" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
            <span class="btn-text">
              <?=Yii::t('front', 'LISTINGS')?>
            </span>
          </a>
        </li>
      </ul>
    </nav>

