<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$lang = $_SESSION['lang'] ?? 'pt-BR';

$idiomas = [
  'pt-BR' => ['label' => 'PORTUGUÊS', 'img' => 'https://cdn-icons-png.flaticon.com/512/3955/3955549.png'],
  'en-US' => ['label' => 'ENGLISH',   'img' => 'https://cdn-icons-png.flaticon.com/512/330/330425.png'],
  'es-ES' => ['label' => 'ESPAÑOL',   'img' => 'https://cdn-icons-png.flaticon.com/512/197/197593.png'],
];

$atual = $idiomas[$lang] ?? $idiomas['pt-BR'];
?>

<link rel="stylesheet" href="<?= APP_URL ?>/components/Header/Header.css">

<header class="topo">
  <div class="logo">
      <img src="<?= APP_URL ?>/assets/img/MHEXFC0.png" class="logo" alt="Museu">
      <div class="Logo-text">
        <div class="Logo-title">Museu Histórico do Exército e Forte de Copacabana</div>
        <span>Forte! Cultura, Memória e Tradição!</span>
      </div>
  </div>

  <div class="lang-container">
    <button class="lang-btn" id="langBtn" type="button">
      <img id="langImg" src="<?= $atual['img'] ?>">
      <span id="langText"><?= $atual['label'] ?></span>
    </button>

    <div class="lang-dropdown" id="langDropdown">
      <?php foreach ($idiomas as $codigo => $info): ?>
        <?php if ($codigo !== $lang): ?>
          <div class="lang-item"
               data-codigo="<?= $codigo ?>"
               data-label="<?= $info['label'] ?>"
               data-img="<?= $info['img'] ?>">
            <img src="<?= $info['img'] ?>"> <?= $info['label'] ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</header>

<script src="./Header.js" defer></script>
