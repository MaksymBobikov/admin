import axios from 'axios';
import { authStore } from '@/store/auth/authStore';
import { notifyError } from '@/services/ui/notifyService';
import { serverValidationStore } from '@/store/common/serverValidationStore';
import { isLoadingStore } from '@/store/common/isLoadingStore';

const token = document.head.querySelector('meta[name="csrf-token"]');
const baseURL = `${envData.APP_URL}`;
const appAxios = axios.create({
    baseURL,
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': token?.content || ''
    }
});

async function onSuccess(response) {
    isLoadingStore.loading = false;

    return response;
}

async function onError(error) {
    isLoadingStore.loading = false;

    if (error.response.status === 401) {
        authStore.setAuthUser(null);
    }

    if (error.response.status === 422) {
        serverValidationStore.setErrorMessages(error?.response?.data?.errors || {});
    }

    notifyError(error?.response?.data?.message || 'Error');

    return error.response;
}

appAxios.interceptors.response.use(onSuccess, onError)

export const apiClient = {
    setAuthToken(token) {
        appAxios.defaults.headers.Authorization = `Bearer ${token}`
    },

    get(url, data = {}, configs = {}) {
        isLoadingStore.loading = true;

        return appAxios.get(url,{
            ...configs,
            params: data,
        })
    },

    post(url, data = {}, configs = {}) {
        isLoadingStore.loading = true;

        return appAxios.post(url, data, configs)
    },
}
