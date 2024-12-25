<?php

declare(strict_types=1);

namespace App\V1\Service\Crm;

use App\V1\DTO\FeedbackForm\RequestHelpDTO;

class FeedbackForm
{

    const COMPANY_USER_OWNER_ID = 22414;
    const CUSTOMER_USER_OWNER_ID = 23418;

    public static function sendRequestHelp(RequestHelpDTO $dto): bool
    {
        // TODO: Интеграция будет позже
        return true;
    }
}
