<?php
// Preview plugin, https://github.com/datenstrom/yellow-plugins/tree/master/preview
// Copyright (c) 2013-2017 Datenstrom, https://datenstrom.se
// This file may be used and distributed under the terms of the public license.

class YellowPreview {
    const VERSION = "0.7.4";
    public $yellow;         //access to API

    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
        $this->yellow->config->setDefault("previewStyle", "stretchable");
        $this->yellow->config->setDefault("previewDefaultFile", "preview-image.png");
    }
    
    // Handle page content of custom block
    public function onParseContentBlock($page, $name, $text, $shortcut) {
        $output = null;
        if ($name=="preview" && $shortcut) {
            list($location, $style, $size) = $this->yellow->toolbox->getTextArgs($text);
            if (empty($location)) $location = $page->location;
            if (empty($style)) $style = $this->yellow->config->get("previewStyle");
            if (empty($size)) $size = "100%";
            $content = $this->yellow->pages->find($location);
            $pages = $content ? $content->getChildren() : $this->yellow->pages->clean();
            if ($this->yellow->plugins->isExisting("image")) {
                if (count($pages)) {
                    $page->setLastModified($pages->getModified());
                    $output = "<div class=\"".htmlspecialchars($style)."\">\n";
                    $output .= "<ul>\n";
                    foreach ($pages as $page) {
                        $image = $page->get("imagePreview");
                        if (empty($image)) $image = $page->get("image");
                        if (!empty($image)) {
                            $fileName = $this->yellow->config->get("imageDir").$image;
                            list($src, $width, $height) = $this->yellow->plugins->get("image")->getImageInformation($fileName, $size, $size);
                        } else {
                            foreach (array("gif", "jpg", "png", "svg") as $fileExtension) {
                                $fileName = $this->yellow->config->get("imageDir").basename($page->location).".".$fileExtension;
                                list($src, $width, $height) = $this->yellow->plugins->get("image")->getImageInformation($fileName, $size, $size);
                                if ($width && $height) break;
                            }
                        }
                        if (!is_readable($fileName)) {
                            $fileName = $this->yellow->config->get("imageDir").$this->yellow->config->get("previewDefaultFile");
                            list($src, $width, $height) = $this->yellow->plugins->get("image")->getImageInformation($fileName, $size, $size);
                        }
                        $title = $page->get("titlePreview");
                        if (empty($title)) $title = $page->get("title");
                        $description = $page->get("descriptionPreview");
                        if (empty($description)) $description = $page->get("description");
                        $output .= "<li><a href=\"".$page->getLocation(true)."\">";
                        $output .= "<span class=\"preview-image\"><img src=\"".htmlspecialchars($src)."\" width=\"".
                            htmlspecialchars($width)."\" height=\"".
                            htmlspecialchars($height)."\" alt=\"".htmlspecialchars($title)."\" title=\"".
                            htmlspecialchars($title)."\" /></span><br />";
                        $output .= "<span class=\"preview-description\">".htmlspecialchars($description)."</span></a></li>\n";
                    }
                    $output .= "</ul>\n";
                    $output .= "</div>\n";
                } else {
                    $page->error(500, "Preview '$location' does not exist!");
                }
            } else {
                $page->error(500, "Preview requires 'image' plugin!");
            }
        }
        return $output;
    }

    // Handle page extra data
    public function onParsePageExtra($page, $name) {
        return $this->onParseContentBlock($page, $name, "", true);
    }
}
