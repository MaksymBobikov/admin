import { apiClient } from '@/js/utilites/apiClient';
import { LoginDataInterface } from '@/js/domain/interfaces/auth/LoginDataInterface';
import { RegisterDataInterface } from '@/js/domain/interfaces/auth/RegisterDataInterface';
import { ForgotPasswordInterface } from '@/js/domain/interfaces/auth/ForgotPasswordInterface';
import { ResetPasswordDataInterface } from '@/js/domain/interfaces/auth/ResetPasswordDataInterface';

export async function checkAuthUser(): Promise<any> {
    const response = await apiClient.get('/admin/auth/check');

    return response?.data?.user || null;
}

export async function loginUser(data: LoginDataInterface): Promise<any> {
    return apiClient.post('/admin/auth/login', data);
}

export async function logoutUser(): Promise<boolean> {
    const { data } = await apiClient.post('/admin/auth/logout');

    if (data?.success) {
        return true
    }

    return false;
}

export async function registerUser(data: RegisterDataInterface): Promise<any> {
    return apiClient.post('/admin/auth/register', data);
}

export async function forgotPassword(data: ForgotPasswordInterface): Promise<any> {
    return apiClient.post('/admin/forgot-password', data);
}

export async function updatePassword(data: ResetPasswordDataInterface): Promise<any> {
    return apiClient.post('/admin/reset-password', data);
}

export async function verifyEmail(id: number, hash: string, query: any = {}): Promise<any> {
    const searchParams = new URLSearchParams(query);

    return apiClient.get(`/admin/email/verify/${id}/${hash}?${searchParams.toString()}`);
}
