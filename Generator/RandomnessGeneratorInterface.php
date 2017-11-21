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

namespace Sylius\Component\Resource\Generator;

interface RandomnessGeneratorInterface
{
    /**
     * @param int $length
     *
     * @return string
     */
    public function generateUriSafeString(int $length);

    /**
     * @param int $length
     *
     * @return string
     */
    public function generateNumeric(int $length);

    /**
     * @param int $min
     * @param int $max
     *
     * @return int
     */
    public function generateInt(int $min, int $max);
}
