<?php

namespace BackEndBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array('attr' => array('class' => 'title-input', 
                                                                       'placeholder' => 'Post title ...')))
                ->add('body', TextareaType::class, array('attr' => array('class' => 'body-input',
                                                                          'placeholder' => 'Type your post body here ...')))
                ->add('tags', TextareaType::class, array('attr' => array('class' => 'tags-input')))
                ->add('category', EntityType::class, array('class' => 'AppBundle:Category', 
                                                   'attr' => array('class' => 'category-input')));

        //build form for add and edit
        if ($options['update']) {
            //if update -> image NOT required & show post status
            $builder->add('image', FileType::class,  array('attr' => array('class' => 'file-input'),
                                                           'required' => false));
                    //->add('isPublished', CheckboxType::class, array('required' => false))
                    //->add('isApproved', CheckboxType::class, array('required' => false));
        }
        else {
            //if new post -> image required 
            $builder->add('image', FileType::class,  array('attr' => array('class' => 'file-input')));
        }

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            // if ($options['update']) {
            //     $post = $event->getData();
            //     dump($post);die();
            // }
        });
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post',
            'update' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'backendbundle_post';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'bo_post';
    }
}