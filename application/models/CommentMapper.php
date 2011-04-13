<?php
/**
 * Zftest
 * 
 * 
 * This source code is used as example code for presentations I give at several
 * PHP conferences around the world. You're free to use, build on-top of it and
 * share with others. You can find this source code on my public GitHub account
 * {@link https://github.com/DragonBe/zftest} where you can fork this code,
 * provide comments and feedback or just play with it.
 * 
 * @license		CreativeCommons-Attribution-ShareAlike
 * @link 		http://creativecommons.org/licenses/by-sa/3.0/
 * @package		Zftest
 */
/**
 * Application_Model_CommentMapper
 * 
 * Provides a mapping between the comment class and the data storage
 * 
 * @author 		Michelangelo <dragonbe+github@gmail.com>
 * @package		Zftest
 * @category	Application_Model
 */
class Application_Model_CommentMapper
{
    /**
     * @var 	Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Sets the data gateway to link the comment class to the database
     * 
     * @param 	string|Zend_Db_Table_Abstract $dbTable
     * @return	Application_Model_CommentMapper
     * @throws 	Zend_Exception
     */
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
    /**
     * Retrieves the data gateway from this mapper class
     * 
     * @return	Zend_Db_table_Abstract
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Comment');
        }
        return $this->_dbTable;
    }
    /**
     * Finds a single instance of a comment from the database by a provided
     * primary key ID and the current used comment class instance.
     * 
     * @param 	int $id
     * @param 	Application_Model_Comment $comment
     * @return	Application_Model_CommentMapper
     */
    public function find($id, Application_Model_Comment $comment)
    {
        $resultSet = $this->getDbTable()->find($id);
        if (!empty ($resultSet)) {
            $comment->populate($resultSet->current());
        }
        return $this;
    }
    /**
     * Fetches a single row matching optionally provided conditions and/or
     * optionally provided order sequence
     * 
     * @param 	Application_Model_Comment $comment
     * @param 	null|string|array $where
     * @param 	null|string|array $order
     * @return	Application_Model_CommentMapper
     */
    public function fetchRow(Application_Model_Comment $comment, $where = null, $order = null)
    {
        $row = $this->getDbTable()->fetchRow($where, $order);
        if (!empty ($row)) {
            $comment->populate($row);
        }
        return $this;
    }
    /**
     * Fetches all results matching optionally provided conditions, sorting
     * order, count and offset and returns an array containing objects of type
     * Application_Model_Comment.
     * 
     * @param 	null|string|array $where
     * @param 	null|string|array $order
     * @param 	null|int $count
     * @param 	null|int $offset
     * @return	array
     */
    public function fetchAll($where = null, $order = null, $count = null, $offset = null)
    {
        $entries = array ();
        $resultSet = $this->getDbTable()->fetchAll($where, $order, $count, $offset);
        foreach ($resultSet as $row) {
            $entries[] = new Application_Model_Comment($row);
        }
        return $entries;
    }
    /**
     * Saves an instance of Application_Model_Comment into the database.
     * 
     * @param 	Application_Model_Comment $comment
     */
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
    /**
     * Deletes an instance of Application_Model_Comment
     * 
     * @param 	Application_Model_Comment $comment
     * @return	Application_Model_CommentMapper
     */
    public function delete(Application_Model_Comment $comment)
    {
        $this->getDbTable()->delete(array ('id = ?' => $comment->getId()));
        return $this;
    }
}

