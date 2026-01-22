<div id="<?= $modalId ?>" class="overlay">
  <div class="modal">
    <h3 class="modal-title"><?= $modalTitle ?></h3>

    <div class="modal-list">
      <p class="modal-list-p"><?= t('termo_intro') ?></p>

      <strong class="modal-list-title"><?= t('termo_meia_title') ?></strong>
      <ul>
        <li><?= t('termo_professores') ?></li>
        <li><?= t('termo_estudantes') ?></li>
        <li><?= t('termo_maiores_60') ?></li>
        <li><?= t('termo_pcd_meia') ?></li>
        <li><?= t('termo_idjovem') ?></li>
      </ul>

      <strong class="modal-list-title"><?= t('termo_isento_title') ?></strong>
      <ul>
        <li><?= t('termo_militares_br') ?></li>
        <li><?= t('termo_militares_ext') ?></li>
        <li><?= t('termo_maiores_80') ?></li>
        <li><?= t('termo_menores_6') ?></li>
        <li><?= t('termo_guias') ?></li>
      </ul>

      <label class="termo-aceite">
        <input type="checkbox" id="aceiteTermos">
        <span><?= t('termo_aceite') ?></span>
      </label>

    </div>

    <div class="modal-footer">
      <button type="button" class="modal-cancel" id="btnCancelar" onclick="cancelarTermos()">
        <?= t('cancel') ?>
      </button>
      <button type="button" class="modal-confirm" id="btnConfirmar" disabled onclick="enviarParaPagamento()">
        <?= t('confirm') ?>
      </button>


    </div>
  </div>
</div>
