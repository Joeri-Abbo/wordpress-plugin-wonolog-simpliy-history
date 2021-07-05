<?php
namespace WonologSimplyHistory;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

class ErrorHandler extends AbstractProcessingHandler
{
    private $initialized = false;

    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);
    }

    protected function write(array $record): void
    {
        if (!$this->initialized) {
            $this->initialize();
        }


        if (class_exists('Simplelogger')) {

            $error = $this->check_value($record['message']);

            $context = [
                'uri'           => $this->check_value($_SERVER['REQUEST_URI']),
                'host'          => $this->check_value($_SERVER['HTTP_HOST']),
                'message'       => $error,
                'file'          => !empty($record['context']['file']) ? $this->check_value($record['context']['file']) : '',
                'line'          => !empty($record['context']['line']) ? $this->check_value($record['context']['line']) : '',
                'level'         => $this->check_value($record['level']),
                'level_name'    => $this->check_value($record['level_name']),
                'channel'       => $this->check_value($record['channel']),
                'is_admin'      => $this->check_value($record['extra']['wp']['is_admin']),
                '_user_id'       => !empty($record['extra']['wp']['user_id']) ? $this->check_value($record['extra']['wp']['user_id']) : '',
            ];

            $message = sprintf('[%s] Wonolog triggered the following "%s"', 'DEBUG', $error);

            if ($record['level_name'] == 'DEBUG'){
                SimpleLogger()->debug($message , $context);
            } else {
                SimpleLogger()->warning($message, $context);
            }
        }
    }

    public function check_value($value){
        return !empty($value) ? $value : '';
    }

    private function initialize()
    {
        $this->initialized = true;
    }
}
