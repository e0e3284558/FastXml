<?php

namespace Bifei\FastXml\Record;

class Record
{
    use XmlRecord;
    protected $recordPath = '';

    /**
     * 获取xml记录
     * @param string $type
     * @return string|null
     */
    protected function getXmlRecord($type = 'last_id')
    {
        if (!file_exists($this->recordPath)) {
            //如果文件不存在，则创建文件
            $this->XmlRecordExists($this->recordPath, 'Document');
        }
        return $this->getLastRecord($type);
    }

    protected function getTxtRecord()
    {

    }


}