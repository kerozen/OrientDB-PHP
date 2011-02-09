<?php

class OrientDBCommandRecordDelete extends OrientDBCommandAbstract
{
	protected $clusterId;

	protected $recordId;

	protected $recordType;

	protected $version;

	public function __construct($parent)
	{
		parent::__construct($parent);
		$this->type = OrientDBCommandAbstract::RECORD_DELETE;
	}

	public function prepare()
	{
		parent::prepare();
		$record_ids = explode(':', $this->attribs[0]);
        if (count($record_ids) != 2) {
            throw new OrientDBException('Wrong format for record ID');
        }

        $this->clusterId = (int) $record_ids[0];
        $this->recordId = (int) $record_ids[1];
	   if (count($this->attribs) > 1) {
            $this->version = (int) $this->attribs[1];
        } else {
            $this->version = -1;
        }
        // Add ClusterId
        $this->addShort($this->clusterId);
        // Add RecordId
        $this->addLong($this->recordId);
        // Add version
        $this->addInt($this->version);
	}

	protected function parse()
	{
        $result = $this->readByte();
        if ($result == chr(1)) {
        	return true;
        } else {
        	return false;
        }

	}

}