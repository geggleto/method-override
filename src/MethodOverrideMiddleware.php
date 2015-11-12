<?php
/**
 * Created by PhpStorm.
 * User: Glenn
 * Date: 2015-11-12
 * Time: 11:26 AM
 */

namespace Geggleto\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MethodOverrideMiddleware
{
    public function __construct ()
    {
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $requestInterface
     * @param \Psr\Http\Message\ResponseInterface      $responseInterface
     * @param callable                                 $next
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $requestInterface,
        ResponseInterface $responseInterface,
        callable $next)
    {
        if (strtoupper($requestInterface->getMethod()) == 'GET') {
            $method = $requestInterface->getQueryParams()['_method'];
            $requestInterface = $requestInterface->withMethod($method);
        }

        return $next($requestInterface, $responseInterface);
    }
}