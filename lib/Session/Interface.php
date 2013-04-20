<?php

interface Session_Interface {

    public function __construct();

    public function get($name);

    public function set($name,$value);

    public function regenerate();

    public function destroy();

}
