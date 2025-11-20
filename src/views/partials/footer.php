    <footer class="footer">
      <div class="footer__body container">
        <div class="footer__logo">
          <a href="./index.php" class="logo" aria-label="Home" title="Home">
            <img
              src="./icons/logo.svg"
              alt=""
              class="logo__image"
              width="179"
              height="50" />
          </a>
        </div>
        <div class="contacts">
          <span>
            <strong class="contacts__title"> Контакты </strong>
          </span>
          <ul class="contacts__list">
            <li class="contacts__item">
              Индивидуальный предприниматель «Ер-Ас»
            </li>
            <li class="contacts__item">
              Руководитель: Молдаханов Бекболат Аскерханович
            </li>
            <li class="contacts__item">Казахстан, г. Усть-Каменогорск</li>
            <li class="contacts__item">Шоссейный переулок, 28, 070012</li>
            <li class="contacts__item">
              <a href="tel:+7-778-638-93-94" class="contacts__link">
                +7&nbsp;(778)&nbsp;638-93-94
              </a>
            </li>
            <li class="contacts__item">
              <a href="tel:+7-705-500-00-70" class="contacts__link">
                +7&nbsp;(705)&nbsp;500-00-70
              </a>
            </li>
            <a href="mailto:Bek_m78@mail.ru" class="contacts__link">
              Bek_m78@mail.ru
            </a>
          </ul>
        </div>
      </div>
      <div class="footer__promo">
        <p class="container">
          <strong class="footer__promo-title icon icon__copyright">
            Индивидуальный предприниматель «Ер&nbsp;-&nbsp;Ас»&nbsp;&nbsp;&nbsp;2025
            <?php

            $startYear = 2025;
            $currentYear = (int)date("Y");

            if ($currentYear > $startYear) {
              echo " - " . $currentYear;
            }

            ?>
          </strong>
        </p>
      </div>
    </footer>
    </body>

    </html>