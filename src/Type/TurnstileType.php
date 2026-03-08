<?php

declare(strict_types=1);

namespace PixelOpen\CloudflareTurnstileBundle\Type;

use PixelOpen\CloudflareTurnstileBundle\Validator\CloudflareTurnstile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @extends AbstractType<never>
 */
class TurnstileType extends AbstractType
{
    public function __construct(
        private readonly string $key,
        private readonly bool $enable,
    ) {}

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
        $view->vars['enable'] = $this->enable;
    }

    public function getBlockPrefix(): string
    {
        return 'turnstile';
    }

    public function getParent(): ?string
    {
        return TextType::class;
    }
}
