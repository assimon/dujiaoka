<?php

namespace Fideloper\Proxy;

use Closure;
use Illuminate\Contracts\Config\Repository;

class TrustProxies
{
    /**
     * The config repository instance.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * The trusted proxies for the application.
     *
     * @var array
     */
    protected $proxies;

    /**
     * The proxy header mappings.
     *
     * @var array
     */
    protected $headers;

    /**
     * Create a new trusted proxies middleware instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->setTrustedProxyHeaderNames($request);
        $this->setTrustedProxyIpAddresses($request);

        return $next($request);
    }

    /**
     * Sets the trusted proxies on the request to the value of trustedproxy.proxies
     *
     * @param \Illuminate\Http\Request $request
     */
    protected function setTrustedProxyIpAddresses($request)
    {
        $trustedIps = $this->proxies ?: $this->config->get('trustedproxy.proxies');

        // We only trust specific IP addresses
        if (is_array($trustedIps)) {
            return $this->setTrustedProxyIpAddressesToSpecificIps($request, $trustedIps);
        }

        // We trust any IP address that calls us, but not proxies further
        // up the forwarding chain.
        // TODO: Determine if this should only trust the first IP address
        //       Currently it trusts the entire chain (array of IPs),
        //       potentially making the "**" convention redundant.
        if ($trustedIps === '*') {
            return $this->setTrustedProxyIpAddressesToTheCallingIp($request);
        }

        // We trust all proxies. Those that call us, and those that are
        // further up the calling chain (e.g., where the X-FORWARDED-FOR
        // header has multiple IP addresses listed);
        if ($trustedIps === '**') {
            return $this->setTrustedProxyIpAddressesToAllIps($request);
        }
    }

    /**
     * We specify the IP addresses to trust explicitly.
     *
     * @param \Illuminate\Http\Request $request
     * @param array                    $trustedIps
     */
    private function setTrustedProxyIpAddressesToSpecificIps($request, $trustedIps)
    {
        $request->setTrustedProxies((array) $trustedIps, $this->getTrustedHeaderSet());
    }

    /**
     * We set the trusted proxy to be the first IP addresses received.
     *
     * @param \Illuminate\Http\Request $request
     */
    private function setTrustedProxyIpAddressesToTheCallingIp($request)
    {
        $request->setTrustedProxies($request->getClientIps(), $this->getTrustedHeaderSet());
    }

    /**
     * Trust all IP Addresses.
     *
     * @param \Illuminate\Http\Request $request
     */
    private function setTrustedProxyIpAddressesToAllIps($request)
    {
        // 0.0.0.0/0 is the CIDR for all ipv4 addresses
        // 2000:0:0:0:0:0:0:0/3 is the CIDR for all ipv6 addresses currently
        // allocated http://www.iana.org/assignments/ipv6-unicast-address-assignments/ipv6-unicast-address-assignments.xhtml
        $request->setTrustedProxies(['0.0.0.0/0', '2000:0:0:0:0:0:0:0/3'], $this->getTrustedHeaderSet());
    }

    /**
     * Set the trusted header names based on the content of trustedproxy.headers.
     *
     * Note: Depreciated in Symfony 3.3+, but available for backwards compatibility.
     *
     * @depreciated
     *
     * @param \Illuminate\Http\Request $request
     */
    protected function setTrustedProxyHeaderNames($request)
    {
        $trustedHeaderNames = $this->getTrustedHeaderNames();

        if(!is_array($trustedHeaderNames)) { return; } // Leave the defaults

        foreach ($trustedHeaderNames as $headerKey => $headerName) {
            $request->setTrustedHeaderName($headerKey, $headerName);
        }
    }

    /**
     * Retrieve trusted header names, falling back to defaults if config not set.
     *
     * @return array
     */
    protected function getTrustedHeaderNames()
    {
        return $this->headers ?: $this->config->get('trustedproxy.headers');
    }

    /**
     * Construct bit field integer of the header set that setTrustedProxies() expects.
     *
     * @return int
     */
    protected function getTrustedHeaderSet()
    {
        $trustedHeaderNames = $this->getTrustedHeaderNames();
        $headerKeys = array_keys($this->getTrustedHeaderNames());

        return array_reduce($headerKeys, function ($set, $key) use ($trustedHeaderNames) {
            // PHP 7+ gives a warning if non-numeric value is used
            // resulting in a thrown ErrorException within Laravel
            // This error occurs with Symfony < 3.3, PHP7+
            if(! is_numeric($key)) {
                return $set;
            }

            // If the header value is null, it is a distrusted header,
            // so we will ignore it and move on.
            if (is_null($trustedHeaderNames[$key])) {
                return $set;
            }

            return $set | $key;
        }, 0);
    }
}
