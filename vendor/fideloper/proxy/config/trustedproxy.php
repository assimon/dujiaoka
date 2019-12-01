<?php

return [

    /*
     * Set trusted proxy IP addresses.
     *
     * Both IPv4 and IPv6 addresses are
     * supported, along with CIDR notation.
     *
     * The "*" character is syntactic sugar
     * within TrustedProxy to trust any proxy
     * that connects directly to your server,
     * a requirement when you cannot know the address
     * of your proxy (e.g. if using Rackspace balancers).
     *
     * The "**" character is syntactic sugar within
     * TrustedProxy to trust not just any proxy that
     * connects directly to your server, but also
     * proxies that connect to those proxies, and all
     * the way back until you reach the original source
     * IP. It will mean that $request->getClientIp()
     * always gets the originating client IP, no matter
     * how many proxies that client's request has
     * subsequently passed through.
     */
    'proxies' => [
        '192.168.1.10',
    ],

    /*
     * Or, to trust all proxies that connect
     * directly to your server, uncomment this:
     */
     # 'proxies' => '*',

    /*
     * Or, to trust ALL proxies, including those that
     * are in a chain of forwarding, uncomment this:
    */
    # 'proxies' => '**',

    /*
     * Default Header Names
     *
     * Change these if the proxy does
     * not send the default header names.
     *
     * Note that headers such as X-Forwarded-For
     * are transformed to HTTP_X_FORWARDED_FOR format.
     *
     * The following are Symfony defaults, found in
     * \Symfony\Component\HttpFoundation\Request::$trustedHeaders
     *
     * You may optionally set headers to 'null' here if you'd like
     * for them to be considered untrusted instead. Ex:
     *
     * Illuminate\Http\Request::HEADER_CLIENT_HOST  => null,
     * 
     * WARNING: If you're using AWS Elastic Load Balancing or Heroku,
     * the FORWARDED and X_FORWARDED_HOST headers should be set to null 
     * as they are currently unsupported there.
     */
    'headers' => [
        (defined('Illuminate\Http\Request::HEADER_FORWARDED') ? Illuminate\Http\Request::HEADER_FORWARDED : 'forwarded') => 'FORWARDED',
        Illuminate\Http\Request::HEADER_CLIENT_IP    => 'X_FORWARDED_FOR',
        Illuminate\Http\Request::HEADER_CLIENT_HOST  => 'X_FORWARDED_HOST',
        Illuminate\Http\Request::HEADER_CLIENT_PROTO => 'X_FORWARDED_PROTO',
        Illuminate\Http\Request::HEADER_CLIENT_PORT  => 'X_FORWARDED_PORT',
    ]
];
