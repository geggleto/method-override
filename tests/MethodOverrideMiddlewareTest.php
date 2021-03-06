<?php

use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\UploadedFile;
use Slim\Http\Uri;

/**
 * Created by PhpStorm.
 * User: Glenn
 * Date: 2015-11-12
 * Time: 11:31 AM
 */
class MethodOverrideMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    public function requestFactory($queryString = '', $method = 'GET')
    {
        $env = Environment::mock();
        $uri = Uri::createFromString('https://example.com:443/foo/bar'.$queryString);
        $headers = Headers::createFromEnvironment($env);
        $cookies = ['user' => 'john',
                    'id'   => '123',];
        $serverParams = $env->all();
        $body = new RequestBody();
        $uploadedFiles = UploadedFile::createFromEnvironment($env);
        $request = new Request($method,
            $uri,
            $headers,
            $cookies,
            $serverParams,
            $body,
            $uploadedFiles);

        return $request;
    }

    public function testGETMethodOverride()
    {
        $methodOverride = new \Geggleto\Middleware\MethodOverrideMiddleware();

        $request = $this->requestFactory("?_method=POST");
        $response = new Slim\Http\Response();

        /** @var $res \Psr\Http\Message\ResponseInterface */
        $method = $methodOverride($request, $response, function (Request $req, \Slim\Http\Response $res) {
            return $req->getMethod();
        });

        $this->assertEquals('POST', $method);
    }


    public function testPOSTMethodOverride()
    {
        $methodOverride = new \Geggleto\Middleware\MethodOverrideMiddleware();

        $request = $this->requestFactory('', 'POST');
        $request = $request->withParsedBody(["_method" => "GET"]);

        $response = new Slim\Http\Response();

        /** @var $res \Psr\Http\Message\ResponseInterface */
        $method = $methodOverride($request, $response, function (Request $req, \Slim\Http\Response $res) {
            return $req->getMethod();
        });

        $this->assertEquals('GET', $method);
    }

    public function testHeaderMethodOverride()
    {
        $methodOverride = new \Geggleto\Middleware\MethodOverrideMiddleware();

        $request = $this->requestFactory('', 'POST');
        $request = $request->withHeader("X-Http-Method-Override", "PUT");

        $response = new Slim\Http\Response();

        /** @var $res \Psr\Http\Message\ResponseInterface */
        $method = $methodOverride($request, $response, function (Request $req, \Slim\Http\Response $res) {
            return $req->getMethod();
        });

        $this->assertEquals('PUT', $method);
    }
}
