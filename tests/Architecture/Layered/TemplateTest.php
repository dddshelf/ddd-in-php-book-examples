<?php

namespace Architecture\Layered;

use PHPUnit\Framework\TestCase;

class TemplateTest extends TestCase
{
    private static $TEMPLATES_PATH = 'src/Architecture/Layered/templates';

    private $twig;

    public function setUp(): void
    {
        $loader = new \Twig_Loader_Filesystem(self::$TEMPLATES_PATH);
        $this->twig = new \Twig_Environment($loader);
        $this->twig->addFunction(new \Twig_Function('edit_post_url',
            function ($id) {
                return '/edit/' . $id;
            }
        ));
    }

    /**
     * @test
     */
    public function itShouldRenderTemplate(): void
    {
        $p = Post::writeNewFrom('A title', 'Some content');
        $p->setId(1);

        $html = $this->twig->render('index.html.twig', [
            'error' => 'An error',
            'posts' => [$p]
        ]);

        $this->assertNotEmpty($html);
    }
}
