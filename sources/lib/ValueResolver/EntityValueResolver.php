<?php

namespace PommProject\PommBundle\ValueResolver;

use PommProject\Foundation\Pomm;
use PommProject\ModelManager\Model\FlexibleEntity\FlexibleEntityInterface;
use PommProject\ModelManager\Model\Model;
use PommProject\PommBundle\ValueResolver\Attribute\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class EntityValueResolver implements ValueResolverInterface
{
    public function __construct(private readonly Pomm $pomm)
    {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();
        if (
            !$argumentType ||
            !is_a($argumentType, FlexibleEntityInterface::class, true)
        ) {
            return [];
        }

        $options = $this->getOptions($argument);

        $model = $options['session']->getModel($options['model']);

        $pk = $this->getPk($model, $request);

        if (empty($pk)) {
            yield null;
        }

        yield $model->findByPk($pk);
    }

    private function getOptions(ArgumentMetadata $argument): array
    {
        $entityAttribute = self::getEntityAttribute($argument);
        return [
            'model' => $entityAttribute?->getModelClass() ?? $argument->getType() . 'Model',
            'session' =>
                $entityAttribute?->getSessionName() ?
                    $this->pomm[$entityAttribute->getSessionName()] :
                    $this->pomm->getDefaultSession(),
        ];
    }

    private function getPk(Model $model, Request $request): array
    {
        $values = [];
        $primaryKeys = $model->getStructure()
            ->getPrimaryKey();

        foreach ($primaryKeys as $key) {
            if ($request->attributes->has($key)) {
                $values[$key] = $request->attributes->get($key);
            }
        }
        return $values;
    }

    private static function getEntityAttribute(ArgumentMetadata $argument): ?Entity
    {
        return current($argument->getAttributesOfType(Entity::class)) ?: null;
    }
}
