<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CoreBundle\Wrapper\Abstracts;

use Doctrine\Common\Cache\CacheProvider;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\CoreBundle\Entity\Interfaces\LanguageInterface;
use Elcodi\CoreBundle\Services\LanguageManager;

/**
 * Abstract caching wrapper
 *
 * This abstract class provides an easy way of mapping loaded data
 * Is just a wrapper, so every cache manager will have to extend this.
 *
 * When a key is provided, real key is built by appending current locale.
 */
abstract class AbstractCacheWrapper
{

    /**
     * @var EntityManager
     */
    public $entityManager;

    /**
     * @var LanguageManager
     *
     * LanguageManager
     */
    protected $languageManager;

    /**
     * @var CacheProvider
     *
     * Cache provider instance
     */
    protected $cache;

    /**
     * @var string
     *
     * Locale
     */
    protected $locale;

    /**
     * @var string
     *
     * Cache key
     */
    protected $key;

    /**
     * Set LanguageManager
     *
     * @param LanguageManager $languageManager LanguageManager
     *
     * @return AbstractCacheWrapper self Object
     */
    public function setLanguageManager(LanguageManager $languageManager)
    {
        $this->languageManager = $languageManager;

        return $this;
    }

    /**
     * Set Cache
     *
     * @param CacheProvider $cache Cache
     *
     * @return AbstractCacheWrapper self Object
     */
    public function setCache(CacheProvider $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * Set Request
     *
     * @param Request $request Request
     *
     * @return AbstractCacheWrapper self Object
     */
    public function setRequest(Request $request = null)
    {
        if ($request instanceof Request) {

            $this->locale = $request->getLocale();
        }

        return $this;
    }

    /**
     * Set Key
     *
     * @param string $key Key
     *
     * @return AbstractCacheWrapper self Object
     */
    public function setKey($key = '')
    {
        if (!empty($this->locale)) {

            $key .= '-' . $this->locale;
        }

        $this->key = $key;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string Locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Remove specific locale cache value
     *
     * @return AbstractCacheWrapper self Object
     */
    public function emptyCurrent()
    {
        $this->cache->delete($this->key);

        return $this;
    }

    /**
     * Remove cached languages
     *
     * All enabled and non-deleted locales keys will attempted to be deleted
     *
     * @return AbstractCacheWrapper self Object
     */
    public function emptyAll()
    {
        if (!($this->languageManager instanceof LanguageManager)) {
            return $this;
        }

        $languages = $this
            ->languageManager
            ->getLanguages();

        /**
         * @var LanguageInterface $language
         */
        foreach ($languages as $language) {

            $this->cache->delete($this->key . $language->getIso());
        }

        return $this;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
