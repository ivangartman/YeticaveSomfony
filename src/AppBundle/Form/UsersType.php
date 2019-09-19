<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'attr' => ['placeholder' => 'Введите E-mail']])
            ->add('name', TextType::class, [
                'label' => 'Имя',
                'attr' => ['placeholder' => 'Введите имя']])
            ->add('password', PasswordType::class, [
                'label' => 'Пароль',
                'attr' => ['placeholder' => 'Введите пароль', 'validate' => 'EmailType']])
            ->add('contact', TextType::class, [
                'label' => 'Контакты',
                'attr' => ['placeholder' => 'Напишите как с вами связаться']])
            ->add('save', SubmitType::class, [
                'label' => 'Зарегистрироваться',
                'attr' => ['class' => 'button']]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Users'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_users';
    }


}
