<?php

namespace Alex\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

/**
 * A reusable controller.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
abstract class Controller extends BaseController
{
    /**
     * @return Doctrine\ORM\EntityRepository
     */
    protected function getRepository($name)
    {
        return $this->getDoctrine()->getRepository($name);
    }

    /**
     * Persists an entity with Doctrine and flushes connection.
     *
     * @param object $entity
     *
     * @return Controller
     */
    protected function persistAndFlush($entity)
    {
        $em = $this->getDoctrine()->getManager();

        $em->persist($entity);
        $em->flush();

        return $this;
    }

    /**
     * Adds a success message to the session flashbag.
     *
     * @param string $message
     *
     * @return Controller
     */
    protected function addSuccess($message)
    {
        $this->get('session')->getFlashBag()->add('message_success', $message);

        return $this;
    }

    /**
     * Adds a warning message to the session flashbag.
     *
     * @param string $message
     *
     * @return Controller
     */
    protected function addWarning($message)
    {
        $this->get('session')->getFlashBag()->add('message_warning', $message);
    }

    /**
     * Adds a error message to the session flashbag.
     *
     * @param string $message
     *
     * @return Controller
     */
    protected function addError($message)
    {
        $this->get('session')->getFlashBag()->add('message_error', $message);
    }

    /**
     * Adds a notice message to the session flashbag.
     *
     * @param string $message
     *
     * @return Controller
     */
    protected function addNotice($message)
    {
        $this->get('session')->getFlashBag()->add('message_notice', $message);
    }

    protected function renderJson($data)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($data));

        return $response;
    }
}
