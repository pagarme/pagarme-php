<?php
namespace Pagarme;

use Pagarme\Request as PagarmeRequest,
    Pagarme\Exception as PagarmeException;

/**
 * Class Model
 * @package Pagarme
 */
class Model extends Object
{
    protected static $root_url;

    /**
     * @param array $response
     */
    public function __construct($response = array())
    {
        parent::__construct($response);
    }

    /**
     * @return string
     */
    public static function getUrl()
    {
        $class  = get_called_class();
        $search = preg_match("/Pagarme(.*)/", $class, $matches);

        return '/' . strtolower($matches[1]) . 's';
    }

    /**
     * @return array
     * @throws Exception
     */
    public function create()
    {
        try {
            $request    = new PagarmeRequest(self::getUrl(), 'POST');
            $parameters = $this->__toArray(true);
            $request->setParameters($parameters);
            $response = $request->run();

            return $this->refresh($response);

        } catch (\Exception $e) {
            throw new PagarmeException($e->getMessage());
        }

    }

    /**
     * @return array|bool
     * @throws Exception
     */
    public function save()
    {
        try {
            if (method_exists(get_called_class(), 'validate'))
                if (! $this->validate())
                    return false;

            $request    = new PagarmeRequest(self::getUrl() . '/' . $this->id, 'PUT');
            $parameters = $this->unsavedArray();
            $request->setParameters($parameters);
            $response = $request->run();

            return $this->refresh($response);

        } catch (\Exception $e) {
            throw new PagarmeException($e->getMessage());
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public static function findById($id)
    {
        $request  = new PagarmeRequest(self::getUrl() . '/' . $id, 'GET');
        $response = $request->run();
        $class    = get_called_class();

        return new $class($response);
    }

    /**
     * @param int $page
     * @param int $count
     * @return array
     * @throws Exception
     */
    public static function all($page = 1, $count = 10)
    {
        $request = new PagarmeRequest(self::getUrl(), 'GET');
        $request->setParameters(array("page" => $page, "count" => $count));
        $response     = $request->run();
        $return_array = Array();
        $class        = get_called_class();

        foreach ($response as $r)
            $return_array[] = new $class($r);


        return $return_array;
    }
}
