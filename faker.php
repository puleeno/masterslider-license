<?php

add_action('plugins_loaded', 'master_slidear_license_faker');
function master_slidear_license_faker()
{
    $license = new Puleeno\MasterSlider\License();
    $domain = defined('MASTER_SLIDER_ACTIVE_DOMAIN') ? constant('MASTER_SLIDER_ACTIVE_DOMAIN') : '';

    $license->setActiveDomain(apply_filters('master_slider_active_domain', $domain));
    $license->fake();
}
