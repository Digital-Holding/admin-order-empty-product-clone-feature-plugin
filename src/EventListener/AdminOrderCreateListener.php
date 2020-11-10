<?php

namespace DH\ArtisAdminOrderEmptyProductCloneFeaturePlugin\EventListener;

use App\Entity\Channel\ChannelPricing;
use App\Entity\Order\OrderInterface;
use App\Entity\Order\OrderItemInterface;
use App\Entity\Product\ProductVariantInterface;
use App\Factory\Configurator\CreateProductVariantFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use FriendsOfSylius\SyliusImportExportPlugin\Exporter\Plugin\ResourcePlugin;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
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

    /** @var CreateProductVariantFactoryInterface */
    private $createProductVariantFactory;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack, CreateProductVariantFactoryInterface $createProductVariantFactory)
    {
        $this->requestStack = $requestStack;
        $this->pricesRepo = $entityManager->getRepository(ChannelPricing::class);
        $this->variantsRepo = $entityManager->getRepository(ModelProductVariantInterface::class);
        $this->createProductVariantFactory = $createProductVariantFactory;
    }

    public function processOrder(ResourceControllerEvent $event)
    {
        /** @var OrderInterface */
        $subject = $event->getSubject();

        $items = $subject->getItems();
        $channel = $subject->getChannel();

        /** @var OrderItemInterface */
        foreach ($items as $item) {

            /** @var ProductVariantInterface */
            $baseVariant = $item->getVariant();
            if (!$baseVariant->isConfigurable()) {
                continue;
            }

            $newVariant = $this->createProductVariantFactory->createBasedOnVariant($baseVariant->getProduct(), $baseVariant, $channel);
            $item->setVariant($newVariant);
            // foreach ($baseVariant->getOptionAttributeValues() as $value) {
            //     $baseVariant->removeOptionAttributeValue($value);
            // }
        }
    }
}