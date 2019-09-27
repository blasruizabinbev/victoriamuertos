<?php

namespace App\Exceptions;

use Assert\InvalidArgumentException;
use MediaMonks\RestApi\Exception\AbstractValidationException;
use MediaMonks\RestApi\Exception\ErrorField;
use MediaMonks\RestApi\Response\Error;
use Symfony\Component\Form\FormError;

class AssertException extends AbstractValidationException
{
    const FIELD_ROOT = '#';
    /**
     * @var
     */
    private $command;
    /**
     * @var FormError
     */
    private $violations;
    /**
     * @param  $command
     * @param array $violations
     */
    public function __construct($command, array $violations)
    {
        parent::__construct('Not all fields where filled in correctly.', Error::CODE_FORM_VALIDATION);
        $this->command    = $command;
        $this->violations = $violations;
    }
    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->toErrorArray();
    }
    /**
     * @return array
     */
    public function getFields()
    {
        return $this->toErrorArray();
    }
    /**
     * @return array
     */
    protected function toErrorArray()
    {
        $errors = [];
        /** @var InvalidArgumentException $violation */
        foreach ($this->violations as $violation) {
            $errors[] = new ErrorField(
                $this->getErrorCode($violation->getPropertyPath()), $violation->getCode(), $violation->getMessage());
        }
        return $errors;
    }
    /**
     * @param FormError $error
     * @return string
     */
    protected function getErrorCodeByMessage(FormError $error)
    {
        if (stristr($error->getMessage(), Error::FORM_TYPE_CSRF)) {
            return $this->getErrorCode(Error::FORM_TYPE_CSRF);
        }
        return $this->getErrorCode(Error::FORM_TYPE_GENERAL);
    }
    /**
     * @param string $value
     * @return string
     */
    protected function getErrorCode($value)
    {
        return $value;
    }
}