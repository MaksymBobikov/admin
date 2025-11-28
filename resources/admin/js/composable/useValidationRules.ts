import { useRules } from 'vuetify/labs/rules';
import {ValidationRuleType} from "@/js/services/validation/validationService";

export function useValidationRules(rules: any[]): ValidationRuleType[] {
    const validationRules = useRules();

    const rulesMapping = {
        required: validationRules.required,
        email: validationRules.email,
        number: validationRules.number,
        integer: validationRules.integer,
        capital: validationRules.capital,
        maxLength: validationRules.maxLength,
        minLength: validationRules.minLength,
        strictLength: validationRules.strictLength,
        exclude: validationRules.exclude,
        notEmpty: validationRules.notEmpty,
        pattern: validationRules.pattern,
    };

    const getValidationMethod = (rule: any) => {
        if (typeof rule === 'string') {
            return rulesMapping[rule] ? rulesMapping[rule]() : null;
        }

        if (Array.isArray(rule)) {
            const [ruleName, ...params] = rule;

            return rulesMapping[ruleName] ? rulesMapping[ruleName](...params) : null;
        }

        if (typeof rule === 'function') {
            return rule;
        }

        return null;
    };

    const resultRules: ValidationRuleType[] = [];

    rules.forEach(rule => {
        const ruleInstance = getValidationMethod(rule);

        if (ruleInstance) {
            resultRules.push(ruleInstance);
        }
    });

    return resultRules;
}
