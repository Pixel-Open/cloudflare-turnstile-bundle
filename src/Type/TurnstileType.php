<?php

declare(strict_types=1);
namespace PixelOpen\CloudflareTurnstileBundle\Type;

use PixelOpen\CloudflareTurnstileBundle\Constraints\CloudflareTurnstile;
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

    /**
     * @var bool
     */
    private $enable;

    public function __construct(string $key, bool $enable)
    {
        $this->key = $key;
        $this->enable = $enable;
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
