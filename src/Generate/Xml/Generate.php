<?php

namespace Bifei\FastXml\Generate\Xml;

use Ramsey\Uuid\Uuid;

class Generate extends CreateXml
{

    /**
     * 顶级标签
     * @var string
     */
    protected $topLable = '';

    /**
     * 节点属性
     * @var array
     *  [
     *      'labelName' => [
     *          'key' => 'attributeKey',
     *          'value' => 'value'
     *      ],
     *  ]
     */
    protected $attribute = [];

    /**
     * 节点属性为普通的节点还是CDATA节点
     * @var string  text|CDATA
     */
    protected $type = 'text';

    /**
     * 生成文件存储目录 根目录
     * @var string
     */
    protected $filePath = '';

    /**
     * 文件名
     * @var string
     */
    protected $fileName = '';

    /**
     * 上次生成记录文件地址
     * @var string
     */
    protected $recordPath = '';

    /**
     * 每次生成的数量
     * @var int
     */
    protected $limit = 100;

    /**
     * 最后一次生成的id
     * @var int
     */
    protected $last_id = 0;



    /**
     * 通过记录文件获取最后一次生成的id
     */
    protected function getLastId()
    {
        $extension = end(explode('.', $this->recordPath));
        switch ($extension) {
            case 'xml':
                $lastId = $this->getXmlRecord();
                break;
            case 'txt':
                $lastId = $this->getTxtRecord();
                break;
            default:
                break;
        }
    }

    /**
     * 设置本次执行完成后的id
     */
    protected function setLastId()
    {

    }

    /**
     * 设置顶级标题
     * @param $lable
     * @return $this
     */
    public function setTopLable($lable='')
    {
        $this->topLable = $lable;
        return $this;
    }

    /**
     * 设置属性值
     * @param $attribute
     * @return $this
     */
    public function setAttribute($attribute=[])
    {
        $this->attribute = $attribute;
        return $this;
    }

    public function setType($type)
    {

    }

    /**
     * 设置文件地址
     * @param $path
     * @return $this
     */
    public function setFilePath($path): string
    {
        $this->filePath = $path;
        return $this;
    }

    /**
     * 设置文件名
     * @param string $fileName
     * @param string $type
     * @return string
     * @throws \Exception
     */
    public function setFileName($fileName = '', $type = 'xml'): string
    {
        if (empty($fileName)) {
            $this->fileName = $this->GeneRandomName($type);
        } else {
            $this->fileName = $fileName . '.' . $type;
        }
        return $this;
    }

    /**
     * 生成随机的文件名
     * @param string $type
     * @return string
     * @throws \Exception
     */
    protected function GeneRandomName($type = 'xml'): string
    {
        return Uuid::uuid4()->toString() . '.' . $type;
    }


}