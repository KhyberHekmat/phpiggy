<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine
{
    public function __construct(private string $basePath)
    {
    }
    public function render(string $template, array $data = [])
    {
        extract($data, EXTR_SKIP);
        //This function is buffering.
        ob_start();

        include $this->resolve($template);

        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function resolve(string $path)
    {
        return "{$this->basePath}/{$path}";
    }
}