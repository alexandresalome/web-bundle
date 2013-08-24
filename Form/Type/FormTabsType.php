<?php

namespace Alex\WebBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class FormTabsType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $tabs = array();
        foreach ($form as $child) {
            $tabs[$child->getName()] = $child->getConfig()->getType()->getName() == 'form_tab';
        }

        $view->vars['tabs'] = $tabs;
    }

    public function getName()
    {
        return 'form_tabs';
    }
}
