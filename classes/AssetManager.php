<?php
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

    private function versionedFile($file)
    {
        // If it's already a full URL (CDN), don't touch it
        if (preg_match('/^https?:\/\//', $file)) {
            return $file;
        }

        $localFile = ASSETS_PATH . '/' . ltrim($file, '/'); // local filesystem
        $urlFile   = ASSETS_URL  . '/' . ltrim($file, '/'); // public URL

        if (file_exists($localFile)) {
            $version = filemtime($localFile);
        } else {
            $version = time(); // fallback
        }

        return $urlFile . '?v=' . $version;
    }

    public function renderCSS()
    {
        ksort($this->css);
        foreach ($this->css as $files) {
            foreach ($files as $file) {
                echo '<link rel="stylesheet" href="' . $this->versionedFile($file) . '">' . "\n";
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
            foreach ($files as $file) {
                echo '<script src="' . $this->versionedFile($file) . '"></script>' . "\n";
            }
        }
        if ($this->inline_js) {
            echo '<script>' . $this->inline_js . '</script>' . "\n";
        }
    }
}


// class AssetManager
// {
//     private $css = [];
//     private $js = [];
//     private $inline_css = '';
//     private $inline_js = '';

//     public function addCSS($file, $priority = 10)
//     {
//         $this->css[$priority][] = $file;
//     }

//     public function addJS($file, $priority = 10)
//     {
//         $this->js[$priority][] = $file;
//     }

//     public function addInlineCSS($css)
//     {
//         $this->inline_css .= $css;
//     }

//     public function addInlineJS($js)
//     {
//         $this->inline_js .= $js;
//     }

//     public function renderCSS()
//     {
//         ksort($this->css);
//         foreach ($this->css as $priority => $files) {
//             foreach ($files as $file) {
//                 echo '<link rel="stylesheet" href="' . $file . '?v=' . filemtime($file) . '">' . "\n";
//             }
//         }
//         if ($this->inline_css) {
//             echo '<style>' . $this->inline_css . '</style>' . "\n";
//         }
//     }

//     public function renderJS()
//     {
//         ksort($this->js);
//         foreach ($this->js as $priority => $files) {
//             foreach ($files as $file) {
//                 echo '<script src="' . $file . '?v=' . filemtime($file) . '"></script>' . "\n";
//             }
//         }
//         if ($this->inline_js) {
//             echo '<script>' . $this->inline_js . '</script>' . "\n";
//         }
//     }
// }
