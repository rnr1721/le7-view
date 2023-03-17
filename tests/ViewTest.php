<?php

use Core\View\WebPageGeneric;
use Core\View\ViewEnv;

require_once 'vendor/autoload.php';
require_once __DIR__ . '/../vendor/autoload.php';

class ViewTest extends PHPUnit\Framework\TestCase
{

    private ViewEnv $topology;

    protected function setUp(): void
    {
        $this->topology = new ViewEnv();
    }

    public function testViewEnv()
    {

        $this->topology->setBaseUrl('http://example.com');
        $this->topology->setCssUrl('http://example.com/themes/main/css');
        $this->topology->setJsUrl('http://example.com/themes/main/js');
        $this->topology->setImagesUrl('http://example.com/themes/main/images');
        $this->topology->setLibsUrl('http://example.com/libs');
        $this->topology->setThemeUrl('http://example.com/themes/main');
        $this->topology->setFontsUrl('http://example.com/themes/main/fonts');
        $this->topology->setTemplatePath(__DIR__);
        $this->topology->setTemplateSystemPath(__DIR__);

        $this->assertEquals('http://example.com', $this->topology->getBaseUrl());
        $this->assertEquals('http://example.com/libs', $this->topology->getLibsUrl());
        $this->assertEquals('http://example.com/themes/main/css', $this->topology->getCssUrl());
        $this->assertEquals('http://example.com/themes/main/js', $this->topology->getJsUrl());
        $this->assertEquals('http://example.com/themes/main/images', $this->topology->getImagesUrl());
        $this->assertEquals('http://example.com/themes/main/fonts', $this->topology->getFontsUrl());
        $this->assertEquals('http://example.com/themes/main', $this->topology->getThemeUrl());
        $this->assertEquals(__DIR__, $this->topology->getTemplatePath());
        $this->assertEquals(__DIR__, $this->topology->getTemplateSystemPath());
    }

    public function testWebPage()
    {

        $this->topology->setBaseUrl('http://example.com');
        $this->topology->setCssUrl('http://example.com/themes/main/css');
        $this->topology->setJsUrl('http://example.com/themes/main/js');
        $this->topology->setImagesUrl('http://example.com/themes/main/images');
        $this->topology->setLibsUrl('http://example.com/libs');
        $this->topology->setThemeUrl('http://example.com/themes/main');
        $this->topology->setFontsUrl('http://example.com/themes/main/fonts');
        $this->topology->setTemplatePath(__DIR__);
        $this->topology->setTemplateSystemPath(__DIR__);

        $webpage = new WebPageGeneric($this->topology);

        $webpage->setAttribute('testAttribute2', 'testAttrValue');
        $webpage->setPageTitle('page title');
        $webpage->setPageDescription('page description');
        $webpage->setPageHeader('page header');
        $webpage->setPageKeywords(['one', 'two', 'three']);
        $webpage->setPageKeywords('new');
        $webpage->setPageKeywords('new');
        $webpage->setScript('myscript.js', true, 'defer type="text/javascript"', '1');
        $webpage->setScript('myscript.js', false);
        $webpage->setScriptCdn('http://myscript.js', true);
        $webpage->setScriptCdn('http://myscript.js', false);
        $webpage->setStyle('mystyle.css');
        $webpage->setStyleCdn('https://site.com/mystyle.css');
        $webpage->setImportMap(['one' => 'two']);
        $result = strlen(json_encode($webpage->getWebpage()));
        $this->assertEquals(1155, $result);
        
    }

}
