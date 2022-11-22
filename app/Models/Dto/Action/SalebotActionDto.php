<?php


namespace App\Models\Dto\Action;


class SalebotActionDto
{
    public ?string $message = '';
    public ?array $vars = [];

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'vars' => $this->vars
        ];
    }


}
