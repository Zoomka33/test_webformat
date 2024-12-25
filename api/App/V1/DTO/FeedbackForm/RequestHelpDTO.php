<?php

declare(strict_types=1);

namespace App\V1\DTO\FeedbackForm;

class RequestHelpDTO
{
    const COMPANY = 'company';
    const CUSTOMER = 'customer';

    public function __construct(
        readonly string $type,
        readonly ?string $companyName,
        readonly string $name,
        readonly string $surname,
        readonly string $email,
        readonly string $phone,
        readonly string $comment,
        readonly bool $personalData,
        readonly bool $subscribe,
    )
    {
    }

    public static function createFromArray(array $data): static
    {
        return new static(
            $data['type'],
            $data['companyName'],
            $data['name'],
            $data['surname'],
            $data['email'],
            $data['phone'],
            $data['comment'],
            $data['personalData'],
            $data['subscribe'],
        );
    }

    public function isCompany(): bool
    {
        return $this->getType() == static::COMPANY;
    }

    public function isCustomer(): bool
    {
        return $this->getType() == static::CUSTOMER;
    }
    public function getType(): string
    {
        return $this->type;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function isPersonalData(): bool
    {
        return $this->personalData;
    }

    public function isSubscribe(): bool
    {
        return $this->subscribe;
    }

}
