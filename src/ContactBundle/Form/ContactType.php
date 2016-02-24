<?php

namespace ContactBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		dump($builder);
        $builder
            ->add('email', EmailType::class, ['required' => false])
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class, ['required' => false])
            ->add('adresse', TextType::class, ['required' => false])
            ->add('telephone', TextType::class, ['required' => false])
            ->add('site', UrlType::class, ['required' => false])
            ->add('envoyer', SubmitType::class)
        ;
		
    }
    
	
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ContactBundle\Entity\Contact'
        ));
    }
}
