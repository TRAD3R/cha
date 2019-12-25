<?php
?>
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
            ">Девайсы</a>
        </li>
        <li>
          <a href="/products" class="tab
            <?php 
                if(App\App::i()->getController()->id == 'product') {
                    echo 'active';
                }
          ?>
            ">Товары</a>
        </li>
        <li>
          <a href="/listing" class="tab
            <?php 
                if(App\App::i()->getController()->id == 'listing') {
                    echo 'active';
                } 
          ?>
            ">Листинг</a>
        </li>
      </ul>
    </nav>

