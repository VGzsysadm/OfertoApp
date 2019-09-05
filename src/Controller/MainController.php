<?php

namespace App\Controller;

use App\Entity\User;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;

use App\Entity\GeneralConfig;
use App\Form\GeneralConfigType;
use App\Repository\GeneralConfigRepository;

use App\Entity\Telegram;
use App\Form\TelegramType;
use App\Repository\TelegramRepository;

use App\Service\PhotoUpload;
use App\Service\BotTelegram;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security as coreSecurity;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Contracts\Translation\TranslatorInterface;

use Knp\Component\Pager\PaginatorInterface;

class MainController extends AbstractController
{
    private $session;
    private $security;
    public function __construct(coreSecurity $security)
    {
        $this->session = new Session();
        $this->security = $security;
    }
    /**
     * @Route("/", name="main")
     * @Entity("generalConfig", expr="repository.find(1)")
     * @Entity("telegramconfig", expr="repository.find(1)")
     */
    public function index(Request $request, ProductRepository $productrepo, PhotoUpload $photoupload, PaginatorInterface $paginator, GeneralConfig $generalConfig, GeneralConfigRepository $gconfig, Telegram $telegramconfig, TelegramRepository $tconfig, BotTelegram $telegram, TranslatorInterface $translator)
    {
        // Get user
        $user = $this->getUser();
        
        // Show products

        $entityManager = $this->getDoctrine()->getManager();
        $result = $entityManager->getRepository(Product::class)->findBy(array(), array('id' => 'DESC'));

        // Paginate the results of the query
        $products = $paginator->paginate(
            // Doctrine Query, not results
            $result,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            32
        );

        // Form add new product

        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            if ( $this->security->isGranted('ROLE_ADMIN')) {
                $timestamp = new \DateTime("now");
                $file = $request->files->get('product')['photo'];
                $fileName = $photoupload->upload($file, $product->getName(), $timestamp->getTimestamp());
                $product->setPhoto($fileName);
                $telegram->push($telegramconfig->getApiKey(),$telegramconfig->getChatId(), $product->getName(), $fileName);
                $entityManager->persist($product);
                $entityManager->flush();
                $message = $translator->trans('The product has been created.');
                $this->session->getFlashBag()->add("success", $message);
                return $this->redirectToRoute('main');
            } else {
                $message = $translator->trans('Must have administrator permissions.');
                $this->session->getFlashBag()->add("danger", $message);
                return $this->redirectToRoute('main');
            }
        }

        // Form general config

        $formGeneralConfig = $this->createForm(GeneralConfigType::class, $generalConfig);
        $formGeneralConfig->handleRequest($request);

        if ($formGeneralConfig->isSubmitted() && $formGeneralConfig->isValid()) {
            if ( $this->security->isGranted('ROLE_ADMIN')) {
                $timestamp = new \DateTime("now");
                $file = $request->files->get('general_config')['logo'];
                $fileName = $photoupload->logo($file, $generalConfig->getsiteName(), $timestamp->getTimestamp());
                $generalConfig->setLogo($fileName);
                $entityManager->persist($generalConfig);
                $entityManager->flush();
                $message = $translator->trans('Information updated.');
                $this->session->getFlashBag()->add("success", $message);
                return $this->redirectToRoute('main');
            } else {
                $message = $translator->trans('Must have administrator permissions.');
                $this->session->getFlashBag()->add("danger", $message);
                return $this->redirectToRoute('main');
            }
        }

        // Form telegram config

        $formTelegram = $this->createForm(TelegramType::class, $telegramconfig);
        $formTelegram->handleRequest($request);

        if ($formTelegram->isSubmitted() && $formTelegram->isValid()) {
            if ( $this->security->isGranted('ROLE_ADMIN')) {
            $entityManager->persist($telegramconfig);
            $entityManager->flush();
            $message = $translator->trans('Information updated.');
            $this->session->getFlashBag()->add("success", $message);
            return $this->redirectToRoute('main');
            } else {
                $message = $translator->trans('Must have administrator permissions.');
                $this->session->getFlashBag()->add("danger", $message);
                return $this->redirectToRoute('main');
            }
        }

        return $this->render('main/index.html.twig',
        array('form' => $form->createView(),
                'generalconfig' => $generalConfig,
                'products' => $products,
                'formconfig' => $formGeneralConfig->createView(),
                'gconfig' => $gconfig->findOneBy(array('id' => 1)),
                'formtelegram' => $formTelegram->createView(),
            )
        );
    }
    /**
     * @Route("/product-finish/{id}", name="finish", methods={"GET","POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function finishProduct(Product $product, $id, TranslatorInterface $translator)
    {  
        $entityManager = $this->getDoctrine()->getManager();
        // Checking finished product
        $product = $entityManager->getRepository(Product::class)->find($id);
        $check = $product->getFinish();
        if ( $check == 0 ){
            // Finishing the product
            $product->setFinish(true);
            $entityManager->persist($product);
            $entityManager->flush();
            $message = $translator->trans('Information updated.');
            $this->session->getFlashBag()->add("success", $message);
            return $this->redirectToRoute('main');
        }
        if ( $check == 1 ){
            // Unfinishing the product
            $product->setFinish(false);
            $entityManager->persist($product);
            $entityManager->flush();
            $message = $translator->trans('Information updated.');
            $this->session->getFlashBag()->add("success", $message);
            return $this->redirectToRoute('main');
            }

    }
}
