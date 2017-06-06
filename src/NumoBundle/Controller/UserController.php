<?php
/**
 * Created by PhpStorm.
 * User: fanny
 * Date: 06/06/17
 * Time: 22:21
 */

namespace NumoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function promoteUser()
    {
        $userManager = $this->get('fos_user.user_manager');

        // Use findUserby, findUserByUsername() findUserByEmail() findUserByUsernameOrEmail,
        // findUserByConfirmationToken($token) or findUsers()
        $user = $userManager->findUserBy(['id' => 1]);

        // Add the role that you want !
        $user->addRole("ROLE_ADHERENT");
        // Update user roles
        $userManager->updateUser($user);
    }

    public function demoteUser()
    {
        $userManager = $this->get('fos_user.user_manager');

        // Use findUserby, findUserByUsername() findUserByEmail() findUserByUsernameOrEmail,
        // findUserByConfirmationToken($token) or findUsers()
        $user = $userManager->findUserBy(['id' => 1]);

        // Add the role that you want !
        $user->addRole("ROLE_USER");
        // Update user roles
        $userManager->updateUser($user);
    }

    public function promoteModerateur()
    {
        $userManager = $this->get('fos_user.user_manager');

        // Use findUserby, findUserByUsername() findUserByEmail() findUserByUsernameOrEmail,
        // findUserByConfirmationToken($token) or findUsers()
        $user = $userManager->findUserBy(['id' => 1]);

        // Add the role that you want !
        $user->addRole("ROLE_MODERATOR");
        // Update user roles
        $userManager->updateUser($user);
    }
}