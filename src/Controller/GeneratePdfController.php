<?php

namespace App\Controller;

use App\Entity\Pdf;
use App\Form\GeneratePdfForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GeneratePdfController extends AbstractController
{
    private $params;
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }
    #[Route('/generate/pdf', name: 'app_generate_pdf')]
    public function generatePdf(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $subscription = $user->getSubscription();
        $pdfLimit = $subscription ? $subscription->getPdfLimit() : 10; // 10 par défaut si aucune souscription
        $currentPdfCount = count($user->getPdfs());

        // Create a form
        $form = $this->createForm(GeneratePdfForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier si l'utilisateur a atteint sa limite de PDF
            if ($currentPdfCount >= $pdfLimit) {
                $this->addFlash('error', 'Vous avez atteint votre limite de PDF. <br> Veuillez passer à un <a href="' . $this->generateUrl('app_subscription') . '">abonnement supérieur</a> pour continuer.');
                return $this->redirectToRoute('app_generate_pdf');
            }

            $pdfName = $form->getData()['pdfName'];
            $url = $form->getData()['url'];

            // Créer une instance HttpClient
            $client = HttpClient::create();

            $microServiceUrl = $this->params->get('micro_service_url');

            // Envoyer la requête POST à l'URL spécifiée avec le paramètre 'url'
            $response = $client->request('POST', $microServiceUrl, [

                'body' => [
                    'url' => $url,
                ]
            ]);

            $content = $response->getContent();

            // generate a random file name
            $randomFileName = uniqid('pdf_') . '.pdf';

            // path
            $filePath = 'uploads/' . $randomFileName;

            // Download the PDF
            $pdf = fopen($filePath, 'w');
            fwrite($pdf, $content);
            fclose($pdf);

            // add the pdf in the pdf entity
            $pdf = new Pdf();
            $pdf->setTitle($pdfName);
            $pdf->setOwner($this->getUser());
            $pdf->setCreatedAt(new \DateTimeImmutable());
            $pdf->setPath($filePath);

            // save the pdf in the database
            $entityManager->persist($pdf);
            $entityManager->flush();

            // Redirect to the PDF display route
            return $this->redirectToRoute('app_show_pdf', ['id' => $pdf->getId()]);
        }

        return $this->render('generate_pdf/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/generate/pdf/{id}', name: 'app_show_pdf')]
    public function showPdf(int $id, EntityManagerInterface $entityManager): Response
    {
        $pdf = $entityManager->getRepository(Pdf::class)->find($id);

        if (!$pdf) {
            throw $this->createNotFoundException('The PDF does not exist');
        }

        return $this->render('generate_pdf/show.html.twig', [
            'pdf' => $pdf,
        ]);
    }
}