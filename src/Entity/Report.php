<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Entity\Traits\UserableTrait;
use App\Repository\ReportRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReportRepository::class)
 */
class Report
{
    use TimestampableTrait;
    use UserableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="float")
     */
    private $avg_temp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ip;

    public function __construct(
        string $city,
        float $avg_temp,
        string $ip,
        ?User $user
    )
    {
        $this->city = $city;
        $this->avg_temp = $avg_temp;
        $this->ip = $ip;
        $this->createdBy = $user;
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getAvgTemp(): ?float
    {
        return $this->avg_temp;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }
}
