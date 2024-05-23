<?php
// tests/Entity/PdfTest.php
namespace App\Tests\Entity;

use App\Entity\Pdf;
use PHPUnit\Framework\TestCase;

class PdfTest extends TestCase
{
    public function testGetterAndSetter()
    {
        $pdf = new Pdf();

        $title = 'PDF Title';
        $createdAt = new \DateTimeImmutable();

        $pdf->setTitle($title);
        $pdf->setCreatedAt($createdAt);

        $this->assertEquals($title, $pdf->getTitle());
        $this->assertEquals($createdAt, $pdf->getCreatedAt());
    }
}
