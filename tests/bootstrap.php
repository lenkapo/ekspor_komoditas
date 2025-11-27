<?php
// Basic bootstrap for PHPUnit to run CodeIgniter components in isolation.
// Note: For full CI test harness, you might integrate ci-phpunit-test. Here we mock minimal dependencies.

define('ENVIRONMENT', 'testing');

define('BASEPATH', __DIR__ . '/../system/');
define('APPPATH', __DIR__ . '/../app/');

autoload_ci();

function autoload_ci()
{
    // Minimal autoload to load CI core base classes for type references
    require_once __DIR__ . '/../system/core/Controller.php';
    require_once __DIR__ . '/../system/core/Model.php';
}

// Simple dummy CI superobjects to satisfy references during unit tests.
class CI_Controller {}
class CI_Model {}

// Very small stubs to mimic loader and CI mechanisms used in the target code.
class LoaderStub {
    private $container = [];

    public function model($name, $alias = null)
    {
        // In tests we will inject mocks into controller directly; keep stub simple
        $this->container[$alias ?: $name] = null;
    }

    public function view($view, $data = [])
    {
        // No-op for controller tests
        return true;
    }
}

class InputStub {
    private $post = [];
    public function setPost($arr) { $this->post = $arr; }
    public function post($key) { return $this->post[$key] ?? null; }
}

class SessionStub {
    public $flashdata = [];
    public function set_flashdata($key, $msg) { $this->flashdata[$key] = $msg; }
}

class AlusAuthStub {
    private $loggedIn = false;
    public function set_logged_in($val) { $this->loggedIn = (bool)$val; }
    public function logged_in() { return $this->loggedIn; }
}

class SecurityStub {
    public function xss_clean($str) { return $str; }
}

function redirect($path, $method = 'refresh') { return ["redirect", $path, $method]; }
