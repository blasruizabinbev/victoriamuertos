<?php

namespace App\Bus\Command;

use Assert\Assert;

class SaveProfileCommand
{

    private $firstName;
    private $lastName;
    private $email;
    private $dateOfBirth;
    private $offerName;
    private $image;
    private $acceptTerms;
    private $acceptCommercial;

    /**
     * SaveProfileCommand constructor.
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $dateOfBirth
     * @param $offerName
     * @param $image
     * @param $acceptTerms
     * @param $acceptCommercial
     */
    public function __construct($firstName, $lastName, $email, $dateOfBirth, $offerName, $image, $acceptTerms, $acceptCommercial)
    {

        Assert::lazy()
            ->that($firstName, 'firstName')->string()->notEmpty()->maxLength(64)
            ->that($lastName, 'lastName')->string()->notEmpty()->maxLength(64)
            ->that($email, 'email')->email()->maxLength(64)
            ->that($dateOfBirth, 'dateOfBirth')->date('Y-m-d')
            ->that($offerName, 'offerName')->string()->notEmpty()->maxLength(64)
            ->that($image, 'image')->base64()
            ->that($acceptTerms, 'acceptTerms')->boolean()->eq(true)
            ->that($acceptCommercial, 'acceptCommercial')->boolean()
            ->verifyNow();

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->dateOfBirth = $dateOfBirth;
        $this->offerName = $offerName;
        $this->image = $image;
        $this->acceptTerms = $acceptTerms;
        $this->acceptCommercial = $acceptCommercial;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @return mixed
     */
    public function getOfferName()
    {
        return $this->offerName;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function getAcceptTerms()
    {
        return $this->acceptTerms;
    }

    /**
     * @return mixed
     */
    public function getAcceptCommercial()
    {
        return $this->acceptCommercial;
    }

}