export type ValidationRuleType = (value: any) => true | string;
export type ValidationResultType = true | string;

export function validateRules(rules: ValidationRuleType[], value: any): ValidationResultType[] {
    return rules.map(rule => rule(value)).filter((itm) => itm !== true);
}
