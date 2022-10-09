<?php

namespace PixelDev\CloudflareTurnstileBundle\Type;

use PixelDev\CloudflareTurnstileBundle\Constraints\CloudflareTurnstile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TurnstileType extends AbstractType
{
    /**
     * @var string
     */
    private $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'mapped' => false,
            'constraints' => new CloudflareTurnstile(),
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['key'] = $this->key;
    }

    public function getBlockPrefix()
    {
        return 'turnstile';
    }

    public function getParent()
    {
        return TextType::class;
    }
}
