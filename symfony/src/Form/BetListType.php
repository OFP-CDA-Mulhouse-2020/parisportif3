<?php

namespace App\Form;

use App\Service\SportDataRetriever;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BetListType extends AbstractType
{
    private array $betList;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->getBetList($options['data']['sportData'], $options['data']['sportEvent']->getId());

        foreach ($this->betList as $category => $bet) {
            foreach ($bet as $key => $value) {
                $builder
                    ->add(
                        $category . "_" . $key,
                        CheckboxType::class,
                        [
                            'label' => $value,
                            'required' => false,
                        ]
                    )
                    ->add(
                        $category . "_" . $key . "_Amount",
                        MoneyType::class,
                        [
                            'label' => false,
                            'required' => false,
                        ]
                    );
            }
        }
    }

    public function getBetList(SportDataRetriever $sportDataRetriever, $id): void
    {
        $event = $sportDataRetriever->getEventFromID($id);
        $this->betList = $sportDataRetriever->getBetListFromEvent($event)->listAvailableBets();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                // Configure your form options here
            ]
        );
    }
}
