<?php

declare(strict_types=1);

namespace Framework\Template;

use Framework\Http\Router\RouterInterface;
use SplStack;

class Renderer implements RendererInterface
{
    /**
     * @var string
     */
    private string $path;

    /**
     * @var SplStack
     */
    private SplStack $sectionNames;

    /**
     * @var array
     */
    private array $sections = [];

    /**
     * @var string|null
     */
    private ?string $extend;

    /**
     * @var RouterInterface
     */
    private RouterInterface $router;

    public function __construct(string $path, RouterInterface $router)
    {
        $this->path = $path;
        $this->sectionNames = new SplStack();
        $this->router = $router;
    }

    /**
     * @param $_view
     * @param array $params
     * @return string
     */
    public function render($_view, array $params = []): string
    {
        $level = ob_get_level();
        $_template = $this->templatePath($_view);
        $this->extend = null;

        try {
            ob_start();
            extract($params, EXTR_OVERWRITE);
            require $_template;
            $content = ob_get_clean();
        } catch (\Throwable|\Exception $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }
            throw $e;
        }

        if (!$this->extend) {
            return $content;
        }

        return $this->render($this->extend);
    }

    /**
     * @param $_view
     * @return string
     */
    private function templatePath($_view): string
    {
        if (strpos($_view, '.') !== false) {
            $_view = str_replace('.', '/', $_view);
        }
        return $this->path . '/' . $_view . '.php';
    }

    public function extend($view): void
    {
        $this->extend = $view;
    }

    public function startSection(string $name)
    {
        $this->sectionNames->push($name);
        ob_start();
    }

    public function section($name, $content): void
    {
        if ($this->hasSection($name)) {
            return;
        }
        $this->sections[$name] = $content;
    }

    public function endSection(): void
    {
        $content = ob_get_clean();
        $name = $this->sectionNames->pop();

        if ($this->hasSection($name)) {
            return;
        }
        $this->sections[$name] = $content;
    }

    public function ensureBlock($name): bool
    {
        if ($this->hasSection($name)) {
            return false;
        }
        $this->startSection($name);
        return true;
    }

    /**
     * @param string $name
     * @return string
     */
    public function renderSection(string $name): string
    {
        $section = $this->sections[$name] ?? null;

        if ($section instanceof \Closure) {
            return $section();
        }

        return $section ?? '';
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasSection($name): bool
    {
        return array_key_exists($name, $this->sections);
    }

    /**
     * @param $name
     * @param array $params
     * @return string
     */
    public function path($name, array $params = []): string
    {
        return $this->router->generate($name, $params);
    }

    public function encode($string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE);

    }
}
