<?php

declare(strict_types=1);

namespace Framework\Template;

class Renderer implements RendererInterface
{
    /**
     * @var string
     */
    private string $path;

    /**
     * @var string|null
     */
    private ?string $extend;

    public function __construct(string $path)
    {
        $this->path = $path;
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

        return $this->render($this->extend, [
            'content' => $content
        ]);
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
}
