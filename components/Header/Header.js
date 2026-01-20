function initLangDropdown() {
  const btn = document.getElementById("langBtn");
  const dropdown = document.getElementById("langDropdown");

  if (!btn || !dropdown) return;

  btn.addEventListener("click", function (e) {
    e.stopPropagation();
    dropdown.style.display =
      dropdown.style.display === "block" ? "none" : "block";
  });

  document.addEventListener("click", function () {
    dropdown.style.display = "none";
  });
}

// Função de mudar idioma
function mudarIdioma(codigo, nome, img) {
  // Atualiza visualmente
  document.getElementById("langImg").src = img;
  document.getElementById("langText").innerText = nome;
  document.getElementById("langDropdown").style.display = "none";

  // Redireciona para setLang.php para atualizar $_SESSION
  window.location.href = `<?=APP_URL?>/components/Header/setLang.php?lang=${codigo}`;
}

// Inicia dropdown
document.addEventListener("DOMContentLoaded", initLangDropdown);