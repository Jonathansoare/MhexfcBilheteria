<?php
// Variáveis esperadas: $id, $label, $price, $description
?>

<!-- Auto-inclui CSS/JS do componente -->
<link rel="stylesheet" href="/components/Ticket/Ticket.css">
<script src="/components/Ticket/Ticket.js" defer></script>

<div class="ticket">
  <div class="ticket-info">
    <strong><?= $label ?></strong>
    <br>
    <span>R$ <?= number_format($price,2,',','.') ?></span>
    <?php if(!empty($description)): ?>
      <br><small><?= $description ?></small>
    <?php endif ?>
  </div>
  <div class="counter">
    <button type="button" onclick="updateQty('<?= $id ?>',-1)">-</button>
    <span id="q-<?= $id ?>">0</span>
    <button type="button" onclick="updateQty('<?= $id ?>',1)">+</button>
  </div>
  <input type="hidden" name="quantities[<?= $id ?>]" id="i-<?= $id ?>" value="0" data-price="<?= $price ?>">
</div>
