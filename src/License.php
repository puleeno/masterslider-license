<?php
namespace Puleeno\MasterSlider;

class License
{
    protected $domain;

    public function __construct($domain = null)
    {
        if (!is_null($domain)) {
            $this->domain = $domain;
        }
    }
    public function setActiveDomain($domain)
    {
        $this->domain = $domain;
    }

    public function hook_to_msp_license_activation($ret = null)
    {
        add_filter('site_url', array($this, 'fakeLicenseDomain'), 10, 3);

        return $ret;
    }

    public function fakeLicenseDomain($url, $path, $scheme)
    {
        if (empty($scheme) || $scheme === 'admin') {
            $scheme = 'http';
        }
        return sprintf('%s://%s/%s', $scheme, rtrim($this->domain, '/'), ltrim($path, '/'));
    }

    public function fake()
    {
        add_action('wp_ajax_msp_license_activation', array($this, 'hook_to_msp_license_activation'), 5);
        add_filter('axiom_plugin_updater_custom_package_download_url', array($this, 'prepare_update'));
        add_filter('upgrader_pre_download', array($this, 'remove_site_url'));
    }

    public function prepare_update($ret = null)
    {
        add_action('requests-requests.before_request', array($this, 'filter_master_slider_arguments'), 10, 3);

        return $ret;
    }

    public function filter_master_slider_arguments(&$url, &$headers, &$data)
    {
        if (strpos($url, 'support.averta.ne') !== false) {
            $data['url'] = sprintf('http://%s', $this->domain);
        }
    }

    public function remove_site_url($ret)
    {
        remove_filter('site_url', array($this, 'fakeLicenseDomain'), 10, 3);
        return $ret;
    }
}
