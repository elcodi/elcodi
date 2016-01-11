<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Store\Entity;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;
use Elcodi\Component\Store\Entity\Interfaces\StoreInterface;

/**
 * Class Store.
 */
class Store implements StoreInterface
{
    use IdentifiableTrait,
        DateTimeTrait,
        EnabledTrait;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * @var string
     *
     * Leitmotiv
     */
    protected $leitmotiv;

    /**
     * @var string
     *
     * Email
     */
    protected $email;

    /**
     * @var bool
     *
     * Is company
     */
    protected $isCompany;

    /**
     * @var string
     *
     * NIF/CIF
     */
    protected $cif;

    /**
     * @var string
     *
     * Tracker
     */
    protected $tracker;

    /**
     * @var string
     *
     * Template
     */
    protected $template;

    /**
     * @var bool
     *
     * Use stock
     */
    protected $useStock;

    /**
     * @var AddressInterface
     *
     * Address
     */
    protected $address;

    /**
     * @var LanguageInterface
     *
     * Default language
     */
    protected $defaultLanguage;

    /**
     * @var CurrencyInterface
     *
     * Default currency
     */
    protected $defaultCurrency;

    /**
     * @var string
     *
     * Rouring strategy
     */
    protected $routingStrategy;

    /**
     * @var ImageInterface
     *
     * Logo
     */
    protected $logo;

    /**
     * @var ImageInterface
     *
     * Secondary logo
     */
    protected $secondaryLogo;

    /**
     * @var ImageInterface
     *
     * Logo for mobile
     */
    protected $mobileLogo;

    /**
     * @var ImageInterface
     *
     * Header image
     */
    protected $headerImage;

    /**
     * @var ImageInterface
     *
     * Background image
     */
    protected $backgroundImage;

    /**
     * Get Name.
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Leitmotiv.
     *
     * @return string Leitmotiv
     */
    public function getLeitmotiv()
    {
        return $this->leitmotiv;
    }

    /**
     * Sets Leitmotiv.
     *
     * @param string $leitmotiv Leitmotiv
     *
     * @return $this Self object
     */
    public function setLeitmotiv($leitmotiv)
    {
        $this->leitmotiv = $leitmotiv;

        return $this;
    }

    /**
     * Get Email.
     *
     * @return string Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets Email.
     *
     * @param string $email Email
     *
     * @return $this Self object
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get IsCompany.
     *
     * @return bool IsCompany
     */
    public function getIsCompany()
    {
        return $this->isCompany;
    }

    /**
     * Sets IsCompany.
     *
     * @param bool $isCompany IsCompany
     *
     * @return $this Self object
     */
    public function setIsCompany($isCompany)
    {
        $this->isCompany = $isCompany;

        return $this;
    }

    /**
     * Get Cif.
     *
     * @return string Cif
     */
    public function getCif()
    {
        return $this->cif;
    }

    /**
     * Sets Cif.
     *
     * @param string $cif Cif
     *
     * @return $this Self object
     */
    public function setCif($cif)
    {
        $this->cif = $cif;

        return $this;
    }

    /**
     * Get Tracker.
     *
     * @return string Tracker
     */
    public function getTracker()
    {
        return $this->tracker;
    }

    /**
     * Sets Tracker.
     *
     * @param string $tracker Tracker
     *
     * @return $this Self object
     */
    public function setTracker($tracker)
    {
        $this->tracker = $tracker;

        return $this;
    }

    /**
     * Get Template.
     *
     * @return string Template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Sets Template.
     *
     * @param string $template Template
     *
     * @return $this Self object
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get UseStock.
     *
     * @return bool UseStock
     */
    public function getUseStock()
    {
        return $this->useStock;
    }

    /**
     * Sets UseStock.
     *
     * @param bool $useStock UseStock
     *
     * @return $this Self object
     */
    public function setUseStock($useStock)
    {
        $this->useStock = $useStock;

        return $this;
    }

    /**
     * Get Address.
     *
     * @return AddressInterface Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets Address.
     *
     * @param AddressInterface $address Address
     *
     * @return $this Self object
     */
    public function setAddress(AddressInterface $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get DefaultLanguage.
     *
     * @return LanguageInterface DefaultLanguage
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    /**
     * Sets DefaultLanguage.
     *
     * @param LanguageInterface $defaultLanguage DefaultLanguage
     *
     * @return $this Self object
     */
    public function setDefaultLanguage(LanguageInterface $defaultLanguage)
    {
        $this->defaultLanguage = $defaultLanguage;

        return $this;
    }

    /**
     * Get DefaultCurrency.
     *
     * @return CurrencyInterface DefaultCurrency
     */
    public function getDefaultCurrency()
    {
        return $this->defaultCurrency;
    }

    /**
     * Sets DefaultCurrency.
     *
     * @param CurrencyInterface $defaultCurrency DefaultCurrency
     *
     * @return $this Self object
     */
    public function setDefaultCurrency(CurrencyInterface $defaultCurrency)
    {
        $this->defaultCurrency = $defaultCurrency;

        return $this;
    }

    /**
     * Get RoutingStrategy.
     *
     * @return string RoutingStrategy
     */
    public function getRoutingStrategy()
    {
        return $this->routingStrategy;
    }

    /**
     * Sets RoutingStrategy.
     *
     * @param string $routingStrategy RoutingStrategy
     *
     * @return $this Self object
     */
    public function setRoutingStrategy($routingStrategy)
    {
        $this->routingStrategy = $routingStrategy;

        return $this;
    }

    /**
     * Get Logo.
     *
     * @return ImageInterface Logo
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Sets Logo.
     *
     * @param ImageInterface $logo Logo
     *
     * @return $this Self object
     */
    public function setLogo(ImageInterface $logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get SecondaryLogo.
     *
     * @return ImageInterface SecondaryLogo
     */
    public function getSecondaryLogo()
    {
        return $this->secondaryLogo;
    }

    /**
     * Sets SecondaryLogo.
     *
     * @param ImageInterface $secondaryLogo SecondaryLogo
     *
     * @return $this Self object
     */
    public function setSecondaryLogo(ImageInterface $secondaryLogo)
    {
        $this->secondaryLogo = $secondaryLogo;

        return $this;
    }

    /**
     * Get MobileLogo.
     *
     * @return ImageInterface MobileLogo
     */
    public function getMobileLogo()
    {
        return $this->mobileLogo;
    }

    /**
     * Sets MobileLogo.
     *
     * @param ImageInterface $mobileLogo MobileLogo
     *
     * @return $this Self object
     */
    public function setMobileLogo(ImageInterface $mobileLogo)
    {
        $this->mobileLogo = $mobileLogo;

        return $this;
    }

    /**
     * Get HeaderImage.
     *
     * @return ImageInterface HeaderImage
     */
    public function getHeaderImage()
    {
        return $this->headerImage;
    }

    /**
     * Sets HeaderImage.
     *
     * @param ImageInterface $headerImage HeaderImage
     *
     * @return $this Self object
     */
    public function setHeaderImage(ImageInterface $headerImage)
    {
        $this->headerImage = $headerImage;

        return $this;
    }

    /**
     * Get BackgroundImage.
     *
     * @return ImageInterface BackgroundImage
     */
    public function getBackgroundImage()
    {
        return $this->backgroundImage;
    }

    /**
     * Sets BackgroundImage.
     *
     * @param ImageInterface $backgroundImage BackgroundImage
     *
     * @return $this Self object
     */
    public function setBackgroundImage(ImageInterface $backgroundImage)
    {
        $this->backgroundImage = $backgroundImage;

        return $this;
    }
}
