<?php


namespace Enius\Whereby\Provider\V1\Mapping\Meeting;


class Get
{
    /**
     * @var int
     */
    private $meetingId;
    /**
     * @var string
     */
    private $roomUrl;
    /**
     * @var \DateTimeImmutable
     */
    private $startDate;
    /**
     * @var \DateTimeImmutable
     */
    private $endDate;

    /**
     * @return int
     */
    public function getMeetingId(): int
    {
        return $this->meetingId;
    }

    /**
     * @param int $meetingId
     */
    public function setMeetingId(int $meetingId): void
    {
        $this->meetingId = $meetingId;
    }

    /**
     * @return string
     */
    public function getRoomUrl(): string
    {
        return $this->roomUrl;
    }

    /**
     * @param string $roomUrl
     */
    public function setRoomUrl(string $roomUrl): void
    {
        $this->roomUrl = $roomUrl;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    /**
     * @param string $startDate
     * @throws \Exception
     */
    public function setStartDate(string $startDate): void
    {
        $this->startDate = new \DateTimeImmutable($startDate);
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getEndDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }

    /**
     * @param string $endDate
     * @throws \Exception
     */
    public function setEndDate(string $endDate): void
    {
        $this->endDate = new \DateTimeImmutable($endDate);
    }

}