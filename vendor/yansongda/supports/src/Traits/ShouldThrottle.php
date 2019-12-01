<?php

namespace Yansongda\Supports\Traits;

use Predis\Client;

/**
 * Trait ShouldThrottle
 *
 * @property Client $redis
 */
trait ShouldThrottle
{
    /**
     * _throttle.
     *
     * @var array
     */
    protected $_throttle = [
        'limit' => 60,
        'period' => 60,
        'count' => 0,
        'reset_time' => 0
    ];

    /**
     * isThrottled.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $key
     * @param int    $limit
     * @param int    $period
     * @param bool   $auto_add
     *
     * @return bool
     */
    public function isThrottled($key, $limit = 60, $period = 60, $auto_add = false)
    {
        if ($limit === -1) {
            return false;
        }

        $now = microtime(true) * 1000;

        $this->redis->zremrangebyscore($key, 0, $now - $period * 1000);

        $this->_throttle = [
            'limit' => $limit,
            'period' => $period,
            'count' => $this->getThrottleCounts($key, $period),
            'reset_time' => $this->getThrottleResetTime($key, $now),
        ];

        if ($this->_throttle['count'] < $limit) {
            if ($auto_add) {
                $this->throttleAdd($key, $period);
            }

            return false;
        }

        return true;
    }

    /**
     * 限流 + 1.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $key
     * @param int    $period
     *
     * @return void
     */
    public function throttleAdd($key, $period = 60)
    {
        $now = microtime(true) * 1000;

        $this->redis->zadd($key, [$now => $now]);
        $this->redis->expire($key, $period * 2);
    }

    /**
     * getResetTime.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param $key
     * @param $now
     *
     * @return int
     */
    public function getThrottleResetTime($key, $now)
    {
        $data = $this->redis->zrangebyscore(
            $key,
            $now - $this->_throttle['period'] * 1000,
            $now,
            ['limit' => [0, 1]]
        );

        if (count($data) === 0) {
            return $this->_throttle['reset_time'] = time() + $this->_throttle['period'];
        }

        return intval($data[0] / 1000) + $this->_throttle['period'];
    }

    /**
     * 获取限流相关信息.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param null $key
     * @param null $default
     *
     * @return array|null
     */
    public function getThrottleInfo($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->_throttle;
        }

        if (isset($this->_throttle[$key])) {
            return $this->_throttle[$key];
        }

        return $default;
    }

    /**
     * 获取已使用次数.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param     $key
     * @param int $period
     *
     * @return string
     */
    public function getThrottleCounts($key, $period = 60)
    {
        $now = microtime(true) * 1000;

        return $this->redis->zcount($key, $now - $period * 1000, $now);
    }
}
