<?php

namespace App\Models;

use App\config\Config;
use Core\Helpers;
use Core\Model;
use PDO;
use PDOException;

class User extends Model
{

    public const TABLE_NAME = 'tasker_users';

    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /**
     * @return array
     */
    public function getSelectableColumns(): array
    {
        return [
            'id',
            'name',
        ];
    }

    /**
     * @param array $data
     *
     * @return User|Model
     */
    public function getByCredentials(array $data)
    {
        $row = [];
        $selectable = $this->getSelectableColumns();
        $name = $data['name'];
        $passwordHash = md5($data['password'] . Config::AUTH_SALT);

        $sql = sprintf(
            'SELECT %2$s FROM `%1$s` WHERE `name`=:name_ AND `password`=:hash_ LIMIT 1',
            self::TABLE_NAME,
            '`' . implode('`, `', $selectable) . '`'
        );

        try {
            $stmn = $this->db->prepare($sql);
            $stmn->bindParam(':name_', $name, PDO::PARAM_STR);
            $stmn->bindParam(':hash_', $passwordHash, PDO::PARAM_STR);
            $stmn->execute();
            $row = $stmn->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $row = $row ?: [];

        return $this->setFields($row);
    }

    /**
     * @param array $formData The form data
     *
     * @return array $data The validity form data
     */
    public function validateLoginForm($formData): array
    {
        $errorsTotal = 0;
        $checkedData = [
            'formData' => [
                'name'     => null,
                'password' => null,
            ],
            'formErrors' => [
                'name'     => null,
                'password' => null,
            ],
            'isValidForm'  => null,
            'isSubmitForm' => false,
            'errorMessage' => [],
        ];

        if (!empty($formData['submit']) && Helpers::isRequestMethod('POST')) {
            unset($formData['submit']);
            // Sanitize POST form data
            $formData = $this->sanitizeForm($formData);

            if (empty($formData['name'])
                || !preg_match('/.{3,60}/', $formData['name'])
            ) {
                ++$errorsTotal;
                $checkedData['formErrors']['name'] = 'The name must be between 3 and 60 characters';
            }

            if (empty($formData['password'])) {
                ++$errorsTotal;
                $checkedData['formErrors']['password'] = 'Password cannot be empty';
            }

            $checkedData['formData'] = $formData;
            $checkedData['formData']['redirectTo'] = $formData['redirect_to'];
            $checkedData['isSubmitForm'] = true;
            $checkedData['isValidForm'] = ($errorsTotal === 0);

            if (!$checkedData['isValidForm']) {
                $checkedData['errorMessage'][] = 'Error. Correctly fill in all the fields in the form';
            }
        }

        $checkedData['isValidForm'] = $checkedData['isValidForm'] ?? true;

        return $checkedData;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'   => $this->getId(),
            'name' => $this->getName(),
        ];
    }

    /**
     * Getter $id
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter $name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Setter $name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
