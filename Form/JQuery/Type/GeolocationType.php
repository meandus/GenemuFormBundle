<?php

/*
 * This file is part of the GenemuFormBundle package.
 *
 * (c) Olivier Chauvel <olivier@generation-multiple.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\FormBundle\Form\JQuery\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

use Genemu\Bundle\FormBundle\Form\Core\EventListener\GeolocationListener;

/**
 * GeolocationType to JQueryLib
 *
 * @author Olivier Chauvel <olivier@generation-multiple.com>
 */
class GeolocationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('address', 'text');

        foreach (array('latitude', 'longitude', 'locality', 'country','street_number','route','admin_area_level_2','admin_area_level_1','postal_code') as $field) {
            $option = $options[$field];

            if (isset($option['enabled']) && !empty($option['enabled'])) {
                $type = 'text';
                if (isset($option['hidden']) && !empty($option['hidden'])) {
                    $type = 'hidden';
                }

                $builder->add($field, $type);
            }
        }

        $builder
            ->addEventSubscriber(new GeolocationListener());
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'configs'   => array(),
            'elements'  => array(),
            'map' => $options['map']
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'map' => false,
            'latitude' => array(
                'enabled' => false,
                'hidden' => false,
            ),
            'longitude' => array(
                'enabled' => false,
                'hidden' => false,
            ),
            'locality' => array(
                'enabled' => false,
                'hidden' => false,
            ),
            'country' => array(
                'enabled' => false,
                'hidden' => false,
            ),
            'street_number' => array(
                'enabled' => false,
                'hidden' => false,
            ),
            'route' => array(
                'enabled' => false,
                'hidden' => false,
            ),            
            'postal_code' => array(
                'enabled' => false,
                'hidden' => false,
            ),
            'admin_area_level_1' => array(
                'enabled' => false,
                'hidden' => false,
            ),
            'admin_area_level_2' => array(
                'enabled' => false,
                'hidden' => false,
            ),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'genemu_jquerygeolocation';
    }
}
