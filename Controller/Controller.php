<?php

namespace Alex\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

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
    public function getRepository($name)
    {
        return $this->getDoctrine()->getRepository($name);
    }

    /**
     * Adds a success message to the session flashbag.
     *
     * @param string $message
     *
     * @return Controller
     */
    public function addSuccess($message)
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
    public function addWarning($message)
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
    public function addError($message)
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
    public function addNotice($message)
    {
        $this->get('session')->getFlashBag()->add('message_notice', $message);
    }
}