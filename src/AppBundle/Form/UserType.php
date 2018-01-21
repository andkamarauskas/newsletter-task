<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'Type Your Name')))
        	->add('email', EmailType::class, array('attr' => array('class' => 'form-control', 'placeholder' => 'Type Your Email')))
            ->add('save', SubmitType::class, array(
                'label' => 'Save',
                'attr' => array('class' => 'form-control btn btn-block btn-primary'
            )))
            ->add('categories', ChoiceType::class, array(
                'attr' => array('class' => 'form-control'),
                'choices'  => $options['categories'],
                'multiple' => true,
                'expanded' => true,
            ));
    }

    /**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
	    $resolver->setDefaults(array(
	        'data_class' => User::class,
	        'categories' => null,
	    ));
	}
}