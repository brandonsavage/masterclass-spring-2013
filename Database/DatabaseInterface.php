<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ricardo
 * Date: 4/19/13
 * Time: 4:11 PM
 * To change this template use File | Settings | File Templates.
 */

interface DatabaseInterface {

        public function __construct(array $config) ;

        public function select($sql, array $params) ;

        public function insert($sql,array $params) ;

        public function update($sql,array $params) ;

        public function delete($sql,array $params) ;
}