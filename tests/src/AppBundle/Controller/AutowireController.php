<?php
/**
 * This file is part of the pomm-bundle package.
 *
 */
namespace AppBundle\Controller;

use AppBundle\Model\MyDb1\PublicSchema\ConfigModel;
use PommProject\Foundation\Exception\FoundationException;
use PommProject\Foundation\Pomm;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * @author Mikael Paris <stood86@gmail.com>
 */
class AutowireController
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws FoundationException
     * @throws LoaderError
     */
    public function getAutowireAction(string $name, Pomm $pomm, Environment $engine): Response
    {
        $config = $pomm
            ->getDefaultSession()
            ->getModel(ConfigModel::class)
            ->findByPk(['name' => $name]);

        return new Response(
            $engine->render('Front/get.html.twig', compact('config'))
        );
    }
}
