<?php
namespace LSite;

class Mysqli extends \mysqli
{
    protected $prefix;

    public function __construct($mysqliConfig)
    {
        @parent::__construct(
            $mysqliConfig['host'],
            $mysqliConfig['username'],
            $mysqliConfig['password'],
            $mysqliConfig['database']
        );

        if ($this->connect_error) {
            throw new \Exception (
                $this->connect_error,
                $this->connect_errno
            );
        }

        $this->set_charset('utf8');
        
        $this->prefix = $mysqliConfig['prefix'];
    }
    
    public function getPrefix() {
        return $this->prefix;
    }

}