<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Rating;
use App\Form\AddCommentFormType;
use App\Form\AddMovieFormType;
use App\Repository\MovieRepository;
use App\Repository\RatingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class MovieController extends AbstractController
{

    private MovieRepository $movieRepository;

    private RatingRepository $ratingRepository;

    public function __construct(MovieRepository $movieRepository, RatingRepository $ratingRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->ratingRepository = $ratingRepository;
    }

    /**
     * @Route(path="/film/{slug}", name="movie_detail")
     */
    public function detail(Movie $movie): Response
    {
        return $this->render('Movie/detail.html.twig', [
            'movie' => $movie,
            'ratings' => $this->ratingRepository->findByMovie($movie)
        ]);
    }

    /**
     * @Route(path="/filmy", name="movie_list")
     */
    public function list(): Response
    {
        return $this->render('Movie/list.html.twig', [
            'movies' => $this->movieRepository->bestMovies(),
        ]);
    }

    /**
     * @Route(path="/film/{slug}/ohodnotit", name="movie_comment")
     */
    public function comment(Movie $movie, Request $request)
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $rating = $this->ratingRepository->findUserRating($movie, $user) ?? new Rating($movie, $user);
        $form = $this->createForm(AddCommentFormType::class, $rating);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Film úspěšně ohodnocen.');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rating);
            $entityManager->flush();
            return new RedirectResponse($this->generateUrl('movie_detail', [
                'slug' => $movie->getSlug(),
            ]));
        }

        return $this->render('Movie/comment.html.twig', [
            'commentForm' => $form->createView(),
            'movie' => $movie,
        ]);
    }

    /**
     * @Route(path="/pridat-film", name="movie_add")
     */
    public function add(Request $request)
    {
        $form = $this->createMovieForm($request, fn (Movie $movie) => $this->generateUrl('movie_detail', [
            'slug' => $movie->getSlug()
        ]));

        return $this->render('Movie/add.html.twig', [
            'addMovieForm' => $form->createView(),
        ]);
    }

    private function createMovieForm(Request $request, callable $onSuccess): FormInterface
    {
        $movie = new Movie();
        $form = $this->createForm(AddMovieFormType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Film úspěšně přidán.');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($movie);
            $entityManager->flush();
            $onSuccess($movie);
        }

        return $form;
    }

}