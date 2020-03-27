<?php

namespace Bifei\FastXml\Generate\Xml;

use Carbon\Carbon;
use Illuminate\Support\Arr;

class CreateXml
{
    protected $filePath;
    protected $topLable;
    protected $attribute;
    protected $type;

    /**
     * 根据array生成XML
     * @param $xmlData
     */
    public function generate($xmlData = [])
    {
        $doc = new \DOMDocument('1.0', 'utf-8');//引入类并且规定版本编码
        $grandFather = $doc->createElement($this->topLable);//创建节点
        // 判断节点是否有属性值，有属性则添加
        if (Arr::has($this->attribute, $this->topLable)) {
            $grandFather->setAttribute($this->attribute[$this->topLable]['key'], $this->attribute[$this->topLable]['value']);//给Grandfather增加ID属性
        }
        foreach ($xmlData as $data) {
            foreach ($data as $key => $val) {
                $father = $doc->createElement($key);//创建节点
                if (Arr::has($this->attribute, $key)) {
                    $grandFather->setAttribute($this->attribute[$key]['key'], $this->attribute[$key]['value']);//给Grandfather增加ID属性
                }
                $grandFather->appendChild($father);//讲Father放到Grandfather下
                if (is_array($val)) {
                    // 如果是数组，递归去拆解添加对象
                    $val = $this->recursion($val, $doc, $father, $type);
                    $father->appendChild($val);//将标签内容赋给标签
                } else {
                    if ($type == 'text') {
                        $content = $doc->createTextNode($val);//设置标签内容
                    } else {
                        $content = $doc->createCDATASection($val);//设置CDATA标签内容
                    }
                    $father->appendChild($content);//将标签内容赋给标签
                }
            }
        }
        $doc->appendChild($grandFather);//创建顶级节点
        $doc->save($this->filePath);//保存xml
    }

    /**
     * 递归处理数组类型的xmls
     * @param array $list
     * @param $dom
     * @param $father
     * @return mixed
     */
    public function recursion($list = [], &$dom, &$father, $type)
    {
        foreach ($list as $key => $item) {
            $son = $dom->createElement($key);
            $father->appendChild($son);
            if (is_array($item)) {
                // 如果还有下级则继续拆解
                $item = $this->recursion($item, $dom, $son, $type);
                $son->appendChild($item);
                $father->appendChild($son);
            } else {
                if ($type == 'text') {
                    $item = $dom->createTextNode($item);
                } else {
                    $item = $dom->createCDATASection($item);
                }
                $son->appendChild($item);
                $father->appendChild($son);
            }
        }
        return $son;
    }
}