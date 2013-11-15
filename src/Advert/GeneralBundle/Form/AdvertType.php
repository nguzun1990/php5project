<?php
namespace Advert\GeneralBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

/**
 *  AdvertType class - class for generating form for advert entity
 */
class AdvertType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     *
     * @return form;
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title', 'text', array('required' => false))
                ->add('content', 'textarea', array('required' => false))
                ->add('price', 'text', array('required' => false))
                ->add('zipcode', 'text', array('required' => false))
                ->add('type', 'choice', array(
                    'choices' => array('particular' => 'particulier', 'profesional' => 'professionnel'),
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true,
                ))
                ->add('name', 'text', array('required' => false))
                ->add('email', 'text', array('required' => false))
                ->add('phone', 'text', array('required' => false))
                ->add('photo', 'file', array(
                    'data_class' => null,
                    'required' => false,
                ))
                ->add('region', null, array(
                    'empty_value' => '-Sélectionnez région-',
                    'required' => false,
                    'query_builder' => function(EntityRepository $er) {
                         return $er->createQueryBuilder('region')
                             ->orderBy('region.title', 'ASC');
                    },
                ))
                ->add('category', null, array(
                    'empty_value' => '-Sélectionnez catégorie-',
                    'required' => false,
                ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Advert\GeneralBundle\Entity\Advert'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'advert_generalbundle_advert';
    }

}
