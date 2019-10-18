<?php

namespace App\Bus\Command;

use Assert\Assert;

class SaveProfileCommand
{

    private $firstName;
    private $lastName;
    private $email;
    private $dateOfBirth;
    private $questionOneAnswer;
    private $questionTwoAnswer;
    private $questionThreeAnswer;
    private $acceptTerms;

    /**
     * SaveProfileCommand constructor.
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $dateOfBirth
     * @param $questionOneAnswer
     * @param $questionTwoAnswer
     * @param $questionThreeAnswer
     * @param $acceptTerms
     */
    public function __construct($firstName, $lastName, $email, $dateOfBirth, $questionOneAnswer, $questionTwoAnswer, $questionThreeAnswer, $acceptTerms)
    {

        Assert::lazy()
            ->that($firstName, 'firstName')->string()->notEmpty()
            ->that($lastName, 'lastName')->string()->notEmpty()
            ->that($email, 'email')->email()
            ->that($dateOfBirth, 'dateOfBirth')->date('Y-m-d')
            ->that($questionOneAnswer, 'question1')->notEmpty()
            ->that($questionTwoAnswer, 'question2')->notEmpty()
            ->that($questionThreeAnswer, 'question3')->notEmpty()
            ->that($acceptTerms, 'acceptTerms')->boolean()->eq(true)
            ->verifyNow();

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->dateOfBirth = $dateOfBirth;
        $this->questionOneAnswer = $questionOneAnswer;
        $this->questionTwoAnswer = $questionTwoAnswer;
        $this->questionThreeAnswer = $questionThreeAnswer;
        $this->acceptTerms = $acceptTerms;
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
    public function getQuestionOneAnswer()
    {
        return $this->questionOneAnswer;
    }

    /**
     * @return mixed
     */
    public function getQuestionTwoAnswer()
    {
        return $this->questionTwoAnswer;
    }

    /**
     * @return mixed
     */
    public function getQuestionThreeAnswer()
    {
        return $this->questionThreeAnswer;
    }

    /**
     * @return mixed
     */
    public function getAcceptTerms()
    {
        return $this->acceptTerms;
    }

}