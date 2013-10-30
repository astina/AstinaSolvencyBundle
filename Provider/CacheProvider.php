<?php

namespace Astina\Bundle\SolvencyBundle\Provider;

use Astina\Bundle\SolvencyBundle\Provider\AddressInterface;
use Astina\Bundle\SolvencyBundle\Provider\ProviderInterface;
use Astina\Bundle\SolvencyBundle\Solvency\SolvencyResult;

class CacheProvider implements ProviderInterface
{
    private $realProvider;

    private $cachedDir;

    private $lifetime = null; // infinite

    public function __construct(ProviderInterface $realProvider, $cacheDir, $lifetime = null)
    {
        $this->realProvider = $realProvider;
        $this->cachedDir = $cacheDir;
        $this->lifetime = $lifetime;

        if (!is_writable($this->cachedDir) && !mkdir($this->cachedDir, 0775, true)) {
            throw new \Exception('Cache dir ' . $this->cachedDir . ' is not writable');
        }
    }

    /**
     * @{inheritDoc}
     */
    public function checkAddress(AddressInterface $address, array $options = null)
    {
        // cache hit?
        $result = $this->findCacheEntry($address, $options);
        if ($result) {
            return $result;
        }

        $result = $this->realProvider->checkAddress($address, $options);

        $this->cacheResult($result, $address, $options);

        return $result;
    }

    /**
     * @param $object
     * @param $options
     * @return SolvencyResult|null
     */
    private function findCacheEntry($object, $options)
    {
        $file = $this->createCacheFileName($object, $options);

        if (!file_exists($file)) {
            return null;
        }

        if ($this->lifetime && (filemtime($file) + $this->lifetime) > time() ) {
            return null;
        }

        $data = file_get_contents($file);

        if ($result = unserialize($data)) {
            return $result;
        }

        return null;
    }

    /**
     * @param $object
     * @param $options
     * @return string
     */
    private function createCacheFileName($object, $options)
    {
        $hash = $this->createHash($object, $options);

        return sprintf('%s/%s', $this->cachedDir, $hash);
    }

    /**
     * @param $object
     * @param $options
     * @return string
     */
    private function createHash($object, $options)
    {
        return md5(sprintf('%s#%s', (string) $object, serialize($options)));
    }

    /**
     * @param SolvencyResult $result
     * @param $object
     * @param $options
     */
    private function cacheResult(SolvencyResult $result, $object, $options)
    {
        $file = $this->createCacheFileName($object, $options);

        file_put_contents($file, serialize($result));
    }
}
