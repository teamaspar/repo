<?php

namespace MotogpBundle\Form;

use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegisterType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $customer = $options['data'];

        $preferred_choices = $customer->getLocale() == 'es' ? ['ES', 'GB'] : ['GB', 'ES'];

        $localeOptions = $customer->getLocale() == 'es'
            ? ['es' => 'Español', 'en' => 'Inglés']
            : ['en' => 'English', 'es' => 'Español']
        ;

        $builder
            ->add('name' ,'text', array('required' => true))
            ->add('surname' ,'text', array('required' => true))
            ->add('mediaType' ,'text', array('required' => false))
            ->add('accept', 'checkbox', ['mapped' => false])
            ->add('iagree', 'checkbox', ['mapped' => false, 'required' => true])
            ->add('email' ,'email', array('required' => true))
            ->add('locale' , ChoiceType::class, ['choices' => array_flip($localeOptions), 'required' => false])
            ->add('country', CountryType::class, ['required' => false,  'preferred_choices' => $preferred_choices ])
            ->add('type', ChoiceType::class, array(
                'choices'  => array(
                    'public' => 'public',
                    'sponsor' => 'sponsor',
                    'media' => 'media',
                    'gpguest' => 'gpguest'
                ),
            ))
            ->add('mediaType', ChoiceType::class, array(
                    'choices'  => array(
                        'media_pr'    =>  'media_pr',
                        'media_radio' => 'media_radio',
                        'media_tv'    => 'media_tv',
                        'media_web'   => 'media_web',
                        'media_other' => 'media_other'
                    ),
                ))
            ->add('recaptcha', EWZRecaptchaType::class,
                [
                    'label'       => 'Captcha check:',
                    'mapped'      => false,
                    'constraints' => [
                        new RecaptchaTrue()
                    ],
                    'attr'        => [
                        'options' => [
                            'type'  => 'image',
                            'theme' => 'light',
                            'defer' => false,
                            'async' => false,
                            'size'  => 2,
                            'callback' => 'onReCaptchaSuccess'
                        ]
                    ]
                ])

        ;

        if ($customer->getType() == 'sponsor') {
            $builder
                ->add('sponsor', null, ['required' => true, 'preferred_choices' => [33]])
                ->add('sponsorText', null, ['required' => false])
            ;
        }

        if ($customer->getType() != 'public') {
            $builder
                ->add('phone', 'text', array('required' => true))
            ;
        }


        if ($customer->getType() == 'gpguest') {
            $builder
                ->add('circuit', null, array('required' => false))
                ->add('username', 'text', ['required' => true, 'mapped' => false])
                ->add('sponsor', null, ['required' => false])
                ->add('sponsorText', null, ['required' => false])
                ->add('gpguest_agree', 'checkbox', ['mapped' => false, 'required' => true])
                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    'first_options'  => ['label' => 'Password'],
                    'second_options' => ['label' => 'Repeat Password'],
                    'mapped' => false
                ]);
            ;
        }

        if ($customer->getType() == 'media') {

            $builder
                ->add('address', null, ['required' => true])
                ->add('postalCode', null, ['required' => true])
                ->add('webUrl', null, ['required' => true])
                ->add('businessName', null, ['required' => true])
            ;
        }

    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MotogpBundle\Entity\Customer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'motogpbundle_register';
    }


}
