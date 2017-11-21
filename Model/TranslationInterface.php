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

interface TranslationInterface
{
    /**
     * @return TranslatableInterface
     */
    public function getTranslatable();

    /**
     * @param TranslatableInterface|null $translatable
     */
    public function setTranslatable(?TranslatableInterface $translatable);

    /**
     * @return string|null
     */
    public function getLocale();

    /**
     * @param string|null $locale
     */
    public function setLocale(?string $locale);
}
