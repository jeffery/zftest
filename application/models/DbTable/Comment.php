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
 * Application_Model_DbTable_Comment
 * 
 * Provides a data gateway to the database table storing comment data
 * 
 * @author 		Michelangelo <dragonbe+github@gmail.com>
 * @package		Zftest
 * @category	Application_Model
 * @see			Zend_Db_Table_Abstract
 */
class Application_Model_DbTable_Comment extends Zend_Db_Table_Abstract
{
    protected $_name = 'comment';
}

