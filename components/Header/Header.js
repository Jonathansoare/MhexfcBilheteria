console.log("Header.js carregado");

document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("langBtn");
  const dropdown = document.getElementById("langDropdown");

  if (!btn || !dropdown) return;

  btn.addEventListener("click", e => {
    e.stopPropagation();
    dropdown.classList.toggle("show");
  });


  document.addEventListener("click", () => {
    dropdown.classList.remove("show");
  });

  dropdown.querySelectorAll(".lang-item").forEach(item => {
    item.addEventListener("click", () => {
      const codigo = item.dataset.codigo;
      const label  = item.dataset.label;
      const img    = item.dataset.img;

      document.getElementById("langImg").src = img;
      document.getElementById("langText").innerText = label;
      dropdown.classList.remove("show");

      fetch("/bilheteria/components/Header/setLang.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "lang=" + codigo
      }).then(() => location.reload());

    });
  });
});
