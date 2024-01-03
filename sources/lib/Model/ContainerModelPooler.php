<?php

/*
 * This file is part of the PommProject/PommBundle package.
 *
 * (c) 2014 - 2016 Grégoire HUBERT <hubert.greg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PommProject\PommBundle\Model;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\ModelPooler;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * PommExtension
 *
 * DIC extension
 *
 * @package   PommBundle
 * @copyright 2016 Grégoire HUBERT
 * @author    Miha Vrhovnik
 * @license   X11 {@link http://opensource.org/licenses/mit-license.php}
 * @see       Extension
 */
class ContainerModelPooler extends ModelPooler implements ServiceMapInterface
{
    protected ContainerInterface $container;

    private array $serviceMap = [];

    #[Required]
    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function addModelToServiceMapping(string $class, string $serviceId): void
    {
        $this->serviceMap[$class] = $serviceId;
    }

    /**
     * {@inheritdoc}
     */
    protected function createClient(string $identifier): Model
    {
        if (array_key_exists($identifier, $this->serviceMap)) {
            return $this->container->get($this->serviceMap[$identifier]);
        }

        return parent::createClient($identifier);
    }
}
