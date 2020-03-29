<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\String\Slugger\AsciiSlugger;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 */
class Movie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @var Collection<\App\Entity\Rating>
     * @ORM\OneToMany(targetEntity="Rating", mappedBy="movie")
     */
    private Collection $ratings;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $title = '';

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $slug;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private string $description = '';

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private string $imageUrl = '';

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private DateTime $created;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=1, nullable=true)
     */
    private ?string $overallRating;

    function __construct()
    {
        $this->created = new DateTime();
        $this->ratings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function getCreated(): DateTime
    {
        return $this->created;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
        $this->slug = (new AsciiSlugger())->slug($this->title)->toString();
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getOverallRating(): ?string
    {
        return $this->overallRating;
    }

    public function setOverallRating(?float $overallRating): void
    {
        if ($overallRating === null) {
            $this->overallRating = null;
            return;
        }

        if ($overallRating >= 0.0 && $overallRating <= 100.0) {
            $this->overallRating = (string) $overallRating;
            return;
        }

        throw new Exception(sprintf('Rating must be in (0, 100) range \'%s\' provided.', $overallRating));
    }

    /**
     * @return Collection<\App\Entity\Rating>
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function getStarsCount(): int
    {
        return round($this->overallRating / 20.0);
    }

}
