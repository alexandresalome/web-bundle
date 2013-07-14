<?php

namespace Alex\WebBundle\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Base fixture class for ORM.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
abstract class ORMFixture extends ContainerAware implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Returns a container service.
     *
     * @return mixed
     */
    public function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
