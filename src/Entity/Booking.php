<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $work_station_id;

    #[ORM\Column(type: 'string', length: 100)]
    private $user_hash;

    #[ORM\Column(type: 'string', length: 70)]
    private $date;

    #[ORM\Column(type: 'smallint')]
    private $start_time;

    #[ORM\Column(type: 'smallint')]
    private $end_time;

    #[ORM\Column(type: 'smallint')]
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorkStationId(): ?int
    {
        return $this->work_station_id;
    }

    public function setWorkStationId(int $work_station_id): self
    {
        $this->work_station_id = $work_station_id;

        return $this;
    }

    public function getUserHash(): ?string
    {
        return $this->user_hash;
    }

    public function setUserHash(string $user_hash): self
    {
        $this->user_hash = $user_hash;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStartTime(): ?int
    {
        return $this->start_time;
    }

    public function setStartTime(int $start_time): self
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getEndTime(): ?int
    {
        return $this->end_time;
    }

    public function setEndTime(int $end_time): self
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
