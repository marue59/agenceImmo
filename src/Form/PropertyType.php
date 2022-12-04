<?php

namespace App\Form;



use App\Entity\Option;
use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre du bien'
            ])
            ->add('description', null, [
                'label' => 'Description'
            ])
            ->add('surface', null, [
                'label' => 'Surface'
            ])
            ->add('rooms', null, [
                'label' => 'Nombre de pièce(s)'
            ])
            ->add('bedrooms', null, [
                'label' => 'Nombre de chambre(s)'
            ])
            ->add('price', null, [
                'label' => 'Prix'
            ])
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getChoices(),
                'label' => 'Type de chauffage',

            ])
            ->add('options', EntityType::class, [
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('city', null, [
                'label' => 'Ville'
            ])
            ->add('adress', null, [
                'label' => 'Adresse'
            ])
            ->add('postal_code', null, [
                'label' => 'Code postal'
            ])
            ->add('sold', null, [
                'label' => 'Vendu'
            ])
            ->add('created_at', null, [
                'label' => 'Créer le : '
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class
        ]);
    }

    // utilisation de la clé comme valeur et de la valeur comme clé ..
    private function getChoices()
    {
        $choices = Property::HEAT;
        $output = [];
        foreach ($choices as $key => $value) {
            $output[$value] = $key;
        }
        return $output;
    }
}
