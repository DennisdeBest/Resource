<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Component\Resource\Model;

use Doctrine\Common\Collections\Collection;

interface TranslatableInterface
{
    /**
     * @return Collection|TranslationInterface[]
     */
    public function getTranslations();

    /**
     * @param string|null $locale
     *
     * @return TranslationInterface
     */
    public function getTranslation(?string $locale = null);

    /**
     * @param TranslationInterface $translation
     *
     * @return bool
     */
    public function hasTranslation(TranslationInterface $translation);

    /**
     * @param TranslationInterface $translation
     */
    public function addTranslation(TranslationInterface $translation);

    /**
     * @param TranslationInterface $translation
     */
    public function removeTranslation(TranslationInterface $translation);

    /**
     * @param string $locale
     */
    public function setCurrentLocale(string $locale);

    /**
     * @param string $locale
     */
    public function setFallbackLocale(string $locale);
}
