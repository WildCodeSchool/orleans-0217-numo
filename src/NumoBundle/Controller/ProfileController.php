<?php
/**
 * Created by PhpStorm.
 * User: fanny
 * Date: 04/07/17
 * Time: 10:49
 */

namespace NumoBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
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
}