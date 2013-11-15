<?php
namespace Advert\GeneralBundle\Utils;

use Advert\GeneralBundle\Service\LogFileService;

/**
 * CgvException class extends from \Exception (PHP platform)
 */
class ServiceException extends \Exception
{

    /**
     * Constructor
     *
     * @param type $message
     * @param type $file
     */
    public function __construct($message, $file = 'pagoda.log')
    {
        LogFileService::logFile($file, $message);
        parent::__construct($message);
    }

}

