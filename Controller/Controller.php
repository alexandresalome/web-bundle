<?php

namespace Alex\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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

        return $this;
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

        return $this;
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

        return $this;
    }

    protected function renderJson($data)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode($data));

        return $response;
    }

    /**
     * Throws an exception (404 Not found) if condition is true.
     *
     * @param mixed $condition condition to test
     * @param string $message error message
     *
     * @return Controller
     */
    protected function throwNotFoundIf($condition, $message = 'Not found')
    {
        if ($condition) {
            throw $this->createNotFoundException($message);
        }

        return $this;
    }

    /**
     * Throws an exception (404 Not found) unless condition is true.
     *
     * @param mixed $condition condition to test
     * @param string $message error message
     *
     * @return Controller
     */
    protected function throwNotFoundUnless($condition, $message = 'Not found')
    {
        $this->throwNotFoundIf(!$condition, $message);

        return $this;
    }

    /**
     * Throws an exception (403 Access denied) if condition is true.
     *
     * @param mixed $condition condition to test
     * @param string $message error message
     *
     * @return Controller
     */
    protected function throwAccessDeniedIf($condition, $message = 'Not found')
    {
        if ($condition) {
            throw $this->createAccessDeniedException($message);
        }

        return $this;
    }

    /**
     * Throws an exception (403 Access denied) unless condition is true.
     *
     * @param mixed $condition condition to test
     * @param string $message error message
     *
     * @return Controller
     */
    protected function throwAccessDeniedUnless($condition, $message = 'Not found')
    {
        $this->throwNotFoundIf(!$condition, $message);

        return $this;
    }

    /**
     * @return AccessDeniedHttpException
     */
    protected function createAccessDeniedException($message = 'Access denied', \Exception $previous = null)
    {
        return new AccessDeniedHttpException($message, $previous);
    }
}
