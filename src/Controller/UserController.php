<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UserController extends AbstractController
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route(path="/uzivatele", name="user_list")
     */
    public function list(): Response
    {
        return $this->render('User/list.html.twig', [
            'users' => $this->userRepository->getByRatingsCount()
        ]);
    }

}