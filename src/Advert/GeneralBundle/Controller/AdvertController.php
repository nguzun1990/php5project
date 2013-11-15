<?php

namespace Advert\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Advert\GeneralBundle\Form\AdvertType;
use Advert\GeneralBundle\Utils\ServiceException;
use Advert\GeneralBundle\Entity\Advert;

/**
 * AdvertController class -  controller for Advert class
 */
class AdvertController extends Controller
{
    /**
     * @var message for invalid object Id
     */
    static private $errorResponseMessage = 'Some errors occurred!';

    /**
     * Controller for home page
     *
     * @return response
     *
     * @Route("/", name="advert_home")
     * @Template()
     */
    public function indexAction()
    {
        try {
            $advertService = $this->get('advert.advertservice');
            $adverts = $advertService->getList(5);

            return $this->render('AdvertGeneralBundle:Advert:index.html.twig', array('adverts' => $adverts));
        } catch (ServiceException $exc) {

            return new Response(self::$errorResponseMessage);
        } catch (\Exception $exc) {
            $logFileService = $this->get('advert.logfileservice');
            $logFileService::logFile('pagoda.log', 'Pagoda App - Error on indexAction from AdvertController ' . $exc->getMessage());

            return new Response(self::$errorResponseMessage);
        }
    }

    /**
     * Controller for list of adverts
     *
     * @return mixed response
     *
     * @Route("/list", name="advert_list")
     * @Template()
     */
    public function listAction()
    {
        try {
            $advertService = $this->get('advert.advertservice');
            $adverts = $advertService->getList();

            return $this->render('AdvertGeneralBundle:Advert:list.html.twig', array('adverts' => $adverts));
        } catch (ServiceException $exc) {

            return new Response(self::$errorResponseMessage);
        } catch (\Exception $exc) {
            $logFileService = $this->get('advert.logfileservice');
            $logFileService::logFile('pagoda.log', 'Pagoda App - Error on listAction from AdvertController ' . $exc->getMessage());

            return new Response(self::$errorResponseMessage);
        }
    }

    /**
     * Controller for list content of adverts
     *
     * @return mixed response
     *
     * @Route("/list/content", name="advert_list_content")
     * @Template()
     */
    public function listContentAction()
    {
        try {
            $advertService = $this->get('advert.advertservice');
            $adverts = $advertService->getList();

            return $this->render('AdvertGeneralBundle:Advert:listContent.html.twig', array('adverts' => $adverts));
        } catch (ServiceException $exc) {

            return new Response(self::$errorResponseMessage);
        } catch (\Exception $exc) {
            $logFileService = $this->get('advert.logfileservice');
            $logFileService::logFile('pagoda.log', 'Pagoda App - Error on listContentAction from AdvertController ' . $exc->getMessage());

            return new Response(self::$errorResponseMessage);
        }
    }

    /**
     * Controller for adding an advert
     *
     * @return mixed response
     *
     * @Route("/add", name="advert_add")
     * @Template()
     */
    public function addAction()
    {
        try {
            $advertService = $this->get('advert.advertservice');
            $advert = new Advert();
            $photo = $advert->getPhoto();
            $request = $this->getRequest();
            $form = $this->createForm(new AdvertType(), $advert);
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                if ($form->isValid()) {
                    $success = $advertService->insert($advert);
                    if ($success) {
                        $result = $this->redirect($this->generateUrl('advert_list'));
                    } else {
                        $result = new Response(self::$errorResponseMessage);
                    }
                } else {
                    $result = $this->render('AdvertGeneralBundle:Advert:update.html.twig', array(
                        'advert' => $advert,
                        'form' => $form->createView(),
                        'photo' => $photo
                            ));
                }
            } else {
                $result = $this->render('AdvertGeneralBundle:Advert:update.html.twig', array(
                    'advert' => $advert,
                    'form' => $form->createView(),
                    'photo' => $photo
                        ));
            }

            return $result;
        } catch (ServiceException $exc) {

            return new Response(self::$errorResponseMessage);
        } catch (\Exception $exc) {
            $logFileService = $this->get('advert.logfileservice');
            $logFileService::logFile('pagoda.log', 'Pagoda App - Error on addAction from AdvertController ' . $exc->getMessage());

            return new Response(self::$errorResponseMessage);
        }
    }

    /**
     * Controller for updating an advert
     *
     * @param integer $advertId Advert ID
     *
     * @return mixed response
     *
     * @Route("/update/{advertId}", name="advert_update")
     * @Template()
     */
    public function updateAction($advertId)
    {
        try {
            $advertService = $this->get('advert.advertservice');
            $advert = $advertService->get($advertId);
            $request = $this->getRequest();
            $photo = $advert->getPhoto();
            $form = $this->createForm(new AdvertType(), $advert);
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                if ($form->isValid()) {
                    $success = $advertService->update($advert);
                    if ($success) {
                        $result = $this->redirect($this->generateUrl('advert_list'));
                    } else {
                        $result = new Response(self::$errorResponseMessage);
                    }
                } else {
                    $result = $this->render('AdvertGeneralBundle:Advert:update.html.twig', array(
                        'advert' => $advert,
                        'form' => $form->createView(),
                        'photo' => $photo
                            ));
                }
            } else {
                $result = $this->render('AdvertGeneralBundle:Advert:update.html.twig', array(
                    'advert' => $advert,
                    'form' => $form->createView(),
                    'photo' => $photo
                        ));
            }

            return $result;
        } catch (ServiceException $exc) {

            return new Response(self::$errorResponseMessage);
        } catch (\Exception $exc) {
            $logFileService = $this->get('advert.logfileservice');
            $logFileService::logFile('pagoda.log', 'Pagoda App - Error on updateAction from AdvertController - advertId ' . $advertId . ' ' . $exc->getMessage());

            return new Response(self::$errorResponseMessage);
        }
    }

    /**
     * Controller for deleting an advert
     *
     * @param integer $advertId Advert ID
     *
     * @return mixed response
     *
     * @Route("/delete/{advertId}", name="advert_delete")
     * @Template()
     */
    public function deleteAction($advertId)
    {
        try {
            $advertService = $this->get('advert.advertservice');
            $success = $advertService->remove($advertId);
            if ($success) {
                $result = new Response('success');
            } else {
                $result = new Response('error');
            }

            return $result;
        } catch (ServiceException $exc) {

            return new Response(self::$errorResponseMessage);
        } catch (\Exception $exc) {
            $logFileService = $this->get('advert.logfileservice');
            $logFileService::logFile('pagoda.log', 'Pagoda App - Error on deleteAction from AdvertController - advertId ' . $advertId . ' ' . $exc->getMessage());

            return new Response(self::$errorResponseMessage);
        }
    }

    /**
     * Controller for deleting many adverts
     *
     * @return mixed response
     *
     * @Route("/delete", name="adverts_delete")
     * @Template()
     * @Method({"POST"})
     */
    public function deleteManyAction()
    {
        try {
            $nrSuccess = 0;
            $nrError = 0;
            $advertService = $this->get('advert.advertservice');
            $request = $this->getRequest();
            if ($request->getMethod() == "POST") {
                $advertIds = $request->request->get("adverts");
                $expectedNrSuccess = count($advertIds);
                if (!empty($advertIds)) {
                    foreach ($advertIds as $advertId) {
                        $success = $advertService->remove($advertId);
                        if ($success) {
                            $nrSuccess++;
                        } else {
                            $nrError++;
                        }
                    }
                }
            }
            if (($nrSuccess == $expectedNrSuccess) && ($nrError == 0)) {
                $result = new Response('success');
            } else {
                $result = new Response('error');
            }

            return $result;
        } catch (ServiceException $exc) {

            return new Response(self::$errorResponseMessage);
        } catch (\Exception $exc) {
            $logFileService = $this->get('advert.logfileservice');
            $logFileService::logFile('pagoda.log', 'Pagoda App - Error on deleteManyAction from AdvertController - advertId ' . $exc->getMessage());

            return new Response(self::$errorResponseMessage);
        }
    }

    /**
     * Controller for advert view details
     *
     * @param integer $advertId Advert ID
     *
     * @return mixed response
     *
     * @Route("/view/{advertId}", name="advert_view")
     * @Template()
     */
    public function viewAction($advertId)
    {
        try {

            $advertService = $this->get('advert.advertservice');
            $advert = $advertService->get($advertId);

            return $this->render('AdvertGeneralBundle:Advert:view.html.twig', array('advert' => $advert));
        } catch (ServiceException $exc) {

            return new Response(self::$errorResponseMessage);
        } catch (\Exception $exc) {
            $logFileService = $this->get('advert.logfileservice');
            $logFileService::logFile('pagoda.log', 'Pagoda App - Error on viewAction from AdvertController ' . $exc->getMessage());

            return new Response(self::$errorResponseMessage);
        }
    }

    /**
     * Controller for advert search
     *
     * @return mixed response
     *
     * @Route("/search", name="advert_search")
     * @Template()
     * @Method({"POST"})
     */
    public function searchAction()
    {
        try {
            $adverts = array();
            $request = $this->getRequest();
            if ($request->getMethod() == "POST") {
                $sentence = $request->request->get("sentence");
                $advertService = $this->get('advert.advertservice');
                $adverts = $advertService->getListSearch($sentence);
            }

            return $this->render('AdvertGeneralBundle:Advert:listContent.html.twig', array('adverts' => $adverts));
        } catch (ServiceException $exc) {

            return new Response(self::$errorResponseMessage);
        } catch (\Exception $exc) {
            $logFileService = $this->get('advert.logfileservice');
            $logFileService::logFile('pagoda.log', 'Pagoda App - Error on searchAction from AdvertController ' . $exc->getMessage());

            return new Response(self::$errorResponseMessage);
        }
    }

    /**
     * Controller for about page
     *
     * @return response
     *
     * @Route("/about", name="advert_about")
     * @Template()
     */
    public function aboutAction()
    {
        try {
            return $this->render('AdvertGeneralBundle:Advert:about.html.twig');
        } catch (\Exception $exc) {
            $logFileService = $this->get('advert.logfileservice');
            $logFileService::logFile('pagoda.log', 'Pagoda App - Error on aboutAction from AdvertController ' . $exc->getMessage());

            return new Response(self::$errorResponseMessage);
        }
    }

}