<?php declare(strict_types=1);

namespace App\Command;

use App\Repository\MovieRepository;
use App\Service\Movie\OverallRatingCalculator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OverallRatingCommand extends Command
{

    protected static $defaultName = 'movie:overall-rating';

    private MovieRepository $movieRepository;
    private OverallRatingCalculator $overallRatingCalculator;

    public function __construct(MovieRepository $movieRepository, OverallRatingCalculator $overallRatingCalculator)
    {
        parent::__construct();
        $this->movieRepository = $movieRepository;
        $this->overallRatingCalculator = $overallRatingCalculator;
    }

    protected function configure()
    {
        $this->setDescription('Update average rating for Movie entity');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $movies =  $this->movieRepository->findAll();
        foreach ($movies as $movie) {
            $movie->setOverallRating(
                $this->overallRatingCalculator->calculateOverallRating($movie)
            );
            $this->movieRepository->update($movie);
        }
        return 0;
    }
}