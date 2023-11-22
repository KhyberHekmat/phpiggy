<?php

declare(strict_types=1);

namespace Framework;

use Framework\Contracts\RuleInterface;
use Framework\Exceptions\ValidationException;

class Validator
{

    private array $rules = [];
    public function add(string $alias, RuleInterface $rule)
    {
        $this->rules[$alias] = $rule;
    }
    public function validate(array $formData, array $fields)
    {
        $errors = [];
        foreach ($fields as $filedName => $rules) {
            foreach ($rules as $rule) {
                $ruleValidator = $this->rules[$rule];
                if ($ruleValidator->validate($formData, $filedName, [])) {
                    continue;
                }
                $errors[$filedName][] = $ruleValidator->getMessage(
                    $formData,
                    $filedName,
                    []
                );
            }
        }
        if (count($errors)) {
            throw new ValidationException($errors);
        }
    }
}
