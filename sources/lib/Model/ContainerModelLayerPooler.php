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

use PommProject\Foundation\Client\ClientPooler;
use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\ModelLayer\ModelLayer;
use PommProject\ModelManager\ModelLayer\ModelLayerPooler;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * ModelLayerPooler
 *
 * Pooler for ModelLayer session client.
 *
 * @package   ModelManager
 * @copyright 2014 - 2016 Grégoire HUBERT
 * @author    Miha Vrhovnik
 * @license   X11 {@link http://opensource.org/licenses/mit-license.php}
 * @see       ClientPooler
 */
class ContainerModelLayerPooler extends ModelLayerPooler implements ContainerAwareInterface, ServiceMapInterface
{
    use ContainerAwareTrait;

    private array $serviceMap = [];

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
    protected function createClient(object|string $identifier): ModelLayer
    {
        if (array_key_exists($identifier, $this->serviceMap)) {
            return $this->container->get($this->serviceMap[$identifier]);
        }

        return parent::createClient($identifier);
    }
}
