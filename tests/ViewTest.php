<?php

use Core\View\AssetsCollectionGeneric;
use Core\Interfaces\ViewTopology;
use Core\View\WebPageGeneric;
use Core\View\ViewTopologyGeneric;

require_once 'vendor/autoload.php';
require_once __DIR__ . '/../vendor/autoload.php';

class ViewTest extends PHPUnit\Framework\TestCase
{

    private ViewTopology $topology;

    protected function setUp(): void
    {
        $this->topology = new ViewTopologyGeneric();
    }

    public function testAssetsCollection()
    {
        $ac = $this->getAssetsCollection();
        $data = $ac->getCollection('standard');
        $this->assertTrue(isset($data['scriptsHeader']['myscript']['script']));
        $this->assertTrue(isset($data['scriptsHeader']['myscript']['params']));
        $this->assertTrue(isset($data['scriptsHeader']['bootstrap5']['script']));
        $this->assertTrue(isset($data['scriptsHeader']['bootstrap5']['params']));
        $this->assertTrue(isset($data['scriptsHeader']['jquery']['script']));
        $this->assertTrue(isset($data['scriptsHeader']['jquery']['params']));
        $this->assertTrue(isset($data['scriptsFooter']['axios']['script']));
        $this->assertTrue(isset($data['scriptsFooter']['axios']['params']));
        $this->assertTrue(isset($data['styles']['bootstrap5']));
        $this->assertTrue(isset($data['styles']['mystyle']));
        
        
        $mycollection = $ac->getCollection('mycollection');
        $this->assertEmpty($mycollection['scriptsFooter']);
        $this->assertTrue(isset($mycollection['styles']['bootstrap5']));
        $this->assertTrue(isset($mycollection['scriptsHeader']['vuejs']));
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
        $this->topology->setTemplatePath('newpath');

        $this->assertEquals('http://example.com', $this->topology->getBaseUrl());
        $this->assertEquals('http://example.com/libs', $this->topology->getLibsUrl());
        $this->assertEquals('http://example.com/themes/main/css', $this->topology->getCssUrl());
        $this->assertEquals('http://example.com/themes/main/js', $this->topology->getJsUrl());
        $this->assertEquals('http://example.com/themes/main/images', $this->topology->getImagesUrl());
        $this->assertEquals('http://example.com/themes/main/fonts', $this->topology->getFontsUrl());
        $this->assertEquals('http://example.com/themes/main', $this->topology->getThemeUrl());
        $this->assertEquals(__DIR__, $this->topology->getTemplatePath()[0]);
        $this->assertEquals('newpath', $this->topology->getTemplatePath()[1]);
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

        $webpage = new WebPageGeneric($this->topology, $this->getAssetsCollection());

        $webpage->setAttribute('testAttribute2', 'testAttrValue');
        $webpage->setPageTitle('page title');
        $webpage->setPageDescription('page description');
        $webpage->setPageHeader('page header');
        $webpage->setPageKeywords(['one', 'two', 'three']);
        $webpage->setPageKeywords('new');
        $webpage->setPageKeywords('new');
        $webpage->setCacheControl('nocache');
        $webpage->setExpires('20220224');
        $webpage->setLastModified('20220224');
        $webpage->setScript('myscript.js', true, 'defer type="text/javascript"', '1');
        $webpage->setStyleFromLib('bootstrap5');
        $webpage->setScriptFromLib('bootstrap5', false);
        $webpage->setScriptFromLib('jquery');
        $webpage->setScript('myscript.js', false);
        $webpage->setScriptCdn('http://example.com/myscript.js', true);
        $webpage->setScriptCdn('http://example.com/myscript.js', false);
        $webpage->setStyle('mystyle.css');
        $webpage->setStyleCdn('https://site.com/mystyle.css');
        $webpage->setImportMap(['one' => 'two']);

        $webpage->applyAssetCollection('standard');
        $result = strlen(json_encode($webpage->getWebpage()));

        $this->assertEquals(2128, $result);
    }

    public function getAssetsCollection()
    {

        $styles = [
            'bootstrap5' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css'
        ];

        $scripts = [
            'axios' => 'https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js',
            'jquery' => 'https://code.jquery.com/jquery-3.7.0.min.js',
            'vuejs' => 'https://cdn.jsdelivr.net/npm/vue@2.7.8/dist/vue.js',
            'bootstrap5' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js'
        ];

        $collections = [
            'mycollection' => [
                'scripts_header' => [
                    'vuejs'
                ],
                'styles' => [
                    'bootstrap5'
                ]
            ]
        ];

        $ac = new AssetsCollectionGeneric($scripts, $styles, $collections);
        $ac->setScript('myscript', 'url');
        $ac->setStyle('mystyle', 'mystyleurl');
        $ac->setCollection('standard', ['bootstrap5', 'jquery', 'myscript'], ['axios'], ['bootstrap5', 'mystyle']);
        return $ac;
    }

}
