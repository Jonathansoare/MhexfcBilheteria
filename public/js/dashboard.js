function validarPrecos(){
  let ok = true;
  document.querySelectorAll('.preco-input').forEach(i=>{
    let v = i.value.replace(',','.');
    if(isNaN(v) || parseFloat(v) < 0){
      i.style.border = '2px solid #e74c3c';
      ok = false;
    } else {
      i.style.border = '1px solid #ccc';
    }
  });
  if(!ok) alert("⚠️ Corrija os preços inválidos antes de salvar.");
  return ok;
}