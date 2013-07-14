<?php

namespace Alex\WebBundle\Form\TypeExtension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

/**
 * Form type extension to pass additional informations to the view (for Javascript)
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
class DateTypeExtension extends AbstractTypeExtension
{
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        parent::finishView($view, $form, $options);

        $format = $options['format'];
        if (is_int($format)) {
            $formatter = new \IntlDateFormatter(\Locale::getDefault(), $format, \IntlDateFormatter::NONE);
            $format = $formatter->getPattern();
        }


        $view->vars['locale'] = \Locale::getDefault();
        $view->vars['format_php'] = $format;

        if ($this->convertPhpFormatToJQueryUI('yyyy') == 'y') {
            die('nan');
        }

        $format = $this->convertPhpFormatToJQueryUI($format);
        $view->vars['format_js'] = $format;
    }

    public function getExtendedType()
    {
        return 'date';
    }

    private function convertPhpFormatToJQueryUI($value)
    {
        if ($value === '') {
            return '';
        }

        $replacements = array(
            'EEEE' => 'DD',
            'MMMM' => 'MM',
            'yyyy' => 'yy',
            'MMM'  => 'M',
            'dd'   => 'dd',
            'MM'   => 'mm',
            'yy'   => 'y',
            'y'    => 'yy'
        );

        return strtr($value, $replacements);
    }
}
