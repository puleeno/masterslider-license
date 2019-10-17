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

    public function fake_request_info($r, $url)
    {
        if (false !== strpos($url, 'support.averta.net')) {
            $r['user-agent'] = str_replace(get_site_url(), $this->domain, $r['user-agent']);
            $r['body']['url'] = $this->domain;
        }
        return $r;
    }

    public function fake()
    {
        if (!wp_http_validate_url($this->domain)) {
            return;
        }
        add_action('http_request_args', array($this, 'fake_request_info'), 10, 2);
    }
}
