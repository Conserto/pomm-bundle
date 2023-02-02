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

use PommProject\Foundation\Exception\FoundationException;
use PommProject\Foundation\Pomm;
use PommProject\Foundation\Session\Session;

/**
 * Configurator
 *
 * Pooler configurator.
 *
 * @package   PommBundle
 * @copyright 2014 - 2016 Grégoire HUBERT
 * @author    Miha Vrhovnik
 * @license   X11 {@link http://opensource.org/licenses/mit-license.php}
 */
class Configurator
{
    public function __construct(private readonly array $poolers)
    {
    }

    /**
     * @throws FoundationException
     */
    public function configure(Pomm $pomm): void
    {
        foreach ($pomm->getSessionBuilders() as $name => $builder) {
            $pomm->addPostConfiguration($name, function (Session $session) {
                foreach ($this->poolers as $pooler) {
                    $session->registerClientPooler($pooler);
                }
            });
        }
    }
}
