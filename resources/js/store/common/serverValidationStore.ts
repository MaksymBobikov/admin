import { reactive } from 'vue';
import { ValidationErrorsInterface } from '../../domain/interfaces/validation/ValidationErrorsInterface';

export const serverValidationStore = reactive({
    errorMessages: { } as ValidationErrorsInterface,
    initErrorMessages(fieldNames: string[]) {
        fieldNames.forEach((name) => {
            this.errorMessages[name] = [];
        });
    },
    setErrorMessages(errorsData) {
        Object.keys(errorsData).forEach((key) => {
            this.errorMessages[key] = errorsData[key] || [];
        });
    },
    clearAll() {
        this.errorMessages = {};
    },
    clearByName(name) {
        this.errorMessages[name] = [];
    }
});
