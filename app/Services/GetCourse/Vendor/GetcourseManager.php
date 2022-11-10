<?php

namespace App\Services\GetCourse\Vendor;



use App\Services\GetCourse\Vendor\Operation\CreateDealOperation;
use App\Services\GetCourse\Vendor\Operation\CreateUserOperation;
use App\Services\GetCourse\Vendor\Operation\ExportDealsOperation;
use App\Services\GetCourse\Vendor\Operation\ExportUsersOperation;
use App\Services\GetCourse\Vendor\Operation\UserGroupOperation;

class GetcourseManager
{
    /**
     * @var GetcourseClient
     */
    public $client;

    public function __construct(GetcourseClient $client)
    {
        $this->client = $client;
    }

    public function userGroups(): UserGroupOperation
    {
        return new UserGroupOperation($this->client);
    }

    public function createUser(): CreateUserOperation
    {
        return new CreateUserOperation($this->client);
    }

    public function createDeal(): CreateDealOperation
    {
        return new CreateDealOperation($this->client);
    }

    public function exportUsers(): ExportUsersOperation
    {
        return new ExportUsersOperation($this->client);
    }

    public function exportDeals(): ExportDealsOperation
    {
        return new ExportDealsOperation($this->client);
    }
}