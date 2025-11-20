<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ИП «Ер-Ас»</title>

  <link rel="stylesheet" href="./styles/main.css" />

  <script src="./scripts/main.js" type="module" defer></script>
</head>

<body>
  <header class="header" data-js-header>
    <div class="header__promo">
      <div class="header__promo-inner container">
        <a href="tel:+7-778-638-93-94" class="header__promo-link">
          <span class="icon icon__phone">+7&nbsp;(778)&nbsp;638-93-94</span>
        </a>
        <a href="tel:+7-705-500-00-70" class="header__promo-link">
          <span class="icon icon__phone">+7&nbsp;(705)&nbsp;500-00-70</span>
        </a>
        <a href="mailto:Bek_m78@mail.ru" class="header__promo-link">
          <span class="icon icon__email">Bek_m78@mail.ru</span>
        </a>
      </div>
    </div>
    <div class="header__body">
      <div class="header__body-inner container">
        <a href="./index.php" class="header__logo logo" aria-label="Home" title="Home">
          <img
            src="./icons/logo.svg"
            alt=""
            class="logo__image"
            width="179"
            height="50" />
        </a>
        <div class="header__overlay" data-js-header-overlay>
          <nav class="header__menu" data-js-header-menu>
            <ul class="header__menu-list">
              <li class="header__menu-item">
                <a
                  href="./index.php"
                  class="header__menu-link"
                  data-js-header-menu-link>
                  Главная
                </a>
              </li>
              <li class="header__menu-item">
                <a
                  href="./feed-project.php"
                  class="header__menu-link"
                  data-js-header-menu-link>
                  НИР по ГФ и ПЦФ
                </a>
              </li>
              <li class="header__menu-item">
                <a
                  href="./service.php"
                  class="header__menu-link"
                  data-js-header-menu-link>
                  Закупки товаров, работ, услуг
                </a>
              </li>
              <li class="header__menu-item">
                <a
                  href="./results.php"
                  class="header__menu-link"
                  data-js-header-menu-link>
                  Результаты НИР
                </a>
              </li>

              <?php if (!isset($_SESSION['user']['id'])): ?>
                <li class="header__menu-item">
                  <a
                    href="./login.php"
                    class="header__menu-link"
                    data-js-header-menu-link>
                    Авторизация
                  </a>
                </li>
              <?php endif ?>
              <?php if (isset($_SESSION['user']['id'])): ?>
                <li class="header__menu-item">
                  <a
                    href="./home.php"
                    class="header__menu-link"
                    data-js-header-menu-link>
                    Личный кабинет
                  </a>
                </li>
              <?php endif ?>
            </ul>
          </nav>
          <!-- <a href="/" class="header__contact-us-link button button__accent">
              Contact Us
            </a> -->
        </div>
        <button
          class="header__burger-button burger-button visible-mobile"
          aria-label="Open menu"
          title="Open menu"
          data-js-header-burger-button>
          <span class="burger-button__line"></span>
          <span class="burger-button__line"></span>
          <span class="burger-button__line"></span>
        </button>
      </div>
    </div>
  </header>