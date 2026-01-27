const ingressos = ['2x Inteira', '1x Meia'];
const validade = 'Hoje';
const total = 25;

const ul = document.getElementById('listaIngressos');
const validadeSpan = document.getElementById('resumoValidade');
const totalSpan = document.getElementById('resumoTotal');

ul.innerHTML = '';
ingressos.forEach(i => {
  const li = document.createElement('li');
  li.textContent = i;
  ul.appendChild(li);
});

validadeSpan.textContent = validade;
totalSpan.textContent = total.toFixed(2).replace('.', ',');