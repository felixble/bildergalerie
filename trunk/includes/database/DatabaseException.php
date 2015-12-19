<?php
/**
 * Description of DatabaseException
 *
 * @author Felix
 */
class DatabaseException extends Exception {
    
    private $mysqlError;
    private $date;
    private $script;
    private $referer;
    
    public function __construct($message, $mysqlError, $date, $script, $referer) {
        parent::__construct($message);
        $this->mysqlError = $mysqlError;
        $this->date = $date;
        $this->script = $script;
        $this->referer = $referer;
    }
}
