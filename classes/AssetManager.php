<?php
class AssetManager
{
    private $css = [];
    private $js = [];
    private $inline_css = '';
    private $inline_js = '';

    public function addCSS($file, $priority = 10, $attributes = [])
    {
        $this->css[$priority][] = [
            'file' => $file,
            'attributes' => $attributes
        ];
    }

    public function addJS($file, $priority = 10, $attributes = [])
    {
        $this->js[$priority][] = [
            'file' => $file,
            'attributes' => $attributes
        ];
    }

    public function addInlineCSS($css)
    {
        $this->inline_css .= $css;
    }

    public function addInlineJS($js)
    {
        $this->inline_js .= $js;
    }

    private function versionedFile($file)
    {
        // Skip versioning for external URLs
        if (preg_match('/^https?:\/\//', $file)) {
            return $file;
        }

        $localFile = ASSETS_PATH . '/' . ltrim($file, '/'); // local filesystem
        $urlFile   = ASSETS_URL  . '/' . ltrim($file, '/'); // public URL

        $version = file_exists($localFile) ? filemtime($localFile) : time();

        return $urlFile . '?v=' . $version;
    }

    private function buildAttributes($attributes)
    {
        $html = '';
        foreach ($attributes as $key => $value) {
            if (is_bool($value)) {
                if ($value) {
                    $html .= " $key"; // e.g. defer, async
                }
            } else {
                $html .= " $key=\"$value\""; // e.g. rel="preconnect"
            }
        }
        return $html;
    }

    public function renderCSS()
    {
        ksort($this->css);
        foreach ($this->css as $files) {
            foreach ($files as $entry) {
                $file = $this->versionedFile($entry['file']);
                $attributes = $this->buildAttributes($entry['attributes']);
                echo '<link rel="stylesheet" href="' . $file . '"' . $attributes . '>' . "\n";
            }
        }
        if ($this->inline_css) {
            echo '<style>' . $this->inline_css . '</style>' . "\n";
        }
    }

    public function renderJS()
    {
        ksort($this->js);
        foreach ($this->js as $files) {
            foreach ($files as $entry) {
                $file = $this->versionedFile($entry['file']);
                $attributes = $this->buildAttributes($entry['attributes']);
                echo '<script src="' . $file . '"' . $attributes . '></script>' . "\n";
            }
        }
        if ($this->inline_js) {
            echo '<script>' . $this->inline_js . '</script>' . "\n";
        }
    }
}
