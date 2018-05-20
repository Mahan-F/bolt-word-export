<?php

namespace Bolt\Extension\WordExport;

use Symfony\Component\HttpFoundation\Response;

class WordResponse extends Response
{
    protected $data;

    protected $filename;

    /**
     * CsvResponse constructor.
     * @param array $data
     * @param $filename
     * @param int $status
     * @param array $headers
     */
    public function __construct($data, $filename, $status = 200, array $headers = [])
    {
        parent::__construct('', $status, $headers);

        $this->setFilename($filename . '.doc');
        $this->setData($data);
    }

    public function setData($data)
    {

        $handle = fopen($this->getFilename(), "w");
        fwrite($handle, $data);
        fclose($handle);

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($this->getFilename()));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($this->getFilename()));
        readfile($this->getFilename());

    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
        return true;
    }

}
