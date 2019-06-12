<?php

require __DIR__ . '/vendor/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberFormat;


/**
 * parse and returns phone number
 */
function parsePhonenumber($number)
{
    try {
        $number = PhoneNumber::parse("+{$number}");
        return $number->format(PhoneNumberFormat::E164);
    }
    catch (\Exception $e) {
        return '';
    }
}



/**
 * read xlsx and returns data and header
 */
function readSheet($filepath) 
{
    $data = [];
    $header = [];
    $reader = ReaderEntityFactory::createXLSXReader();
    $reader->open($filepath);

    foreach ($reader->getSheetIterator() as $sheet) {
        foreach ($sheet->getRowIterator() as $index => $row) {

            $cells = $row->getCells();

            /** push header name */
            if($index == 1) {
                $header[] = $cells[0]->getValue();
                $header[] = $cells[1]->getValue();
                $header[] = $cells[2]->getValue();
                continue;
            }

            /** push data */
            $data[] = [
                $cells[0]->getValue(),
                $cells[1]->getValue(),
                parsePhonenumber($cells[2]->getValue())
            ];
        }
    }

    $reader->close();

    return [$header, $data];

}



/** 
 * send json response
 */
function sendJsonResponse($success, $type, $message, $data = [])
{

    header("Content-type: application/json");
    
    $response = new \stdClass();
    $response->success = $success;
    $response->type = $type;
    $response->message = $message;
    $response->data = $data;

    $jsonString = json_encode($response);
    echo $jsonString;
    exit;
    
}