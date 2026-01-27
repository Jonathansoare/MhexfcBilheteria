<div id="<?= $modalId ?>" class="overlay">
  <div class="modal">
    <h3 class="modal-title"><?= $modalTitle ?></h3>

    <div class="modal-list">
      <?php foreach($ingressosConfirm as $i): ?>
        <div class="modal-item">
          <span><?= $i['label'] ?> x <?= $i['qtd'] ?></span>
          <span>R$ <?= number_format($i['total'],2,',','.') ?></span>
          <span>Validade:<?= $i['validade'] ?></span>
        </div>
      <?php endforeach; ?>
      <div class="modal-item total">
        <span>Total:</span>
        <span>R$ <?= number_format($total,2,',','.') ?></span>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="modal-cancel" onclick="fecharModal('<?= $modalId ?>')">Cancelar</button>
      <button type="button" class="modal-confirm" onclick="enviarParaPagamento()">Confirmar</button>
    </div>
  </div>
</div>
