<?php
/**
 * Created by PhpStorm.
 * User: wilder10
 * Date: 01/07/17
 * Time: 18:07
 */

namespace NumoBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;


class UploadFileController extends Controller
{

    /**
     * @Route("/uploadimage", name="upload_image")
     * @Method("POST")
     */
    public function uploadImageAction(Request $request)
    {
//        if ($request->isXmlHttpRequest()) {


            // retrieve the file with the name given in the form.
            // do var_dump($request->files->all()); if you need to know if the file is being uploaded.
//            $file = $request->files->get('upload');
//            $status = array('status' => "success","fileUploaded" => false);
//            // If a file was uploaded
//            if(!is_null($file)){
//                // generate a random name for the file but keep the extension
//                $fileName = $this->getParameter('server_url').'/'.$this->getParameter('img_event_dir').'/'.uniqid().'.'.$file->guessExtension();
//                $file->move(
//                    $this->getParameter('tmp_dir'),
//                    $fileName
//                );
//                $status = array('status' => "success","fileUploaded" => true);
//            }
//            return new JsonResponse($status);


//        }
    }
}