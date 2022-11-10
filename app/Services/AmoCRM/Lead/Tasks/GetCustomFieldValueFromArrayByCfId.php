<?php


namespace App\Services\AmoCRM\Lead\Tasks;


class GetCustomFieldValueFromArrayByCfId
{
    /**
     * Получение значений дополнительных полей
     *
     * @param array $customFields - массив доп. полей сущности (контакта, компании или сделки), но
     *                              без жёской типизации как array т.к. иногда передаём null, когда нет доп. полей
     * @param int $id - id доп. поля, значение которого надо найти
     * @param bool $enum - вернуть поле enum или value
     * @return null|mixed
     */
    public static function run(array $customFields, int $id, bool $enum = false)
    {
        foreach ($customFields as $field) {
            if ($field['id'] == $id) {
                if (isset($field['values'][0])) {
                    // там поля с датой без value
                    if (isset($field['values'][0][$enum?'enum':'value'])) {
                        return $field['values'][0][$enum?'enum':'value'];
                    } else {
                        return $field['values'][0];
                    }
                } elseif(!empty($field['values'][$enum?'enum':'value'])) {
                    // выбранный элемент из радио кнопок без доп. массива отдаются
                    return $field['values'][$enum?'enum':'value'];
                } else {
                    continue;
                }
            }
        }

        return null;
    }

}