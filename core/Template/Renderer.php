<?php

declare(strict_types=1);

namespace Framework\Template;

class Renderer implements RendererInterface
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function render($_view, array $params = []):string
    {
        $_template = $this->templatePath($_view);

        ob_start();
        extract($params, EXTR_OVERWRITE);
        require $_template;
        return ob_get_clean();
    }

    private function templatePath($_view): string
    {
        if (strpos($_view, '.') !== false) {
            $_view = str_replace('.', '/', $_view);
        }
        return $this->path . '/' . $_view . '.php';
    }
}
