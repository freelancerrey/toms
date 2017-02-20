<?php
namespace App\Services;

use App\Repositories\OrderTypeRepository;

class OrderTypeService
{

    private $orderTypeRepository;

    public function __construct(
        OrderTypeRepository $orderTypeRepository
    ) {
        $this->orderTypeRepository = $orderTypeRepository;
    }

    public function getMappings()
    {

        $orderTypes = $this->orderTypeRepository->getAllActive();

        $orderTypesDetails = [];
        $formIds = [];

        foreach ($orderTypes as $orderType) {

            $orderTypesDetails[$orderType['id']] = $orderType['type'];

            $mappings = explode('|', $orderType['mapping']);

            foreach ($mappings as $mapping) {
                $fieldMap = explode(':', $mapping);
                $formIds[$fieldMap[0]] = [$orderType['id'], explode(',', $fieldMap[1])];
            }

        }

        return [
            'types' => $orderTypesDetails,
            'forms' => $formIds
        ];

    }

}
