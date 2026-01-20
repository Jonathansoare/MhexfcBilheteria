<?php
require_once __DIR__ . '/../../helpers/i18n.php';
?>

<link rel="stylesheet" href="<?=APP_URL ?>/components/VisitanteForm/VisitanteForm.css">

<div class="form-visitante-container">
  <form class="formVisitante" id="formVisitante">

    <h2><?= t('fill_your_data') ?></h2>

    <!-- Tipo de visitante -->
    <label for="tipoVisitante"><?= t('nationality') ?></label>
    <select id="tipoVisitante" onchange="trocarDocumento()">
      <option value="br"><?= t('brazilian') ?></option>
      <option value="gringo"><?= t('foreigner') ?></option>
    </select>

    <!-- Nome completo -->
    <label for="nome"><?= t('full_name') ?></label>
    <input 
      type="text" 
      id="nome" 
      name="nome" 
      placeholder="<?= t('full_name_placeholder') ?>" 
      required
    >

    <!-- CPF -->
    <label for="cpf" id="label-cpf"><?= t('cpf') ?></label>
    <input 
      type="text" 
      id="cpf" 
      name="cpf" 
      placeholder="<?= t('cpf_placeholder') ?>" 
      required
    >

    <!-- Passaporte -->
    <label for="passaporte" id="label-passaporte" style="display:none">
      <?= t('passport') ?>
    </label>
    <input 
      type="text" 
      id="passaporte" 
      name="passaporte" 
      placeholder="<?= t('passport_placeholder') ?>" 
      style="display:none" 
      required
    >

    <!-- Email -->
    <label for="email"><?= t('email') ?></label>
    <input 
      type="email" 
      id="email" 
      name="email" 
      placeholder="<?= t('email_placeholder') ?>" 
      required
    >

    <!-- Telefone -->
    <label for="telefone"><?= t('phone') ?></label>
    <input 
      type="text" 
      id="telefone" 
      name="telefone" 
      placeholder="<?= t('phone_placeholder') ?>" 
      required
    >

    <button type="button" onclick="validarForm()"><?= t('continue') ?></button>

  </form>
</div>
