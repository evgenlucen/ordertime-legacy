<?php


namespace App\Services\AmoCRM\Interfaces;


interface WebhookTypeInterface
{
    public const LEAD_CHANGE_STATUS = "change_status";
    public const LEAD_ADD = "add";
    public const DELETE_UNSORTED = "delete_unsorted";

}