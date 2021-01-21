<?php
namespace Laminas\Hydrator\Strategy;

use Laminas\Cache\Storage\Adapter\Filesystem;
use YPHP\Model\Stream\EntityStream;
use YPHP\Stream;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\HttpClient;
use Laminas\Uri\Uri;
use Laminas\Cache\Storage\StorageInterface;
use Laminas\Hydrator\Strategy\Serializable\StaticServer;

final class StreamStrategy implements StrategyInterface
{
    public static $USE_CACHE = true;

    /**
     * @var mixed
     */
    protected $serialize;

        /**
     * @var HttpClientInterface
     */
    protected $client;

    /**
     * @var StorageInterface
     */
    protected $cache;

    public function __construct($serialize = null,HttpClientInterface $client = null,StorageInterface $cache = null)
    {
        if(!$cache){
            $cache = new Filesystem([
                "key_pattern" => "",
                "dir_level"=>0,
                "suffix"=>"json",
                "namespace_separator"=>"",
                "tag_suffix"=>"",
                "namespace"=>"",
                "ttl"=>0,
            ]);
        }
        if(!$serialize) $serialize = new StaticServer;
        $this->serialize = $serialize;
        if(!$client) $client = HttpClient::create();
        $this->client = $client;
        $this->cache = $cache;
    }

    /**
     * {@inheritDoc}
     *
     * Converts to date time string
     *
     * @param mixed|DateTimeInterface $value
     * @return mixed|string If a non-DateTimeInterface $value is provided, it
     *     will be returned unmodified; otherwise, it will be extracted to a
     *     string.
     */
    public function extract($value, ?object $object = null)
    {
        if($value instanceof EntityStream) {
            return (string)$value->getStream();
        }
        return $value;
    }

    /**
     * Converts date time string to DateTime instance for injecting to object
     *
     * {@inheritDoc}
     *
     * @param mixed|string $value
     * @return mixed|DateTimeInterface
     * @throws Exception\InvalidArgumentException if $value is not null, not a
     *     string, nor a DateTimeInterface.
     */
    public function hydrate($value,?array $data)
    {
        if ($value === '' || $value === null || $value instanceof Stream) {
            return $value;
        }
        $entity = null;
        $key = \seo_friendly_url($value);
        if(self::$USE_CACHE){
            $entity = unserialize($this->cache->getItem($key));
            if($entity){
                return $entity;
            }else{
                $this->cache->removeItem($key);
            }
        }else{
            $this->cache->removeItem($key);
        }
        if(is_string($value)){
            $result = null;
            if(file_exists($value)){
                $result = \file_get_contents($value);
            }else{
                $uri = new Uri($value);
                if($uri->isValid()){
                    $result = $this->client->request("GET",(string)$uri,[
                        'verify_host' => false,
                        'verify_peer' => false,
                        'extra' => [
                            'curl' => [
                                //\CURLOPT_SSL_VERIFYPEER => false,
                                //\CURLOPT_SSL_VERIFYHOST => false,
                                //CURLOPT_PROXY_SSL_VERIFYPEER => false,
                            ]
                        ]
                    ])->getContent(false);
                }
            }
            $entity = $this->serialize->decode($result);
        }
        if($entity instanceof EntityStream){
            $stream = new Stream();
            $stream->setSource($value);
            $entity->setStream($stream);
        }
        $this->cache->setItem($key,serialize($entity));
        return $entity;
    }
}
