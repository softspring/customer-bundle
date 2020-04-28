<?php

namespace Softspring\CustomerBundle\Controller\Settings;

use Softspring\CoreBundle\Controller\AbstractController;
use Softspring\CoreBundle\Event\ViewEvent;
use Softspring\CustomerBundle\Form\Settings\SourcesStripeAddCardForm;
use Softspring\CustomerBundle\Manager\SourceManagerInterface;
use Softspring\CustomerBundle\Model\CustomerInterface;
use Softspring\CustomerBundle\Model\SourceInterface;
use Softspring\CustomerBundle\SfsCustomerEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class SourcesController extends AbstractController
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var SourceManagerInterface
     */
    protected $sourcesManager;

    /**
     * SourcesController constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param SourceManagerInterface   $sourcesManager
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, SourceManagerInterface $sourcesManager)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->sourcesManager = $sourcesManager;
    }

    public function list(CustomerInterface $customer, Request $request): Response
    {
        $viewData = new \ArrayObject([
            'customer' => $customer,
        ]);

        $this->eventDispatcher->dispatch(new ViewEvent($viewData), SfsCustomerEvents::SETTINGS_SOURCES_LIST_VIEW);

        return $this->render('@SfsCustomer/setting/sources/list.html.twig', $viewData->getArrayCopy());
    }

    public function stripeAddCard(CustomerInterface $customer, Request $request): Response
    {
        $form = $this->createForm(SourcesStripeAddCardForm::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $source = $this->sourcesManager->createEntity();
            $source->setType(SourceInterface::TYPE_CARD);
            $source->setPlatformToken($data['stripeToken']);
            $customer->addSource($source);

            if ($data['setDefault']) {
                $customer->setDefaultSource($source);
            }

            $this->sourcesManager->saveEntity($source);

            return $this->redirectToRoute('sfs_customer_settings_sources_list');
        }

        $viewData = new \ArrayObject([
            'form' => $form->createView(),
        ]);

        // $this->eventDispatcher->dispatch(new ViewEvent($viewData), SfsCustomerEvents::SETTINGS_SOURCES_LIST_VIEW);

        return $this->render('@SfsCustomer/setting/sources/stripe_add_card.html.twig', $viewData->getArrayCopy());
    }
}