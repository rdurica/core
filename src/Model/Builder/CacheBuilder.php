<?php declare(strict_types=1);

namespace Rdurica\Core\Model\Builder;

use Nette\Caching\Cache;
use Nette\Caching\Storage;
use Throwable;

/**
 * CacheBuilder.
 *
 * @package   Rdurica\Core\Model\Builder
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2024-01-29
 */
final class CacheBuilder
{
    private Cache $cache;

    /**
     * Constructor.
     *
     * @param Storage $storage
     * @param string  $key
     */
    private function __construct(Storage $storage, private string $key)
    {
        $this->cache = new Cache($storage, $key);
    }

    /**
     * Create new instance of builder.
     *
     * @param Storage $storage
     * @param string  $key
     *
     * @return self
     */
    public static function create(Storage $storage, string $key): self
    {
        return new self($storage, $key);
    }

    /**
     * Save data.
     *
     * @param mixed  $data
     * @param string $expiration
     *
     * @return void
     */
    public function save(mixed $data, string $expiration = '1 hour'): void
    {
        $this->cache->save($this->key, $data, [
            $this->cache::Expire => $expiration,
        ]);
    }

    /**
     * Load data.
     *
     * @return mixed
     * @throws Throwable
     */
    public function load(): mixed
    {
        return $this->cache->load($this->key);
    }

    /**
     * Clear cached data.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->cache->save($this->key, null);
    }
}
