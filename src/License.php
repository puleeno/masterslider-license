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

    public function hook_to_msp_license_activation()
    {
        add_filter( 'site_url', array($this, 'fakeLicenseDomain'), 10, 3 );
    }

    public function fakeLicenseDomain( $url, $path, $scheme) {
        if (empty($scheme)) {
            $scheme = 'http';
        }
        return sprintf('%s://%s%s', $scheme, $this->domain, $path);
    }

    public function fake()
    {
        add_action('wp_ajax_msp_license_activation', array($this, 'hook_to_msp_license_activation'), 5);
    }
}
