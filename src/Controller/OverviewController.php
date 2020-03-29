<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\MovieRepository;
use App\Repository\RatingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class OverviewController extends AbstractController
{

    private MovieRepository $movieRepository;

    private RatingRepository $ratingRepository;

    public function __construct(MovieRepository $movieRepository, RatingRepository $ratingRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->ratingRepository = $ratingRepository;
    }

    /**
     * @Route(path="/", name="overview")
     */
    public function overview(): Response
    {
        return $this->render('Overview/overview.html.twig', [
            'latestMovies' => $this->movieRepository->latestMovies(),
            'ratings' => $this->ratingRepository->getLatestRatings(),
        ]);
    }

}