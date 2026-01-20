<link rel="stylesheet" href="<?=APP_URL ?>/components/Header/Header.css">
<header class="topo">
  <img src="/bilheteria/assets/img/LogoFigma.png" alt="Museu Histórico do Exército" class="logo">

  <div class="lang-container">
    <button class="lang-btn" id="langBtn">
      <img id="langImg" src="https://cdn-icons-png.flaticon.com/512/3955/3955549.png" />
      <span id="langText">PORTUGUÊS</span>
    </button>

    <div class="lang-dropdown" id="langDropdown">
      <div class="lang-item" onclick="mudarIdioma('pt-br','PORTUGUÊS','https://cdn-icons-png.flaticon.com/512/3955/3955549.png')">
        <img src="https://cdn-icons-png.flaticon.com/512/3955/3955549.png"> Português
      </div>
      <div class="lang-item" onclick="mudarIdioma('en-US','English','https://cdn-icons-png.flaticon.com/512/330/330425.png')">
        <img src="https://cdn-icons-png.flaticon.com/512/330/330425.png"> English
      </div>
      <div class="lang-item" onclick="mudarIdioma('es-ES','Español','https://cdn-icons-png.flaticon.com/512/197/197593.png')">
        <img src="https://cdn-icons-png.flaticon.com/512/197/197593.png"> Español
      </div>
    </div>
  </div>
  <script src="<?=APP_URL ?>/components/Header/Header.js" defer></script>
</header>
