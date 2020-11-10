<?php

namespace DH\ArtisAdminOrderEmptyProductCloneFeaturePlugin\Subscriber;

use App\Entity\Channel\ChannelPricing;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sylius\Component\Core\Model\ProductVariantInterface as ModelProductVariantInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class AdminOrderCreateListener
{
    /** @var RepositoryInterface */
    private $pricesRepo;

    /** @var RepositoryInterface */
    private $variantsRepo;

    /** @var RequestStack */
    private $requestStack;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $this->pricesRepo = $entityManager->getRepository(ChannelPricing::class);
        $this->variantsRepo = $entityManager->getRepository(ModelProductVariantInterface::class);
    }

    public function processOrder(GenericEvent $event)
    {
        //stub
    }
}