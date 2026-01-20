/**
 * Ticket.js
 * Script para manipulação dos tickets
 * Autor: Jonathan
 * Versão: 1.0
 * 
 * Funcionalidades:
 * - Aumentar/diminuir quantidade de tickets
 * - Atualizar total de ingressos e valor
 * - Definir validade do ingresso
 * - Feedback tátil com vibrar()
 */

// === Inicializa preços de cada ticket automaticamente ===
const prices = {};

// Preenche o objeto prices com os valores de cada ticket
document.querySelectorAll('.ticket input[type="hidden"]').forEach(input => {
  const id = input.id.replace('i-', '');
  prices[id] = parseFloat(input.dataset.price);
});

/**
 * Aumenta ou diminui a quantidade de um ticket
 * @param {string} id - ID do ticket
 * @param {number} change - Mudança na quantidade (+1 ou -1)
 */
function updateQty(id, change) {
  const span = document.getElementById(`q-${id}`);
  const input = document.getElementById(`i-${id}`);
  let value = parseInt(span.innerText);

  value += change;
  if (value < 0) value = 0;

  span.innerText = value;
  input.value = value;

  vibrar();
  calcularTotal();
}

/**
 * Define a validade do ingresso e atualiza botão ativo
 * @param {string} valor - Valor da validade ('hoje', '3dias', '7dias')
 * @param {HTMLElement} botao - Botão clicado
 */
function setValidade(valor, botao) {
  document.getElementById('validade').value = valor;

  let texto = 'Hoje';
  if (valor === '3dias') texto = 'Válido por 3 dias';
  if (valor === '7dias') texto = 'Válido por 7 dias';

  document.getElementById('validadeTexto').innerText = texto;

  // Atualiza botão ativo
  document.querySelectorAll('.validade button').forEach(btn => btn.classList.remove('active'));
  botao.classList.add('active');

  vibrar();
}

/**
 * Formata número para string de moeda brasileira
 * @param {number} valor
 * @returns {string} valor formatado
 */
function formatar(valor) {
  return valor.toFixed(2).replace('.', ',');
}

/**
 * Calcula o total de ingressos e valor
 * Atualiza o resumo da compra
 */
function calcularTotal() {
  let totalIngressos = 0;
  let totalValor = 0;

  for (let id in prices) {
    const qtd = parseInt(document.getElementById(`i-${id}`).value);
    totalIngressos += qtd;
    totalValor += qtd * prices[id];
  }

  document.getElementById("totalIngressos").innerText = totalIngressos;
  document.getElementById("totalValor").innerText = formatar(totalValor);

  // Habilita/desabilita o botão Continuar
  const btn = document.getElementById("btnContinuar");
  if (btn) btn.disabled = totalIngressos === 0;
}

/**
 * Pequena vibração visual ao clicar nos botões (feedback tátil)
 */
function vibrar() {
  if (navigator.vibrate) navigator.vibrate(20);
}

// Inicializa o total ao carregar a página
document.addEventListener('DOMContentLoaded', () => {
  calcularTotal();
});
