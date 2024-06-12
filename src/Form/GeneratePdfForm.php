<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class GeneratePdfForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrer la page web que vous souhaitez convertir...',
                    'id' => 'url',
                    'name' => 'url', // Ajout du nom personnalisé
                ],
                'label' => false, // Désactiver l'étiquette
            ])
            ->add('pdfName', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom du fichier',
                    'id' => 'pdfName',
                    'name' => 'pdfName', // Ajout du nom personnalisé
                ],
                'label' => false, // Désactiver l'étiquette
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Convertir en PDF',
                'attr' => [
                    'class' => 'btn-submit',
                ],
            ]);
    }
}
