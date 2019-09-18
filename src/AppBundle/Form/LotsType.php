<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use AppBundle\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LotsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Наименование',
                'attr' => ['placeholder' => 'Введите наименование лота',
                'maxlength' => 30]])
            ->add('content', TextareaType::class, [
                'label' => 'Описание',
                'attr' => ['placeholder' => 'Напишите описание лота',
                'maxlength' => 500]])
            ->add('pictureUrl', FileType::class, [
                'label' => 'Изображение',
                'attr' => ['placeholder' => 'Загрузите изображение', 'class' => 'visually-hidden']])
            ->add('price', IntegerType::class, [
                'label' => 'Начальная цена',
                'attr' => ['placeholder' => '0',
                'maxlength' => 11]])
            ->add('dateEnd', DateType::class, [
                'label' => 'Дата окончания торгов',
                'widget' => 'single_text',])
//                'attr' => ['class' => 'form__input-date']])
//            ->add('dateEnd', TextType::class, [
//                'label' => 'Дата окончания торгов',
//                'attr' => ['placeholder' => 'Введите дату в формате ГГГГ-ММ-ДД', 'class' => 'form__input-date']])
            ->add('stepRate', IntegerType::class, [
                'label' => 'Шаг ставки',
                'attr' => ['placeholder' => '0',
                'maxlength' => 11]])
            ->add('user', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'name',
            ])
            ->add('category', EntityType::class, array(
                    'class' => Category::class,
                    'choice_label' => 'name',
                )
            )
            ->add('save', SubmitType::class, [
                'label' => 'Добавить лот',
                'attr' => ['class' => 'button']])
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Lots'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_lots';
    }


}
