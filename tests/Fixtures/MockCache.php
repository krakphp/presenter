<?php

namespace Krak\Tests\Fixtures;

use Doctrine\Common\Cache\CacheProvider;

class MockCache extends CacheProvider
{
    /**
     * @var array $data
     */
    private $data = array();

    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    protected function doFetch($id)
    {
        return $this->doContains($id) ? $this->data[$id] : false;
    }
    /**
     * {@inheritdoc}
     */
    protected function doContains($id)
    {
        return isset($this->data[$id]) || array_key_exists($id, $this->data);
    }
    /**
     * {@inheritdoc}
     */
    protected function doSave($id, $data, $lifeTime = 0)
    {
        $this->data[$id] = $data;
        return true;
    }
    /**
     * {@inheritdoc}
     */
    protected function doDelete($id)
    {
        unset($this->data[$id]);
        return true;
    }
    /**
     * {@inheritdoc}
     */
    protected function doFlush()
    {
        $this->data = array();
        return true;
    }
    /**
     * {@inheritdoc}
     */
    protected function doGetStats()
    {
        return null;
    }
}
