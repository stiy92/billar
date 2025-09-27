<?php

namespace Francerz\PhpSpreadsheet\Util;

use Francerz\Http\Utils\Constants\MediaTypes;
use Francerz\Http\Utils\HttpFactoryManager;
use PhpOffice\PhpSpreadsheet\Shared\File;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;
use PhpOffice\PhpSpreadsheet\Writer\Ods;
use PhpOffice\PhpSpreadsheet\Writer\Pdf;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Psr\Http\Message\ResponseInterface;

abstract class WriterHelper
{
    private static function getContentType(IWriter $writer) : string
    {
        if ($writer instanceof Xls) {
            return MediaTypes::APPLICATION_VND_MS_EXCEL;
        }
        if ($writer instanceof Xlsx) {
            return MediaTypes::APPLICATION_VND_MS_EXCEL;
        } 
        if ($writer instanceof Ods) {
            return MediaTypes::APPLICATION_VND_OASIS_OPENDOCUMENT_SPREADSHEET;
        }
        if ($writer instanceof Pdf) {
            return MediaTypes::APPLICATION_PDF;
        }
        if ($writer instanceof Csv) {
            return MediaTypes::TEXT_CSV;
        }
        if ($writer instanceof Html) {
            return MediaTypes::TEXT_HTML;
        }
        return MediaTypes::APPLICATION_OCTET_STREAM;
    }

    public static function getPsr7Response(
        IWriter $writer,
        HttpFactoryManager $httpFactories,
        string $filename = 'spreadsheet'
    ) : ResponseInterface {
        $file = tempnam(File::sysGetTempDir(), 'phpsprd');
        $writer->save($file);

        $streamFactory = $httpFactories->getStreamFactory();
        $responseFactory = $httpFactories->getResponseFactory();

        return $responseFactory->createResponse()
            ->withHeader('Content-Type', static::getContentType($writer))
            ->withHeader('Content-Disposition', "attachment;filename=\"{$filename}\"")
            ->withHeader('Cache-Control', 'max-age=0')
            ->withBody($streamFactory->createStreamFromFile($file));
    }
}