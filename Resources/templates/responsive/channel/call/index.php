<?php

//$meta_img = $this->workshop->header_image ? $this->workshop->getHeaderImage()->getLink(700, 700, false, true) : $this->asset('img/blog/header_default.png') ;

$this->layout('channel/call/layout', [
	'bodyClass' => 'channel-call',
    'title' => $this->channel->name,
    'meta_description' => $this->channel->subtitle,
    'tw_image' => $meta_img
    ]);

$this->section('channel-content');

?>

<?= $this->insert('channel/call/partials/banner_header') ?>

<?= $this->insert('channel/call/partials/main_info') ?>

<?= $this->insert('channel/call/partials/call_to_action') ?>

<?= $this->insert('channel/call/partials/program') ?>

<?= $this->insert('channel/call/partials/sponsors') ?>

<?php $this->replace() ?>