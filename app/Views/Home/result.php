<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/php/functions/util.php') ?>
<?= $this->extend('layouts/default') ?>
<?= $this->section('header') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

  <h1><?= $title ?></h1>

<?= $this->endSection() ?>

<?= $this->section('js') ?>

<?= $this->endSection() ?>