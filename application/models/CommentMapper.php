<?php

class Application_Model_CommentMapper
{
    protected $_dbTable;
    
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable;
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Zend_Exception('Invalid data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Comment');
        }
        return $this->_dbTable;
    }
    public function find($id, Application_Model_Comment $comment)
    {
        $resultSet = $this->getDbTable()->find($id);
        if (!empty ($resultSet)) {
            $comment->populate($resultSet->current());
        }
        return $this;
    }
    public function fetchRow(Application_Model_Comment $comment, $where = null, $order = null)
    {
        $row = $this->getDbTable()->fetchRow($where, $order);
        if (!empty ($row)) {
            $comment->populate($row);
        }
        return $this;
    }
    public function fetchAll($where = null, $order = null, $count = null, $offset = null)
    {
        $entries = array ();
        $resultSet = $this->getDbTable()->fetchAll($where, $order, $count, $offset);
        foreach ($resultSet as $row) {
            $entries[] = new Application_Model_Comment($row);
        }
        return $entries;
    }
    public function save(Application_Model_Comment $comment)
    {
        $data = $comment->toArray();
        unset ($data['id']);
        if (0 < $comment->getId()) {
            $this->getDbTable()->update($data, array ('id = ?' => $comment->getId()));
        } else {
            $this->getDbTable()->insert($data);
        }
    }
    public function delete(Application_Model_Comment $comment)
    {
        $this->getDbTable()->delete(array ('id = ?' => $comment->getId()));
        return $this;
    }
}

