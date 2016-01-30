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

namespace Elcodi\Component\Store\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;
use Elcodi\Component\Media\Entity\Interfaces\ImageInterface;

/**
 * Interface StoreInterface.
 */
interface StoreInterface
    extends
    IdentifiableInterface,
    DateTimeInterface,
    EnabledInterface
{
    /**
     * Get Name.
     *
     * @return string Name
     */
    public function getName();

    /**
     * Sets Name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get Leitmotiv.
     *
     * @return string Leitmotiv
     */
    public function getLeitmotiv();

    /**
     * Sets Leitmotiv.
     *
     * @param string $leitmotiv Leitmotiv
     *
     * @return $this Self object
     */
    public function setLeitmotiv($leitmotiv);

    /**
     * Get Email.
     *
     * @return string Email
     */
    public function getEmail();

    /**
     * Sets Email.
     *
     * @param string $email Email
     *
     * @return $this Self object
     */
    public function setEmail($email);

    /**
     * Get IsCompany.
     *
     * @return bool IsCompany
     */
    public function getIsCompany();

    /**
     * Sets IsCompany.
     *
     * @param bool $isCompany IsCompany
     *
     * @return $this Self object
     */
    public function setIsCompany($isCompany);

    /**
     * Get Cif.
     *
     * @return string Cif
     */
    public function getCif();

    /**
     * Sets Cif.
     *
     * @param string $cif Cif
     *
     * @return $this Self object
     */
    public function setCif($cif);

    /**
     * Get Tracker.
     *
     * @return string Tracker
     */
    public function getTracker();

    /**
     * Sets Tracker.
     *
     * @param string $tracker Tracker
     *
     * @return $this Self object
     */
    public function setTracker($tracker);

    /**
     * Get Template.
     *
     * @return string Template
     */
    public function getTemplate();

    /**
     * Sets Template.
     *
     * @param string $template Template
     *
     * @return $this Self object
     */
    public function setTemplate($template);

    /**
     * Get UseStock.
     *
     * @return bool UseStock
     */
    public function getUseStock();

    /**
     * Sets UseStock.
     *
     * @param bool $useStock UseStock
     *
     * @return $this Self object
     */
    public function setUseStock($useStock);

    /**
     * Get Address.
     *
     * @return AddressInterface Address
     */
    public function getAddress();

    /**
     * Sets Address.
     *
     * @param AddressInterface $address Address
     *
     * @return $this Self object
     */
    public function setAddress(AddressInterface $address);

    /**
     * Get DefaultLanguage.
     *
     * @return LanguageInterface DefaultLanguage
     */
    public function getDefaultLanguage();

    /**
     * Sets DefaultLanguage.
     *
     * @param LanguageInterface $defaultLanguage DefaultLanguage
     *
     * @return $this Self object
     */
    public function setDefaultLanguage(LanguageInterface $defaultLanguage);

    /**
     * Get DefaultCurrency.
     *
     * @return CurrencyInterface DefaultCurrency
     */
    public function getDefaultCurrency();

    /**
     * Sets DefaultCurrency.
     *
     * @param CurrencyInterface $defaultCurrency DefaultCurrency
     *
     * @return $this Self object
     */
    public function setDefaultCurrency(CurrencyInterface $defaultCurrency);

    /**
     * Get RoutingStrategy.
     *
     * @return string RoutingStrategy
     */
    public function getRoutingStrategy();

    /**
     * Sets RoutingStrategy.
     *
     * @param string $routingStrategy RoutingStrategy
     *
     * @return $this Self object
     */
    public function setRoutingStrategy($routingStrategy);

    /**
     * Get Logo.
     *
     * @return ImageInterface Logo
     */
    public function getLogo();

    /**
     * Sets Logo.
     *
     * @param ImageInterface $logo Logo
     *
     * @return $this Self object
     */
    public function setLogo(ImageInterface $logo);

    /**
     * Get SecondaryLogo.
     *
     * @return ImageInterface SecondaryLogo
     */
    public function getSecondaryLogo();

    /**
     * Sets SecondaryLogo.
     *
     * @param ImageInterface $secondaryLogo SecondaryLogo
     *
     * @return $this Self object
     */
    public function setSecondaryLogo(ImageInterface $secondaryLogo);

    /**
     * Get MobileLogo.
     *
     * @return ImageInterface MobileLogo
     */
    public function getMobileLogo();

    /**
     * Sets MobileLogo.
     *
     * @param ImageInterface $mobileLogo MobileLogo
     *
     * @return $this Self object
     */
    public function setMobileLogo(ImageInterface $mobileLogo);

    /**
     * Get HeaderImage.
     *
     * @return ImageInterface HeaderImage
     */
    public function getHeaderImage();

    /**
     * Sets HeaderImage.
     *
     * @param ImageInterface $headerImage HeaderImage
     *
     * @return $this Self object
     */
    public function setHeaderImage(ImageInterface $headerImage);

    /**
     * Get BackgroundImage.
     *
     * @return ImageInterface BackgroundImage
     */
    public function getBackgroundImage();

    /**
     * Sets BackgroundImage.
     *
     * @param ImageInterface $backgroundImage BackgroundImage
     *
     * @return $this Self object
     */
    public function setBackgroundImage(ImageInterface $backgroundImage);
}
