<?php

namespace App\Entity;

use App\Bus\Command\SaveProfileCommand;
use Doctrine\ORM\Mapping as ORM;
use MediaMonks\Doctrine\Mapping\Annotation as MediaMonks;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Table
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Profile
{

    const QUERY_DEFAULT_LIMIT = 10;

    const OFFER_VARIATIONS = 3;

    const MOD_PENDING = 'pending';
    const MOD_APPROVED = 'approved';
    const MOD_DENIED = 'denied';

    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="string", unique=true, length=36)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $uuid;

    /**
     * @ORM\Column(type="string")
     * @MediaMonks\Transformable(name="encrypt")
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string")
     * @MediaMonks\Transformable(name="encrypt")
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string")
     * @MediaMonks\Transformable(name="encrypt")
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     * @MediaMonks\Transformable(name="encrypt")
     */
    protected $dateOfBirth;

    /**
     * @ORM\Column(type="integer", length=1, nullable=true)
     */
    protected $questionOneAnswer;

    /**
     * @ORM\Column(type="integer", length=1, nullable=true)
     */
    protected $questionTwoAnswer;

    /**
     * @ORM\Column(type="integer", length=1, nullable=true)
     */
    protected $questionThreeAnswer;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $acceptTerms;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $acceptCommercial;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @MediaMonks\Transformable(name="encrypt")
     */
    protected $offerName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $offerVariation = 0;

    /**
     * @ORM\Column(type="string")
     */
    protected $modStatus = self::MOD_PENDING;

    public static function createFromCommand(SaveProfileCommand $command)
    {
        $self = (new self())
            ->setFirstName($command->getFirstName())
            ->setLastName($command->getLastName())
            ->setEmail($command->getEmail())
            ->setDateOfBirth($command->getDateOfBirth())
            ->setAcceptTerms($command->getAcceptTerms())
            ->setAcceptCommercial($command->getAcceptCommercial())
            ->setOfferName($command->getOfferName())
            ->setOfferVariation(mt_rand(1,Profile::OFFER_VARIATIONS))
            ->setModStatus(self::MOD_PENDING)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
        ;
        $self->uuid = (Uuid::uuid4())->toString();
        return $self;

    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     * @return Profile
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     * @return Profile
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Profile
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param mixed $dateOfBirth
     * @return Profile
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuestionOneAnswer()
    {
        return $this->questionOneAnswer;
    }

    /**
     * @param mixed $questionOneAnswer
     * @return Profile
     */
    public function setQuestionOneAnswer($questionOneAnswer)
    {
        $this->questionOneAnswer = $questionOneAnswer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuestionTwoAnswer()
    {
        return $this->questionTwoAnswer;
    }

    /**
     * @param mixed $questionTwoAnswer
     * @return Profile
     */
    public function setQuestionTwoAnswer($questionTwoAnswer)
    {
        $this->questionTwoAnswer = $questionTwoAnswer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuestionThreeAnswer()
    {
        return $this->questionThreeAnswer;
    }

    /**
     * @param mixed $questionThreeAnswer
     * @return Profile
     */
    public function setQuestionThreeAnswer($questionThreeAnswer)
    {
        $this->questionThreeAnswer = $questionThreeAnswer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAcceptTerms()
    {
        return $this->acceptTerms;
    }

    /**
     * @param mixed $acceptTerms
     * @return Profile
     */
    public function setAcceptTerms($acceptTerms)
    {
        $this->acceptTerms = $acceptTerms;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAcceptCommercial()
    {
        return $this->acceptCommercial;
    }

    /**
     * @param mixed $acceptCommercial
     * @return Profile
     */
    public function setAcceptCommercial($acceptCommercial)
    {
        $this->acceptCommercial = $acceptCommercial;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return Profile
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOfferName()
    {
        return $this->offerName;
    }

    /**
     * @param mixed $offerName
     * @return Profile
     */
    public function setOfferName($offerName)
    {
        $this->offerName = $offerName;
        return $this;
    }

    /**
     * @return int
     */
    public function getOfferVariation()
    {
        return $this->offerVariation;
    }

    /**
     * @param int $offerVariation
     * @return Profile
     */
    public function setOfferVariation($offerVariation)
    {
        $this->offerVariation = $offerVariation;
        return $this;
    }

    /**
     * @return string
     */
    public function getModStatus()
    {
        return $this->modStatus;
    }

    /**
     * @param string $modStatus
     * @return Profile
     */
    public function setModStatus($modStatus)
    {
        $this->modStatus = $modStatus;
        return $this;
    }

    public function __toString()
    {
        return (string)$this->getUuid();
    }

}