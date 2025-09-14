<?php
// classes/AssetManager.php
class AssetManager
{
    private $css = [];
    private $js = [];
    private $inline_css = '';
    private $inline_js = '';

    public function addCSS($file, $priority = 10)
    {
        $this->css[$priority][] = $file;
    }

    public function addJS($file, $priority = 10)
    {
        $this->js[$priority][] = $file;
    }

    public function addInlineCSS($css)
    {
        $this->inline_css .= $css;
    }

    public function addInlineJS($js)
    {
        $this->inline_js .= $js;
    }

    public function renderCSS()
    {
        ksort($this->css);
        foreach ($this->css as $priority => $files) {
            foreach ($files as $file) {
                echo '<link rel="stylesheet" href="' . $file . '?v=' . filemtime($file) . '">' . "\n";
            }
        }
        if ($this->inline_css) {
            echo '<style>' . $this->inline_css . '</style>' . "\n";
        }
    }

    public function renderJS()
    {
        ksort($this->js);
        foreach ($this->js as $priority => $files) {
            foreach ($files as $file) {
                echo '<script src="' . $file . '?v=' . filemtime($file) . '"></script>' . "\n";
            }
        }
        if ($this->inline_js) {
            echo '<script>' . $this->inline_js . '</script>' . "\n";
        }
    }
}
