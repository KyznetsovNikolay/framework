<?php

declare(strict_types=1);

namespace Framework\Template;

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

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->sectionNames = new SplStack();
    }

    /**
     * @param $_view
     * @param array $params
     * @return string
     */
    public function render($_view, array $params = []): string
    {
        $_template = $this->templatePath($_view);

        ob_start();
        extract($params, EXTR_OVERWRITE);
        $this->extend = null;
        require $_template;
        $content = ob_get_clean();

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

    public function endSection(): void
    {
        $content = ob_get_clean();
        $name = $this->sectionNames->pop();

        if (array_key_exists($name, $this->sections)) {
            return;
        }
        $this->sections[$name] = $content;
    }

    /**
     * @param string $name
     * @return string
     */
    public function renderSection(string $name): string
    {
        return $this->sections[$name] ?? '';
    }
}
