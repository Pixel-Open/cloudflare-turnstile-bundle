<?php

declare(strict_types=1);

namespace PixelOpen\CloudflareTurnstileBundle\Tests\Type;

use PixelOpen\CloudflareTurnstileBundle\Type\TurnstileType;
use PixelOpen\CloudflareTurnstileBundle\Validator\CloudflareTurnstile;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Test\TypeTestCase;

final class TurnstileTypeTest extends TypeTestCase
{
    private const DUMMY_KEY = 'dummy-key';

    public function testBlockPrefix(): void
    {
        $type = new TurnstileType(self::DUMMY_KEY, true);

        self::assertSame('turnstile', $type->getBlockPrefix());
    }

    public function testParent(): void
    {
        $type = new TurnstileType(self::DUMMY_KEY, true);

        self::assertSame(TextType::class, $type->getParent());
    }

    public function testViewVarsWhenEnabled(): void
    {
        $form = $this->factory->create(TurnstileType::class);
        $view = $form->createView();

        self::assertSame(self::DUMMY_KEY, $view->vars['key']);
        self::assertTrue($view->vars['enable']);
    }

    public function testViewVarsWhenDisabled(): void
    {
        $factory = Forms::createFormFactoryBuilder()
            ->addType(new TurnstileType(self::DUMMY_KEY, false))
            ->getFormFactory();

        $view = $factory->create(TurnstileType::class)->createView();

        self::assertSame(self::DUMMY_KEY, $view->vars['key']);
        self::assertFalse($view->vars['enable']);
    }

    public function testDefaultOptions(): void
    {
        $form = $this->factory->create(TurnstileType::class);
        $config = $form->getConfig();

        self::assertFalse($config->getMapped());

        $constraints = $config->getOption('constraints');
        self::assertInstanceOf(CloudflareTurnstile::class, $constraints);
    }

    protected function getTypes(): array
    {
        return [
            new TurnstileType(self::DUMMY_KEY, true),
        ];
    }
}