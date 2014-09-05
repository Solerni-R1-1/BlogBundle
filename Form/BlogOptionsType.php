<?php

namespace Icap\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BlogOptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('authorize_comment', 'checkbox', array(
                'required' => false,
            ))
            ->add('authorize_anonymous_comment', 'checkbox', array(
                'required' => false,
            ))
            ->add('auto_publish_post', 'checkbox', array(
                'required' => false,
            ))
            ->add('auto_publish_comment', 'checkbox', array(
                'required' => false,
            ))
            ->add('display_title', 'checkbox', array(
                'required' => false,
            ))
            ->add('display_post_view_counter', 'checkbox', array(
                'required' => false,
            ))
            ->add('post_per_page', 'choice', array(
                'choices'       => array("5" => 5, "10" => 10, "20" => 20),
                'required'      => false,
                'theme_options' => array('control_width' => 'col-md-2'),
            ))
            ->add('tag_cloud', 'choice', array(
                'choices'       => array("0" => "classic", "1" => "3D"),
                'required'      => false,
                'expanded'      => true,
                'multiple'      => false,
                'empty_value'   => false
            ))
        ;
    }

    public function getName()
    {
        return 'icap_blog_options_form';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
           'translation_domain' => 'icap_blog',
            'data_class'      => 'Icap\BlogBundle\Entity\BlogOptions',
            'csrf_protection' => true,
            'intention'       => 'configure_blog'
        ));
    }
}
