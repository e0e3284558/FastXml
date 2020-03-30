<?php

namespace Bifei\FastXml\Generate\Xml;

class SiteMap
{
    /**
     * siteMap地址
     * @var string
     */
    public $siteMapPath = '';

    public $attribute = [];

    public $topLable = '';

    /**
     * 根据array生成XML
     * @param $xmlData
     */
    public function generate($xmlData = [])
    {
        $this->fileExists($this->siteMapPath, $this->topLable);
        $doc = new \DOMDocument();
        $doc->load($this->siteMapPath);
        $sitemap = $doc->getElementsByTagName($this->topLable)->item(0);  //找到文件追加的位置

        foreach ($xmlData as $key => $value) {
            $newsitemap = $doc->createElement($key);
            foreach ($value as $k => $v) {
                $elementName = $doc->createElement($k);
                $textValue = $doc->createTextNode($v);
                $elementName->appendChild($textValue);
                $newsitemap->appendChild($elementName);
            }
            $comment = $doc->createTextNode('');
            $newsitemap->appendChild($comment);
        }
        $sitemap->appendChild($newsitemap);
        $doc->appendChild($sitemap);
        $doc->save($this->siteMapPath);
    }


    /**
     * 判断文件是否存在，如果不存在则创建xml文件，并创建根节点
     * @param $filePath
     * @param $topLable
     * @return bool
     */
    public function fileExists($filePath, $topLable)
    {
        if (!file_exists($filePath)) {
            $doc = new \DOMDocument('1.0', 'utf-8');
            $grandFather = $doc->createElement($topLable);
            $content = $doc->createTextNode('');
            $grandFather->appendChild($content);
            $doc->appendChild($grandFather);
            $doc->save($filePath);
        }
        return true;
    }

    /**
     * 设置站点地图
     * @param $siteMapPath
     * @return $this
     */
    public function setSiteMapPath($siteMapPath)
    {
        $this->siteMapPath = $siteMapPath;
        return $this;
    }

    /**
     * 设置属性
     * @param $attribute
     * @return $this
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
        return $this;
    }

    /**
     * 设置最外层的标签值
     * @param $topLable
     * @return $this
     */
    public function setTopLable($topLable='')
    {
        $this->topLable = $topLable;
        return $this;
    }
}
