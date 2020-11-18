<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-16
 * Time: 下午 05:10
 */
namespace App\Entity;
class IpVisit implements OrmEntity
{
    private $ip = 0;
    private $uri = "";
    private $query = "";
    private $id = 0;

    /**
     * @return int
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param int $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    function getDbArray()
    {
        // TODO: Implement getDbArray() method.
        return [
            'ip' => $this->getIp(),
            'uri' => $this->getUri(),
            'query' => $this->getQuery(),
        ];
    }


}