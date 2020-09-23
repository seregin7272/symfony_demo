<?php


namespace App\Doctrine;


use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class DiscontinuedFilter extends SQLFilter
{

    /**
     * Gets the SQL query part to add to a query.
     *
     * @param ClassMetaData $targetEntity
     * @param string $targetTableAlias
     *
     * @return string The constraint SQL if there is available, empty string otherwise.
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if ($targetEntity->getReflectionClass()->name != 'App\Entity\FortuneCookie') {
            return '';
        }

        return sprintf('%s.discontinued = %s', $targetTableAlias, $this->getParameter('discontinued'));
    }
}
