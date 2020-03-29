<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RatingRepository")
 */
class Rating
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="ratings")
     */
    private User $user;

    /**
     * @ORM\ManyToOne(targetEntity="Movie", inversedBy="ratings")
     */
    private Movie $movie;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $rating = null;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $comment = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $created;

    public function __construct(Movie $movie, User $user)
    {
        $this->movie = $movie;
        $this->user = $user;
        $this->created = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function getMovie(): Movie
    {
        return $this->movie;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCreated(): DateTime
    {
        return $this->created;
    }

}
