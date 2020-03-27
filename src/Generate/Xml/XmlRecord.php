<?php

namespace Bifei\FastXml\Generate\Xml;

use Carbon\Carbon;

class XmlRecord
{
    protected $filePath;
    protected $topLable;

    public function __construct()
    {

    }

    protected function generate($xmlData)
    {
        $this->fileExists($this->filePath, $this->topLable);
        $doc = new \DOMDocument();
        $doc->load($this->filePath);
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
        $monthCount = $doc->getElementsByTagName('_' . Carbon::now()->isoFormat('YY_MM'))->item(0);
        if ($monthCount) {
            $monthCount->nodeValue = intval($monthCount->nodeValue) + $count;
        } else {
            $monthCount = $doc->getElementsByTagName('monthCount');
            $monthCountElement = $doc->createElement('_' . Carbon::now()->isoFormat('YY_MM'));
            $monthCountValue = $doc->createTextNode($count);
            $monthCountElement->appendChild($monthCountValue);
            $monthCount->item(0)->appendChild($monthCountElement);
        }
        $doc->appendChild($sitemap);
        $doc->save($filePath);
    }

    protected function getLastRecord($type)
    {
        $xmlRecord = simplexml_load_file($this->recordPath);
        $recordArr = json_decode(json_encode($xmlRecord), TRUE);
        // 获取最后一个记录的值
        $last = end($recordArr);
        return $last[$type] ?? end($last)[$type];
    }


    protected function XmlRecordExists($filePath, $topLable)
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $grandFather = $doc->createElement($topLable);
        $month = $doc->createElement('monthCount');
        $grandFather->appendChild($month);
        $doc->appendChild($grandFather);
        $doc->save($filePath);
    }
}