<?php

namespace Core\Entity\ValueObject;

use Core\Exceptions\DateIsoIsInvalidError;
use DateTime;

class IsoDate {
    private string $isoDate;
    private DateTime $date;

    public function __construct($isoDate)
    {
        $this->validateDate($isoDate);
        $this->isoDate = $isoDate;
        $this->date = new DateTime($isoDate);
    }

    public function getIsoDate()
    {
        return $this->isoDate;
    }

    public function getDateTime()
    {
        return $this->date;
    }

    private function validateDate($dateString)
    {
        $format = 'Y-m-d\TH:i';

        $dateTime = DateTime::createFromFormat($format, $dateString);

        $isValid = $dateTime && $dateTime->format($format) === $dateString;

        if (!$isValid) {
            throw new DateIsoIsInvalidError();
        }
    }

    public function __toString()
    {
        return $this->date->format("d/m/Y H:i");
    }
}
