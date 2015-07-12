<?php

namespace Pagarme;

use \Exception as BaseException;

class Model extends Object
{
    public static function getUrl() {
        $parts = explode('\\', get_called_class());
        $search = end($parts);
        return '/' . strtolower($search) . 's';
    }

    public function create() {
        try {
            $request = new Request();
            $parameters = $this->__toarray(true);
            $request->setParameters($parameters);
            $response = $request->send(self::getUrl(), 'POST');
            return $this->refresh($response);
        } catch(BaseException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function save() 
    {
        try {
            if (method_exists(get_called_class(), 'validate')) {
                if (!$this->validate()) return false;
            }
            $request = new Request();
            $parameters = $this->unsavedarray();
            $request->setParameters($parameters);
            $response = $request->send(self::getUrl(). '/' . $this->id, 'PUT');
            return $this->refresh($response);
        } catch(BaseException $e) {
            throw new Exception($e->getMessage());
        }
    }


    public static function findById($id) 
    {
        $request = new Request();
        $response = $request->send(self::getUrl() . '/' . $id, 'GET');
        $class = get_called_class(); 
        return new $class($response);
    }

    public static function all($page = 1, $count = 10) 
    {
        $request = new Request();
        $request->setParameters(array('page' => $page, 'count' => $count));
        $response = $request->send(self::getUrl(), 'GET');
        $return_array = array();
        $class = get_called_class();
        
        foreach ($response as $r) {
            $return_array[] = new $class($r);
        }

        return $return_array;
    }
}