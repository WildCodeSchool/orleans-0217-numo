<?php
/**
 * Created by PhpStorm.
 * User: fanny
 * Date: 04/07/17
 * Time: 10:49
 */

namespace NumoBundle\Controller;

use NumoBundle\Entity\User;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Controller\ProfileController as BaseController;

class ProfileController extends BaseController
{
    /**
     * Show the user.
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $api = $this->get('numo.apiopenagenda');
        $em = $this->getDoctrine()->getManager();
        $published = $em->getRepository('NumoBundle:Published')->findBy(['author' => $user->getId(), 'deleted' => 0]);
        $uids = [];
        foreach ($published as $pub) {
            $uids[] = $pub->getUid();
        }
        $oaevents = $api->getEvents($uids);

        $events = $em->getRepository('NumoBundle:Event')->findBy(['author' => $user->getId()]);

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
            'uids' => $uids,
            'oaevents' => $oaevents,
            'events' => $events,
        ));
    }

    /**
     * Deletes an image in user entity.
     *
     * @Route("/{id}/delete_image", name="user_delete_image")
     * @Method({"GET", "POST"})
     */
    public function deleteImageAction(User $user)

    {
        $path = $user->getImageUrl();
        $em = $this->getDoctrine()->getManager();
        $user->setImageUrl('');
        $em->flush();
        // effacement du fichier
        unlink($this->getParameter('upload_directory') . '/' .
            $path);
        return $this->redirectToRoute('fos_user_profile_edit', array('id' => $user->getId()));
    }
}