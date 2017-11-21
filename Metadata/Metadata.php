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

namespace Sylius\Component\Resource\Metadata;

use Doctrine\Common\Inflector\Inflector;

final class Metadata implements MetadataInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $applicationName;

    /**
     * @var string
     */
    private $driver;

    /**
     * @var string
     */
    private $templatesNamespace;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @param string $name
     * @param string $applicationName
     * @param array $parameters
     */
    private function __construct(string $name, string $applicationName, array $parameters)
    {
        $this->name = $name;
        $this->applicationName = $applicationName;

        $this->driver = $parameters['driver'];
        $this->templatesNamespace = array_key_exists('templates', $parameters) ? $parameters['templates'] : null;

        $this->parameters = $parameters;
    }

    /**
     * @param string $alias
     * @param array $parameters
     *
     * @return self
     */
    public static function fromAliasAndConfiguration(string $alias, array $parameters)
    {
        [$applicationName, $name] = self::parseAlias($alias);

        return new self($name, $applicationName, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return $this->applicationName . '.' . $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getApplicationName()
    {
        return $this->applicationName;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getHumanizedName()
    {
        return strtolower(trim(preg_replace(['/([A-Z])/', '/[_\s]+/'], ['_$1', ' '], $this->name)));
    }

    /**
     * {@inheritdoc}
     */
    public function getPluralName()
    {
        return Inflector::pluralize($this->name);
    }

    /**
     * {@inheritdoc}
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplatesNamespace()
    {
        return $this->templatesNamespace;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter(string $name)
    {
        if (!$this->hasParameter($name)) {
            throw new \InvalidArgumentException(sprintf('Parameter "%s" is not configured for resource "%s".', $name, $this->getAlias()));
        }

        return $this->parameters[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasParameter(string $name)
    {
        return array_key_exists($name, $this->parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass(string $name)
    {
        if (!$this->hasClass($name)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" is not configured for resource "%s".', $name, $this->getAlias()));
        }

        return $this->parameters['classes'][$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasClass(string $name)
    {
        return isset($this->parameters['classes'][$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceId(string $serviceName)
    {
        return sprintf('%s.%s.%s', $this->applicationName, $serviceName, $this->name);
    }

    /**
     * {@inheritdoc}
     */
    public function getPermissionCode(string $permissionName)
    {
        return sprintf('%s.%s.%s', $this->applicationName, $this->name, $permissionName);
    }

    /**
     * @param string $alias
     *
     * @return array
     */
    private static function parseAlias(string $alias)
    {
        if (false === strpos($alias, '.')) {
            throw new \InvalidArgumentException(sprintf('Invalid alias "%s" supplied, it should conform to the following format "<applicationName>.<name>".', $alias));
        }

        return explode('.', $alias);
    }
}
