<?php

use App\View\WebPageGeneric;
use App\View\ViewEnv;

require_once 'vendor/autoload.php';
require_once __DIR__ . '/../vendor/autoload.php';

class ViewEnvTest extends PHPUnit\Framework\TestCase
{

    private ViewEnv $view;

    protected function setUp(): void
    {
        $this->view = new ViewEnv();
    }

    public function testViewEnv()
    {
        $this->view->setBaseUrl('http://example.com');
        $this->view->setCssGlobalUrl('http://example.com/libs');
        $this->view->setCssThemeUrl('http://example.com/themes/main/css');
        $this->view->setJsGlobalUrl('http://example.com/libs');
        $this->view->setJsThemeUrl('http://example.com/themes/main/js');
        $this->view->setTemplatePath(__DIR__);
        $this->view->setTemplateSystemPath(__DIR__);

        $this->assertEquals('http://example.com', $this->view->getBaseUrl());
        $this->assertEquals('http://example.com/libs', $this->view->getCssGlobalUrl());
        $this->assertEquals('http://example.com/themes/main/css', $this->view->getCssThemeUrl());
        $this->assertEquals('http://example.com/libs', $this->view->getJsGlobalUrl());
        $this->assertEquals('http://example.com/themes/main/js', $this->view->getJsThemeUrl());
        $this->assertEquals(__DIR__, $this->view->getTemplatePath());
        $this->assertEquals(__DIR__, $this->view->getTemplateSystemPath());
    }

    public function testWebPage()
    {
        $webpage = new WebPageGeneric($this->view);
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
        $this->assertEquals(643, $result);
    }

}
