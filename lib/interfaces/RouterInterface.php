<?php
// declare namespace
namespace Routers;

/**
 * Router interface
 */
interface RouterInterface {

    public function get(string $path, callable $callback);

    public function post(string $path, callable $callback);

    public function get_body();

}